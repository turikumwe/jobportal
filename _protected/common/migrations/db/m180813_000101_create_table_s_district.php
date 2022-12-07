<?php

use yii\db\Schema;

class m180813_000101_create_table_s_district extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('s_districts', [
            'pk_district' => $this->primaryKey(),
            'dist_name' => $this->string(100),
            'fk_province' => $this->integer(1),
            'di_sort' => $this->integer(11),
            'gis' => $this->string(200),
            'FOREIGN KEY ([[fk_province]]) REFERENCES s_provinces ([[pk_province]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('s_districts');
    }
}
