<?php

use yii\db\Schema;

class m180602_150101_create_table_district extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('district', [
            'id' => $this->primaryKey(),
            'district_dame' => $this->string(50)->notNull(),
            'id_province' => $this->integer(11)->notNull(),
            'deleted_by' => $this->integer(11)->defaultValue(0),
            'deleted_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'updated_by' => $this->integer(11),
            'created_at' => $this->timestamp(),
            'created_by' => $this->integer(11),
            'FOREIGN KEY ([[id_province]]) REFERENCES province ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function down()
    {
        $this->dropTable('district');
    }
}
