<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isco08_level1}}".
 *
 * @property int $id
 * @property string $cat1_id
 * @property string $cat1_description
 *
 * @property SIsco08Level2[] $sIsco08Level2s
 */
class SIsco08Level1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isco08_level1}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat1_id', 'cat1_description'], 'required'],
            [['cat1_id'], 'string', 'max' => 4],
            [['cat1_description'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'cat1_id' => Yii::t('backend', 'Cat1 ID'),
            'cat1_description' => Yii::t('backend', 'Cat1 Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSIsco08Level2s()
    {
        return $this->hasMany(SIsco08Level2::className(), ['level1_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsco08Level1Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsco08Level1Query(get_called_class());
    }
}
