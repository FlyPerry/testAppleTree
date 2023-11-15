<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Apple */

?>
<div class="apple-detail-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'color',
            'appearanceDate:datetime', // Форматируем дату в формат datetime
            'fallDate:datetime',
            'status',
            'size',
        ],
    ]) ?>
</div>
