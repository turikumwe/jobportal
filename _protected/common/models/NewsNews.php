<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_news".
 *
 * @property int $id ID
 * @property string $headline Headline
 * @property string $link Link
 * @property string $source Source
 * @property string $publication_date Publication date
 * @property int $created_by Created by
 * @property string $created_on Created on
 * @property int $modified_by Modified by
 * @property string $modified_on Modified on
 *
 * @property User $createdBy
 * @property User $modifiedBy
 */
class NewsNews extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'news_news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['headline','news_type', 'publication_date','action_id'], 'required'],
            [['headline'], 'string'],
            [
                ['news_details'], 'required', 'when' => function ($model) {
                    return $model->news_type == 1;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#newsnews-news_type').val() == 1;
                }", 'enableClientValidation' => true
            ],
            [
                ['link', 'source'], 'required', 'when' => function ($model) {
                    return $model->news_type == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#newsnews-news_type').val() == 2;
                }", 'enableClientValidation' => true
            ],
            [['publication_date', 'news_details', 'news_type', 'action_id', 'created_on', 'modified_on'], 'safe'],
            [['created_by', 'modified_by'], 'integer'],
            [['source'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['modified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modified_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'headline' => Yii::t('frontend', 'Headline'),
            'news_details' => Yii::t('frontend', 'News details'),
            'action_id' => Yii::t('frontend', 'Action id'),
            'link' => Yii::t('frontend', 'Link'),
            'source' => Yii::t('frontend', 'Source'),
            'publication_date' => Yii::t('frontend', 'Publication date'),
            'created_by' => Yii::t('frontend', 'Created by'),
            'created_on' => Yii::t('frontend', 'Created on'),
            'modified_by' => Yii::t('frontend', 'Modified by'),
            'modified_on' => Yii::t('frontend', 'Modified on'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedBy() {
        return $this->hasOne(User::className(), ['id' => 'modified_by']);
    }

}
