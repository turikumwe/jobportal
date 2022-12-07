<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_employment_status}}".
 *
 * @property int $id
 * @property string $status
 *
 * @property JsEventApplication[] $jsEventApplications
 */
class SEmploymentStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_employment_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'string', 'max' => 100],
            [['status'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'status' => Yii::t('backend', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEventApplications()
    {
        return $this->hasMany(JsEventApplication::className(), ['employment_status_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SEmploymentStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SEmploymentStatusQuery(get_called_class());
    }
}
