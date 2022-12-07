<?php

use yii\db\Migration;

/**
 * Class m190812_101137_create_table_linkedinurl
 */
class m190812_101137_create_table_linkedinurl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('linkedinurl', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'url' => $this->string(),
            'created_by' => $this->integer(),
            'created_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'modified_by' => $this->integer(),
            'modified_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_abroad_interest_s_interest',
            'linkedinurl', 'user_id',
            'user', 'id',
            'restrict', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('linkedinurl');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190812_101137_create_table_linkedinurl cannot be reverted.\n";

        return false;
    }
    */
}
