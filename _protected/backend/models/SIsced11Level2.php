<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isced11_level2}}".
 *
 * @property int $id
 * @property int $level1_id
 * @property string $code
 * @property string $subcategory_cat2
 *
 * @property SIsced11Level1 $level1
 * @property SIsced11Level3[] $sIsced11Level3s
 */
class SIsced11Level2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isced11_level2}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level1_id', 'code', 'subcategory_cat2'], 'required'],
            [['level1_id'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['subcategory_cat2'], 'string', 'max' => 200],
            [['level1_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsced11Level1::className(), 'targetAttribute' => ['level1_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'level1_id' => Yii::t('backend', 'Level1 ID'),
            'code' => Yii::t('backend', 'Code'),
            'subcategory_cat2' => Yii::t('backend', 'Subcategory Cat2'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel1()
    {
        return $this->hasOne(SIsced11Level1::className(), ['id' => 'level1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSIsced11Level3s()
    {
        return $this->hasMany(SIsced11Level3::className(), ['level2_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsced11Level2Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsced11Level2Query(get_called_class());
    }
}
