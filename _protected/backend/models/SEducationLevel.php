<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_education_level}}".
 *
 * @property int $id
 * @property string $level
 *
 * @property Education[] $educations
 */
class SEducationLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_education_level}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level'], 'required'],
            [['level'], 'string', 'max' => 45],
            [['status','order'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'level' => Yii::t('app', 'Level'),
            'status' => Yii::t('app', 'Status'),
            'order' => Yii::t('app', 'Order')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducations()
    {
        return $this->hasMany(Education::class, ['education_level_id' => 'id']);
    }
}
