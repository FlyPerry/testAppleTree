<?php

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var   common\models\Apple $apples
 * */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Список яблок';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= Html::a('Сгенерировать случайное яблоко', ['generate-random-apple'], ['class' => 'btn btn-success']) ?>

<?php
foreach ($apples as $apple) {
    echo Html::img('@web/images/apple1280.png', [
            'class' => ['apple_' . $apple->color, 'grid-view-item']
            , 'style' => ['width' => '120px']
            , 'alt' => 'yabloko_' . $apple->id
            , 'data' => ['id' => $apple->id]
        ]);
}
?>
<div class="modal fade" id="detail-view-modal" tabindex="-1" role="dialog" aria-labelledby="detail-view-modal-label"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail-view-modal-label">Детали яблока</h5>
            </div>
            <div class="modal-body" id="detail-view-container">
                <!-- Сюда будет вставлено содержимое DetailView -->
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$(document).on('click', '.grid-view-item', function () {
    var id = $(this).data('id');
    $.ajax({
        url: '/apple/detail-view?id=' + id, 
        type: 'GET',
        success: function (data) {
            $('#detail-view-container').html(data);
            $('#detail-view-modal').modal('show');
        },
        error: function () {
            alert('Произошла ошибка при загрузке данных.');
        }
    });
});
JS;

$this->registerJs($script, \yii\web\View::POS_READY);
?>

