<?php

use yii\db\Migration;

/**
 * Class m231115_022905_update_apple_table
 */
class m231115_022905_update_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Удаляем старые поля
        $this->dropColumn('apple', 'color');
        $this->dropColumn('apple', 'appearance_date');
        $this->dropColumn('apple', 'fall_date');
        $this->dropColumn('apple', 'status');
        $this->dropColumn('apple', 'size');

        // Добавляем новые поля
        $this->addColumn('apple', 'color', $this->string()->notNull());
        $this->addColumn('apple', 'appearanceDate', $this->integer()->notNull());
        $this->addColumn('apple', 'fallDate', $this->integer());
        $this->addColumn('apple', 'status', $this->string()->notNull());
        $this->addColumn('apple', 'size', $this->decimal(5, 2)->notNull()->defaultValue(1.0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Если что-то пошло не так при применении миграции, откатываем изменения
        $this->dropColumn('apple', 'color');
        $this->dropColumn('apple', 'appearanceDate');
        $this->dropColumn('apple', 'fallDate');
        $this->dropColumn('apple', 'status');
        $this->dropColumn('apple', 'size');

        $this->addColumn('apple', 'color', $this->string()->notNull());
        $this->addColumn('apple', 'appearance_date', $this->integer()->notNull());
        $this->addColumn('apple', 'fall_date', $this->integer());
        $this->addColumn('apple', 'status', $this->string()->notNull());
        $this->addColumn('apple', 'size', $this->decimal(5, 2)->notNull()->defaultValue(1.0));
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231115_022905_update_apple_table cannot be reverted.\n";

        return false;
    }
    */
}
