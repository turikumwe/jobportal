<?php

namespace backend\models;

use Yii;
use common\models\JsDrivingLicense;

/**
 * This is the model class for table "{{%s_permit_type}}".
 *
 * @property int $id
 * @property string $type
 *
 * @property JsDrivingLicense[] $jsDrivingLicenses
 */
class SPermitType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_permit_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 45],
            [['type'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'type' => Yii::t('common', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsDrivingLicenses()
    {
        return $this->hasMany(JsDrivingLicense::className(), ['license_type_id' => 'id']);
    }
}
