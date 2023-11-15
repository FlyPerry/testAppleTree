<?php

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\Apple $apples
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Список яблок';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?= Html::a('Сгенерировать случайное яблоко', ['generate-random-apple'], ['class' => 'btn btn-success']) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'color',
        'size',
        [
            'class' => 'yii\grid\ActionColumn',
//            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id]);
                },
            ],
        ],
    ],
]); ?>

<?php if ($apples): ?>
    <?= DetailView::widget([
        'model' => $apples,
        'attributes' => [
            'id',
            'color',
            'appearanceDate:datetime',
            'fallDate:datetime',
            'status',
            'size',
        ],
    ]) ?>
<?php endif; ?>
