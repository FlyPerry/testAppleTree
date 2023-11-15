<?php

namespace common\models;

use Psr\Log\NullLogger;
use Yii;
use yii\db\ActiveRecord;
use yii\base\Exception;

class Apple extends ActiveRecord
{
    public $percent;
    const STATUS_ON_TREE = 'on_tree';
    const STATUS_ON_GROUND = 'on_ground';
    const STATUS_ROTTEN = 'rotten';
    const STATUS_EATEN = 'eaten';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'appearanceDate', 'status', 'size'], 'required'],
            [['appearanceDate', 'fallDate'], 'integer'],
            [['status'], 'string'],
            [['size','percent'], 'number'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'appearanceDate' => 'Дата созревания',
            'fallDate' => 'Дата падения с дерева',
            'status' => 'Статус',
            'size' => 'Целостность',
        ];
    }

    /**
     * Инициализация яблока
     *
     * @param string $color
     */
    public function initApple($color)
    {
        $this->color = $color;
        $this->appearanceDate = time();
        $this->status = self::STATUS_ON_TREE;
        $this->size = 1.0;
    }

    /**
     * Генерирует случайное яблоко
     *
     * @param string $color
     * @return Apple
     */
    public static function generateRandomApple($color)
    {
        $apple = new Apple();
        $apple->initApple($color);

        return $apple;
    }

    /**
     * Яблоко падает на землю
     */
    public function fallToGround()
    {
        if ($this->status === self::STATUS_ON_TREE) {
            $this->fallDate = time();
            $this->status = self::STATUS_ON_GROUND;
        }
    }

    public function fallFromTree()
    {
        if ($this->status === self::STATUS_ON_TREE) {
            $this->fallToGround();
            $this->save();
            Yii::$app->session->setFlash('success', 'Яблоко успешно упало с дерева.');
        } else {
            Yii::$app->session->setFlash('error', 'Яблоко уже на земле или испорчено.');
        }
    }


    /**
     * Метод для съедания яблока на указанный процент.
     * Проверяет состояние яблока и обновляет его размер.
     * Если размер становится меньше или равен 0, яблоко испорчено (то бишь съедено).
     * @param int $percent Процент, который нужно съесть.
     * @throws \Exception Если попытка съесть яблоко на дереве или больше, чем у него есть.
     */
    public function eatPercent($percent)
    {
        if ($this->status === self::STATUS_ON_TREE) {
            throw new \Exception('Съесть нельзя, яблоко на дереве');
        }

        if ($this->status === self::STATUS_ON_GROUND) {
            $this->rot();
        }
        if ($this->status === self::STATUS_ROTTEN) {
            throw new \Exception('Съесть нельзя, испортилось');
        }
        $newSize = $this->size - ($percent / 100);

        if ($newSize < 0) {
            throw new \Exception('Нельзя съесть больше, чем у яблока есть');
        }

        $this->size = $newSize;
        if ($this->size <= 0) {
            $this->status = self::STATUS_EATEN;
            $this->size = 0;
        }
    }


    /**
     * Проверка на гнилость
     */
    private function rot()
    {
        $currentDate = time();
        $timeOnGround = $currentDate - $this->fallDate;

        if ($timeOnGround > 5 * 3600) { // 5 hours
            $this->status = self::STATUS_ROTTEN;
            $this->size = 0;
        }
    }


}
