<?php

use yii\db\Schema;

class m180813_000101_create_table_province extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('s_provinces', [
            'pk_province' => $this->primaryKey(),
            'province_name' => $this->string(20)->notNull(),
            'pr_sort' => $this->integer(1)->notNull(),
            'gis' => $this->string(200)->notNull(),
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('s_provinces');
    }
}
