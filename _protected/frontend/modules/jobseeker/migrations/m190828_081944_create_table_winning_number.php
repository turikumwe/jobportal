<?php

use yii\db\Migration;

/**
 * Class m190828_081944_create_table_winning_number
 */
class m190828_081944_create_table_winning_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('winning_number', [
            'id' => $this->primaryKey()->comment('ID'),
            'number' => $this->string(255)->unique()->notNull()->comment('Winning number'),
            'created_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->comment('Created on'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('winning_number');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190828_081944_create_table_winning_number cannot be reverted.\n";

        return false;
    }
    */
}
