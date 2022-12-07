<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isicr4_level1}}".
 *
 * @property int $id
 * @property string $activities_id
 * @property string $activities_description
 *
 * @property SIsicr4Level2[] $sIsicr4Level2s
 */
class SIsicr4Level1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isicr4_level1}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activities_id', 'activities_description'], 'required'],
            [['activities_id'], 'string', 'max' => 4],
            [['activities_description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'activities_id' => Yii::t('backend', 'Activities ID'),
            'activities_description' => Yii::t('backend', 'Activities Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSIsicr4Level2s()
    {
        return $this->hasMany(SIsicr4Level2::className(), ['level1_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsicr4Level1Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsicr4Level1Query(get_called_class());
    }
}
