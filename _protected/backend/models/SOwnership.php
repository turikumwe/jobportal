<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_ownership}}".
 *
 * @property int $id
 * @property int $employertype_id
 * @property string $ownership
 *
 * @property Company[] $companies
 */
class SOwnership extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_ownership}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employertype_id'], 'integer'],
            [['ownership'], 'required'],
            [['ownership'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'employertype_id' => Yii::t('app', 'Employertype ID'),
            'ownership' => Yii::t('app', 'Ownership'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['ownership_id' => 'id']);
    }
}
