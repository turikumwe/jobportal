<?php

use yii\db\Migration;

/**
 * Class m190828_092335_create_table_winner
 */
class m190828_092335_create_table_winner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('winner', [
            'id' => $this->primaryKey()->comment('ID'),
            'user_id' => $this->integer()->notNull()->comment('User'),
            'created_by' => $this->integer()->comment('Created by'),
            'created_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->comment('Created on'),
            'modified_by' => $this->integer()->comment('Modified by'),
            'modified_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->comment('Modified on'),
        ]);

        // foreign keys
        $this->addForeignKey(
            'fk_winner_userid_user_id',
            'winner', 'user_id',
            'user', 'id',
            'cascade', 'cascade'
        );

        $this->addForeignKey(
            'fk_winner_createdby_user_id',
            'winner', 'created_by',
            'user', 'id',
            'cascade', 'cascade'
        );

        $this->addForeignKey(
            'fk_winner_modifiedby_user_id',
            'winner', 'modified_by',
            'user', 'id',
            'cascade', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('winner');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190828_092335_create_table_winner cannot be reverted.\n";

        return false;
    }
    */
}
