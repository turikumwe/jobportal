<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_special_assistance}}".
 *
 * @property int $id
 * @property string $assistance
 *
 * @property JsEventApplication[] $jsEventApplications
 */
class SSpecialAssistance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_special_assistance}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assistance'], 'required'],
            [['assistance'], 'string', 'max' => 100],
            [['assistance'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'assistance' => Yii::t('backend', 'Assistance'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEventApplications()
    {
        return $this->hasMany(JsEventApplication::className(), ['special_assistance_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SSpecialAssistanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SSpecialAssistanceQuery(get_called_class());
    }
}
