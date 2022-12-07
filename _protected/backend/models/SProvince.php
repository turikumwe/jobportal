<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_province}}".
 *
 * @property int $id
 * @property string $province
 *
 * @property SDistrict[] $sDistricts
 */
class SProvince extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_province}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'province' => Yii::t('app', 'Province'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSDistricts()
    {
        return $this->hasMany(SDistrict::className(), ['province_id' => 'id']);
    }

    public static function form(){

       return SProvince::find()->orderBy('province')->asArray()->all();
    }
}
