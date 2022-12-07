<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_marital_status}}".
 *
 * @property int $id
 * @property string $status
 *
 * @property UserProfile[] $userProfiles
 */
class SMaritalStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_marital_status}}';
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
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['marital_status' => 'id']);
    }
}
