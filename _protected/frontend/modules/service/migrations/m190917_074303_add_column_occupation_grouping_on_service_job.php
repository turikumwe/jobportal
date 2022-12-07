<?php

use yii\db\Migration;

/**
 * Class m190917_074303_add_column_occupation_grouping_on_service_job
 */
class m190917_074303_add_column_occupation_grouping_on_service_job extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service_job', 'occupation_grouping_id', 'int AFTER jobtitle');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('service_job','occupation_grouping_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190917_074303_add_column_occupation_grouping_on_service_job cannot be reverted.\n";

        return false;
    }
    */
}
