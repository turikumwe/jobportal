<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_mainecosector}}".
 *
 * @property int $id
 * @property string $sector
 *
 * @property EmplEconomicSector[] $emplEconomicSectors
 */
class SMainecosector extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_mainecosector}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sector'], 'required'],
            [['sector'], 'string', 'max' => 45],
            [['sector'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'sector' => Yii::t('common', 'Sector'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEconomicSectors()
    {
        return $this->hasMany(EmplEconomicSector::className(), ['mainecosector_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SMainecosectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SMainecosectorQuery(get_called_class());
    }
}
