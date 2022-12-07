<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_mediator_type}}".
 *
 * @property int $id
 * @property string $mediator_type
 *
 * @property MdMediator[] $mdMediators
 */
class SMediatorType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_mediator_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mediator_type'], 'required'],
            [['mediator_type'], 'string', 'max' => 45],
            [['mediator_type'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'mediator_type' => Yii::t('backend', 'Mediator Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdMediators()
    {
        return $this->hasMany(MdMediator::className(), ['mediator_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SMediatorTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SMediatorTypeQuery(get_called_class());
    }
}
