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

class AppleController extends Controller
{
    /**
     * Displays a list of apples.
     *
     * @var \common\models\Apple $apples
     */
    public function actionIndex()
    {
        // Получаем все яблоки из базы данных
        $apples = Apple::find()->all();

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
        $colors = ['red', 'green', 'yellow','rainbow'];
        return $colors[array_rand($colors)];
    }


    // Другие методы контроллера (например, управление яблоками) добавляем тут
}
