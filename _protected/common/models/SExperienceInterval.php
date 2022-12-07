<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%s_experience_interval}}".
 *
 * @property int $id
 * @property string $experience_interval
 *
 * @property JsExperience[] $jsExperiences
 */
class SExperienceInterval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_experience_interval}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['experience_interval'], 'required'],
            [['experience_interval'], 'string', 'max' => 50],
            [['experience_interval'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'experience_interval' => Yii::t('common', 'Experience Interval'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsExperiences()
    {
        return $this->hasMany(JsExperience::className(), ['experience_in_this_occupation' => 'id']);
    }
}
