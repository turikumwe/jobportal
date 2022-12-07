<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_geosector}}".
 *
 * @property int $id
 * @property string $sector
 * @property int $district_id
 *
 * @property SCell[] $sCells
 * @property SDistrict $district
 */
class SGeosector extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_geosector}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sector', 'district_id'], 'required'],
            [['district_id'], 'integer'],
            [['sector'], 'string', 'max' => 45],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SDistrict::className(), 'targetAttribute' => ['district_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sector' => Yii::t('app', 'Sector'),
            'district_id' => Yii::t('app', 'District ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSCells()
    {
        return $this->hasMany(SCell::className(), ['sector_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(SDistrict::class, ['id' => 'district_id']);
    }

    public static function form($id){
        return SGeosector::find()->where(['id' => $id])->orderBy('sector')->asArray()->all();
    }
    public static function findByDistrict($district_id){
        return SGeosector::find()->where(['district_id' => $district_id])->asArray()->all();
    }

    public function faa() {
        return 90;die;
    }
}
