<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_language}}".
 *
 * @property int $id
 * @property string $language
 *
 * @property JsLanguage[] $jsLanguages
 */
class SLanguage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_language}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language'], 'required'],
            [['language'], 'string', 'max' => 45],
            [['language'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsLanguages()
    {
        return $this->hasMany(JsLanguage::className(), ['language' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SLanguageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SLanguageQuery(get_called_class());
    }
}
