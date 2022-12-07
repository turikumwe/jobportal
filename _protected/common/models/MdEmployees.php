<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "md_employees".
 *
 * @property int $id
 * @property int $mediator_id
 * @property int $person_id
 * @property int $position_id
 * @property string $start_date
 * @property string $end_date
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property MdMediator $mediator
 * @property CommonPerson $person
 * @property User $createdBy
 * @property User $updatedBy
 * @property SMediatorPosition $position
 */
class MdEmployees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'md_employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mediator_id', 'position_id'], 'required'],
            [['mediator_id', 'person_id', 'position_id', 'terminate', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['mediator_id'], 'exist', 'skipOnError' => true, 'targetClass' => MdMediator::className(), 'targetAttribute' => ['mediator_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => CommonPerson::className(), 'targetAttribute' => ['person_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => SMediatorPosition::className(), 'targetAttribute' => ['position_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mediator_id' => Yii::t('app', 'Mediator'),
            'person_id' => Yii::t('app', 'Person'),
            'position_id' => Yii::t('app', 'Position'),
            'terminate' => Yii::t('app', 'Terminate'),
            'start_date' => Yii::t('app', 'Employment start Date'),
            'end_date' => Yii::t('app', 'Employement end Date'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediator()
    {
        return $this->hasOne(MdMediator::className(), ['id' => 'mediator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(CommonPerson::className(), ['id' => 'person_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(SMediatorPosition::className(), ['id' => 'position_id']);
    }
}
