<?php

/*
 *
 *
 *
 *
 * */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Apple;
use yii\web\NotFoundHttpException;

class AppleController extends Controller
{
    /**
     * Displays a list of apples.
     *
     * @var \common\models\Apple $apples
     */
    public function actionIndex()
    {
        // Получаем все яблоки из базы данных, Кроме съеденных
        $apples = Apple::find()->where(['!=', 'status', Apple::STATUS_EATEN])->all();

        //Не, ну это БАЗА
        $dataProvider = new ActiveDataProvider([
            'query' => Apple::find(),
        ]);
        // Отображаем страницу с яблоками
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'apples' => $apples
        ]);
    }


    public function actionGenerateRandomApple()
    {
        $color = $this->getRandomColor(); // Ваш метод для выбора случайного цвета
        $randomApple = Apple::generateRandomApple($color);

        // Сохраняем случайное яблоко в базе данных
        $randomApple->save();

        // Перенаправляем пользователя обратно на страницу со списком яблок
        return $this->redirect(['index']);
    }

    private function getRandomColor()
    {
        $colors = ['red', 'green', 'purple', 'ghost', 'blue'];
        return $colors[array_rand($colors)];
    }


    // Другие методы контроллера (например, управление яблоками) добавляем тут

    /**
     * Действие для отображения DetailView по ID.
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetailView($id)
    {
        $model = Apple::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Яблоко с ID $id не найдено.");
        }

        return $this->renderAjax('_detail-view', [
            'model' => $model,
        ]);
    }

    /**
     * Действие для броска яблока с дерева.
     * Проверяет, что яблоко на дереве, уроняет его и сохраняет в базе данных.
     * @param int $id Идентификатор яблока.
     * @return string Рендерит представление `_detail-view.php` после выполнения действия.
     * @throws NotFoundHttpException Если яблоко с указанным ID не найдено.
     */
    public function actionFallFromTree($id)
    {
        $model = Apple::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Яблоко с ID $id не найдено.");
        }

        $model->fallFromTree();

        return $this->redirect(['index']);

    }

    public function actionEat($id)
    {
        $model = Apple::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Яблоко с ID $id не найдено.");
        }

        if ($model->load(Yii::$app->request->post())) {
            try {
                $model->eatPercent($model->percent);
                $model->save();
                Yii::$app->session->setFlash('success', 'Яблоко успешно съедено.');
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->redirect(['index']);
    }


}
