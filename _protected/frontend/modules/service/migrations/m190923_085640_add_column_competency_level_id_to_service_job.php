<?php

use yii\db\Migration;

/**
 * Class m190923_085640_add_column_competency_level_id_to_service_job
 */
class m190923_085640_add_column_competency_level_id_to_service_job extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service_job', 'competency_level_id', 'int DEFAULT 1 AFTER contact_email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('service_job', 'competency_level_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_085640_add_column_competency_level_id_to_service_job cannot be reverted.\n";

        return false;
    }
    */
}
