<?php

use yii\db\Migration;

/**
 * Class m190812_101123_create_table_abroad_interest
 */
class m190812_101123_create_table_abroad_interest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('abroad_interest', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'interest_id' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'created_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'modified_by' => $this->integer(),
            'modified_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // foreign keys
        $this->addForeignKey(
            'fk_abroadinterest_user',
            'abroad_interest', 'user_id',
            'user', 'id',
            'restrict', 'cascade'
        );

        $this->addForeignKey(
            'fk_abroadinterest_sinterest',
            'abroad_interest', 'interest_id',
            's_interest', 'id',
            'restrict', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('abroad_interest');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190812_101123_create_table_abroad_interest cannot be reverted.\n";

        return false;
    }
    */
}
