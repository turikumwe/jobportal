<?php

namespace backend\models;

use Yii;
use common\models\JsDrivingLicenseCategory;

/**
 * This is the model class for table "{{%s_permit_category}}".
 *
 * @property int $id
 * @property string $category
 *
 * @property JsDrivingLicenseCategory[] $jsDrivingLicenseCategories
 */
class SPermitCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_permit_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['category'], 'string', 'max' => 10],
            [['category'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'category' => Yii::t('common', 'Category'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsDrivingLicenseCategories()
    {
        return $this->hasMany(JsDrivingLicenseCategory::className(), ['license_category_id' => 'id']);
    }
}
