<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Apple */

$form = ActiveForm::begin([
    'action' => ['apple/eat', 'id' => $model->id],
    'method' => 'post',
]);
?>

<div class="apple-detail-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'color',
            'appearanceDate:datetime',
            'fallDate:datetime',
            'status',
            'size',
        ],
    ]) ?>

    <div class="form-group">
        <?= $form->field($model, 'percent')->textInput(['type' => 'number', 'min' => 0, 'max' => 100]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Съесть', ['class' => 'btn btn-success']) ?>
    </div>

    <?= Html::a('Уронить яблоко с дерева', ['apple/fall-from-tree', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите уронить яблоко с дерева?',
            'method' => 'post',
        ],
    ]) ?>
</div>

<?php ActiveForm::end(); ?>
