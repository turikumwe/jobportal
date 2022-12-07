<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isicr4_level4}}".
 *
 * @property int $id
 * @property int $level3_id
 * @property string $code
 * @property string $ecosector
 *
 * @property EmplEconomicSector[] $emplEconomicSectors
 * @property SIsicr4Level3 $level3
 * @property ServiceJob[] $serviceJobs
 */
class SIsicr4Level4 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isicr4_level4}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level3_id', 'code', 'ecosector'], 'required'],
            [['level3_id'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['ecosector'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['ecosector'], 'unique'],
            [['level3_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsicr4Level3::className(), 'targetAttribute' => ['level3_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'level3_id' => Yii::t('backend', 'Level3 ID'),
            'code' => Yii::t('backend', 'Code'),
            'ecosector' => Yii::t('backend', 'Ecosector'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEconomicSectors()
    {
        return $this->hasMany(EmplEconomicSector::className(), ['economic_sector_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel3()
    {
        return $this->hasOne(SIsicr4Level3::className(), ['id' => 'level3_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceJobs()
    {
        return $this->hasMany(ServiceJob::className(), ['economic_sector_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsicr4Level4Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsicr4Level4Query(get_called_class());
    }
}
