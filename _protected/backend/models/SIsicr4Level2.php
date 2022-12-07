<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isicr4_level2}}".
 *
 * @property int $id
 * @property int $level1_id
 * @property string $isic_sector_letter
 * @property string $code
 * @property string $isic_sector_descr
 *
 * @property SIsicr4Level1 $level1
 * @property SIsicr4Level3[] $sIsicr4Level3s
 */
class SIsicr4Level2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isicr4_level2}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level1_id', 'isic_sector_letter', 'code', 'isic_sector_descr'], 'required'],
            [['level1_id'], 'integer'],
            [['isic_sector_letter'], 'string', 'max' => 1],
            [['code'], 'string', 'max' => 2],
            [['isic_sector_descr'], 'string', 'max' => 200],
            [['level1_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsicr4Level1::className(), 'targetAttribute' => ['level1_id' => 'id']],
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
            'isic_sector_letter' => Yii::t('backend', 'Isic Sector Letter'),
            'code' => Yii::t('backend', 'Code'),
            'isic_sector_descr' => Yii::t('backend', 'Isic Sector Descr'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel1()
    {
        return $this->hasOne(SIsicr4Level1::className(), ['id' => 'level1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSIsicr4Level3s()
    {
        return $this->hasMany(SIsicr4Level3::className(), ['level2_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsicr4Level2Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsicr4Level2Query(get_called_class());
    }
}
