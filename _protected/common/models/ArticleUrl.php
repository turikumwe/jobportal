<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_url".
 *
 * @property int $id
 * @property int $article_id
 * @property string $url
 * @property string $name
 * @property int $created_at
 * @property int $order
 */
class ArticleUrl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id', 'created_at', 'order'], 'integer'],
            [['url', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'url' => 'Url',
            'name' => 'Name',
            'created_at' => 'Created At',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }
}
