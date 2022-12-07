<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_countrycode_iso3166}}".
 *
 * @property int $id
 * @property string $cc_iso3166
 * @property string $cc_description
 * @property int $position
 * @property int $fk_continent_region
 *
 * @property Company[] $companies
 * @property UserProfile[] $userProfiles
 */
class SCountrycodeIso3166 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_countrycode_iso3166}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cc_iso3166', 'cc_description', 'position', 'fk_continent_region'], 'required'],
            [['position', 'fk_continent_region'], 'integer'],
            [['cc_iso3166'], 'string', 'max' => 3],
            [['cc_description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cc_iso3166' => Yii::t('app', 'Cc Iso3166'),
            'cc_description' => Yii::t('app', 'Cc Description'),
            'position' => Yii::t('app', 'Position'),
            'fk_continent_region' => Yii::t('app', 'Fk Continent Region'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['nationality' => 'id']);
    }
}
