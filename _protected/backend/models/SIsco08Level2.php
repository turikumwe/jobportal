<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isco08_level2}}".
 *
 * @property int $id
 * @property string $code
 * @property int $level1_id
 * @property string $cat2_description
 *
 * @property SIsco08Level1 $level1
 * @property SIsco08Level3[] $sIsco08Level3s
 */
class SIsco08Level2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isco08_level2}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'level1_id', 'cat2_description'], 'required'],
            [['level1_id'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['cat2_description'], 'string', 'max' => 200],
            [['level1_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsco08Level1::className(), 'targetAttribute' => ['level1_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'code' => Yii::t('backend', 'Code'),
            'level1_id' => Yii::t('backend', 'Level1 ID'),
            'cat2_description' => Yii::t('backend', 'Cat2 Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel1()
    {
        return $this->hasOne(SIsco08Level1::className(), ['id' => 'level1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSIsco08Level3s()
    {
        return $this->hasMany(SIsco08Level3::className(), ['level2_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsco08Level2Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsco08Level2Query(get_called_class());
    }
}
