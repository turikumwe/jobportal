<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "winner".
 *
 * @property int $id ID
 * @property int $user_id User
 * @property int $created_by Created by
 * @property string $created_on Created on
 * @property int $modified_by Modified by
 * @property string $modified_on Modified on
 *
 * @property User $createdBy
 * @property User $modifiedBy
 * @property User $user
 */
class Winner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'winner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'created_by', 'modified_by'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['modified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modified_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'user_id' => Yii::t('frontend', 'User'),
            'created_by' => Yii::t('frontend', 'Created by'),
            'created_on' => Yii::t('frontend', 'Created on'),
            'modified_by' => Yii::t('frontend', 'Modified by'),
            'modified_on' => Yii::t('frontend', 'Modified on'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
