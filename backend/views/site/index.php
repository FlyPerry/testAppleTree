<?php

use Yii;
use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
echo Html::a(Html::img('@web/images/apple1280.png', ['style' => ['height' => '90vh']]), ['/apple']);
echo '<div class="wrap">'
    . Html::button('Нажми на меня', ['id' => 'runaway-button', 'class' => 'runaway-button'])
    .'</div>';


$js = <<<JS
$(document).ready(function () {
    var button = $('#runaway-button');
    
    button.on('click',function () {
        moveButton();
    });
    
    function moveButton() {
        var maxX = $(window).width() - button.width();
        var maxY = $(window).height() - button.height();
        
        var newX = Math.random() * maxX;
        var newY = Math.random() * maxY;
        
        button.animate({ left: newX, top: newY }, 200, function () {
            button.text(randomWord());
        });
    }
    
    function randomWord(){
        var wordsArray = ['Хей, я тут!', 'щекотно', 'Отвали от меня', 'ДА СКОЛЬКО МОЖНО?😒', 'Тыкни на 🍎'];
        var randomIndex = Math.floor(Math.random() * wordsArray.length);
        var randomWord = wordsArray[randomIndex];
        return  randomWord;
    }
});

JS;

$this->registerJs($js, $this::POS_READY);
?>


