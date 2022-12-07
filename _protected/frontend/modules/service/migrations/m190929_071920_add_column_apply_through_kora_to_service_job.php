<?php

use yii\db\Migration;

/**
 * Class m190929_071920_add_column_apply_through_kora_to_service_job
 */
class m190929_071920_add_column_apply_through_kora_to_service_job extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service_job', 'apply_through_kora_flag', $this->integer()->defaultValue(0)->after('competency_level_id')->comment('0-No,1-Yes'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('service_job', 'apply_through_kora_flag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190929_071920_add_column_apply_through_kora_to_service_job cannot be reverted.\n";

        return false;
    }
    */
}
