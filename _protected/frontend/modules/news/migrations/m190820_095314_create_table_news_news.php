<?php

use yii\db\Migration;

/**
 * Class m190820_095314_create_table_news
 */
class m190820_095314_create_table_news_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news_news', [
            'id' => $this->primaryKey()->comment('ID'),
            'headline' => $this->text()->notNull()->comment('Headline'),
            'link' => $this->text()->notNull()->comment('Link'),
            'source' => $this->string(255)->notNull()->comment('Source'),
            'publication_date' => $this->date()->notNull()->comment('Publication date'),
            'created_by' => $this->integer()->comment('Created by'),
            'created_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->comment('Created on'),
            'modified_by' => $this->integer()->comment('Modified by'),
            'modified_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->comment('Modified on'),

        ]);

        $this->addForeignKey(
            'news_createdby_user_idx',
            'news_news', 'created_by',
            'user', 'id',
            'restrict', 'cascade'
        );

        $this->addForeignKey(
            'news_modifiedby_user_idx',
            'news_news', 'modified_by',
            'user', 'id',
            'restrict', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news_news');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190820_095314_create_table_news cannot be reverted.\n";

        return false;
    }
    */
}
