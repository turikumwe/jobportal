<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_event_duration}}".
 *
 * @property int $id
 * @property string $name
 *
 * @property ServiceEvent $id0
 * @property ServiceEvent[] $serviceEvents
 */
class SEventDuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_event_duration}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['name'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceEvent::className(), 'targetAttribute' => ['id' => 'event_duration']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(ServiceEvent::className(), ['event_duration' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceEvents()
    {
        return $this->hasMany(ServiceEvent::className(), ['event_duration' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SEventDurationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SEventDurationQuery(get_called_class());
    }
}
