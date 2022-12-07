<?php

use yii\db\Migration;

/**
 * Class m190923_084938_create_table_s_competency_level
 */
class m190923_084938_create_table_s_competency_level extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('s_competency_level', [
            'id' => $this->primaryKey()->comment('ID'),
            'competency_level' => $this->string(45)->comment('Competency level')
        ]);

        // default data
        $this->insert('s_competency_level', ['id' => 1, 'competency_level' => 'General skills']);
        $this->insert('s_competency_level', ['id' => 2, 'competency_level' => 'Specialised skills']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('s_competency_level');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_084938_create_table_s_competency_level cannot be reverted.\n";

        return false;
    }
    */
}
