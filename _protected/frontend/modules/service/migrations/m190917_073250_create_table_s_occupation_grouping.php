<?php

use yii\db\Migration;

/**
 * Class m190917_073250_create_table_s_occupation_grouping
 */
class m190917_073250_create_table_s_occupation_grouping extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('s_occupation_grouping', [
            'id' => $this->primaryKey()->comment('ID'),
            'occupation_grouping' => $this->string(45)->comment('Occupation grouping'),
            'icon' => $this->string(45)->comment('Icon'),
        ]);

        // default data
        $this->insert('s_occupation_grouping', ['id' => 1, 'occupation_grouping' => 'Agriculture', 'icon' => 'leaf']);
        $this->insert('s_occupation_grouping', ['id' => 2, 'occupation_grouping' => 'Education', 'icon' => 'university']);
        $this->insert('s_occupation_grouping', ['id' => 3, 'occupation_grouping' => 'Engineering', 'icon' => 'gear']);
        // $this->insert('s_occupation_grouping', ['id' => 4, 'occupation_grouping' => 'Environment sciences', 'icon' => '']);
        $this->insert('s_occupation_grouping', ['id' => 5, 'occupation_grouping' => 'Finance', 'icon' => 'bank']);
        $this->insert('s_occupation_grouping', ['id' => 6, 'occupation_grouping' => 'Health', 'icon' => 'medkit']);
        $this->insert('s_occupation_grouping', ['id' => 7, 'occupation_grouping' => 'Human Resource Management', 'icon' => 'users']);
        $this->insert('s_occupation_grouping', ['id' => 8, 'occupation_grouping' => 'Information Technology', 'icon' => 'laptop']);
        $this->insert('s_occupation_grouping', ['id' => 9, 'occupation_grouping' => 'Justice', 'icon' => 'balance-scale']);
        $this->insert('s_occupation_grouping', ['id' => 10, 'occupation_grouping' => 'Management', 'icon' => 'align-justify']);
        // $this->insert('s_occupation_grouping', ['id' => 11, 'occupation_grouping' => 'Services', 'icon' => '']);
        // $this->insert('s_occupation_grouping', ['id' => 12, 'occupation_grouping' => 'Social sciences', 'icon' => '']);
        $this->insert('s_occupation_grouping', ['id' => 13, 'occupation_grouping' => 'Tourism and Hospitality', 'icon' => 'bed']);
        $this->insert('s_occupation_grouping', ['id' => 99, 'occupation_grouping' => 'Others', 'icon' => 'spinner']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('s_occupation_grouping');   
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        $this->dropTable('s_interest');
    }
    */
}
