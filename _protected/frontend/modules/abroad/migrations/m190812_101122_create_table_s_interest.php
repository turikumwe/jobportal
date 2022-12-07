<?php

use yii\db\Migration;

/**
 * Class m190812_101122_create_table_s_interest
 */
class m190812_101122_create_table_s_interest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('s_interest', [
            'id' => $this->primaryKey(),
            'interest' => $this->string(45),
        ]);

        // default data
        $this->insert('s_interest', [ 'id'=>1, 'interest'=>'Consultancy']);
        $this->insert('s_interest', [ 'id'=>2, 'interest'=>'Business']);
        $this->insert('s_interest', [ 'id'=>3, 'interest'=>'Internship']);
        $this->insert('s_interest', [ 'id'=>4, 'interest'=>'Invest in Rwanda']);
        $this->insert('s_interest', [ 'id'=>5, 'interest'=>'Job']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('s_interest');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190812_101122_create_table_s_interest cannot be reverted.\n";

        return false;
    }
    */
}
