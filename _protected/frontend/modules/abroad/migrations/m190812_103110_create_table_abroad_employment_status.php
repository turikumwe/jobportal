<?php

use yii\db\Migration;

/**
 * Class m190812_103110_create_table_abroad_employment_status
 */
class m190812_103110_create_table_abroad_employment_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('abroad_employment_status', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'status_id' => $this->string()->notNull(),
            'created_by' => $this->integer(),
            'created_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'modified_by' => $this->integer(),
            'modified_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_abroademploymentstatus_user',
            'abroad_employment_status', 'user_id',
            'user', 'id',
            'restrict', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('abroad_employment_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190812_103110_create_table_abroad_employment_status cannot be reverted.\n";

        return false;
    }
    */
}
