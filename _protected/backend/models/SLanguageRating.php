<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_language_rating}}".
 *
 * @property int $id
 * @property string $languagerate
 *
 * @property JsLanguage $jsLanguage
 * @property JsLanguage[] $jsLanguages
 * @property JsLanguage[] $jsLanguages0
 * @property JsLanguage[] $jsLanguages1
 */
class SLanguageRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_language_rating}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['languagerate'], 'required'],
            [['languagerate'], 'string', 'max' => 45],
            [['languagerate'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'languagerate' => Yii::t('app', 'Languagerate'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsLanguage()
    {
        return $this->hasOne(JsLanguage::className(), ['reading' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsLanguages()
    {
        return $this->hasMany(JsLanguage::className(), ['writing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsLanguages0()
    {
        return $this->hasMany(JsLanguage::className(), ['listening' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsLanguages1()
    {
        return $this->hasMany(JsLanguage::className(), ['speaking' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SLanguageRatingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SLanguageRatingQuery(get_called_class());
    }
}
