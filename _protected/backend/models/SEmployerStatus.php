<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_employer_status}}".
 *
 * @property int $id
 * @property string $status
 *
 * @property EmplStatus[] $emplStatuses
 */
class SEmployerStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_employer_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'required'],
            [['id'], 'integer'],
            [['status'], 'string', 'max' => 45],
            [['id'], 'unique'],
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
    public function getEmplStatuses()
    {
        return $this->hasMany(EmplStatus::className(), ['employer_status_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SEmployerStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SEmployerStatusQuery(get_called_class());
    }
}
