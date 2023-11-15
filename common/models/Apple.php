<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Exception;

class Apple extends ActiveRecord
{
    const STATUS_ON_TREE = 'on_tree';
    const STATUS_ON_GROUND = 'on_ground';
    const STATUS_ROTTEN = 'rotten';

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
            [['size'], 'number'],
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
            'color' => 'Color',
            'appearanceDate' => 'Appearance Date',
            'fallDate' => 'Fall Date',
            'status' => 'Status',
            'size' => 'Size',
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

    /**
     * Съесть яблоко на заданный процент
     *
     * @param float $percent
     * @throws Exception
     */
    public function eat($percent)
    {
        if ($this->status === self::STATUS_ON_TREE) {
            throw new Exception('Съесть нельзя, яблоко на дереве');
        }

        if ($this->status === self::STATUS_ON_GROUND) {
            $this->rot();
        }

        $this->size -= $percent / 100;

        if ($this->size <= 0) {
            $this->status = self::STATUS_ROTTEN;
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
