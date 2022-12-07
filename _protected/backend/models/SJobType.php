<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_job_type}}".
 *
 * @property int $id
 * @property string $job_type
 *
 * @property ServiceJob[] $serviceJobs
 */
class SJobType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_job_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_type'], 'required'],
            [['job_type'], 'string', 'max' => 50],
            [['job_type'], 'unique'],
        ];
    }

    public function getJobType() {
        return $this->job_type.'(45)';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'job_type' => Yii::t('backend', 'Job Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceJobs()
    {
        return $this->hasMany(ServiceJob::className(), ['job_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SJobTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SJobTypeQuery(get_called_class());
    }
}
