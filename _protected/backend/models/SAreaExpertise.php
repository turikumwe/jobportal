<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_area_expertise}}".
 *
 * @property int $id
 * @property string $expertise
 *
 * @property JsEventApplication[] $jsEventApplications
 */
class SAreaExpertise extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_area_expertise}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expertise'], 'required'],
            [['expertise'], 'string', 'max' => 100],
            [['expertise'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'expertise' => Yii::t('backend', 'Expertise'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEventApplications()
    {
        return $this->hasMany(JsEventApplication::className(), ['area_of_expertise_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SAreaExpertiseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SAreaExpertiseQuery(get_called_class());
    }
}
