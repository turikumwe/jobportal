<?php

use yii\db\Migration;

/**
 * Class m190812_103143_create_table_abroad_share_profile
 */
class m190812_103143_create_table_abroad_share_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('abroad_share_profile', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'share_id' => $this->string()->notNull(),
            'created_by' => $this->integer(),
            'created_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'modified_by' => $this->integer(),
            'modified_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_abroadshareprofile_user',
            'abroad_share_profile', 'user_id',
            'user', 'id',
            'restrict', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('abroad_share_profile');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190812_103143_create_table_abroad_share_profile cannot be reverted.\n";

        return false;
    }
    */
}
