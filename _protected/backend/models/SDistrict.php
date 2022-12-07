<?php

namespace backend\models;

use Yii;
use common\models\MdMediator;

/**
 * This is the model class for table "{{%s_district}}".
 *
 * @property int $id
 * @property string $district
 * @property int $province_id
 *
 * @property SProvince $province
 * @property SGeosector[] $sGeosectors
 */
class SDistrict extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_district}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district', 'province_id'], 'required'],
            [['province_id'], 'integer'],
            [['district'], 'string', 'max' => 45],
            [['district'], 'unique'],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => SProvince::className(), 'targetAttribute' => ['province_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'district' => Yii::t('app', 'District'),
            'province_id' => Yii::t('app', 'Province ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(SProvince::className(), ['id' => 'province_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediator()
    {
        return $this->hasOne(MdMediator::className(), ['id' => 'mediator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSGeosectors()
    {
        return $this->hasMany(SGeosector::className(), ['district_id' => 'id']);
    }

    public static function form($id){
       return SDistrict::find()->where(['id' => $id])->orderBy('district')->asArray()->all();
    }
}
