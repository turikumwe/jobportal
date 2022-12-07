<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_status}}".
 *
 * @property int $pk_status
 * @property string $status
 * @property string $label
 *
 * @property EmplEventApplication[] $emplEventApplications
 * @property JsApprenticeshipApplication $jsApprenticeshipApplication
 * @property JsEventApplication[] $jsEventApplications
 * @property JsJobApplication[] $jsJobApplications
 * @property JsTrainingsApplication[] $jsTrainingsApplications
 */
class SStatus extends \yii\db\ActiveRecord
{
    const JOB_STATUS_WAITING = 1;
    const JOB_STATUS_LEVEL_PLACEMENT = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'label'], 'required'],
            [['status'], 'string', 'max' => 45],
            [['label'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pk_status' => Yii::t('backend', 'Pk Status'),
            'status' => Yii::t('backend', 'Status'),
            'label' => Yii::t('backend', 'Label'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEventApplications()
    {
        return $this->hasMany(EmplEventApplication::className(), ['status_id' => 'pk_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsApprenticeshipApplication()
    {
        return $this->hasOne(JsApprenticeshipApplication::className(), ['status_id' => 'pk_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEventApplications()
    {
        return $this->hasMany(JsEventApplication::className(), ['status_id' => 'pk_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsJobApplications()
    {
        return $this->hasMany(JsJobApplication::className(), ['status_id' => 'pk_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsTrainingsApplications()
    {
        return $this->hasMany(JsTrainingsApplication::className(), ['status_id' => 'pk_status']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SStatusQuery(get_called_class());
    }
}
