<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "s_mediator_position".
 *
 * @property int $id
 * @property string $position
 *
 * @property MdEmployees[] $mdEmployees
 */
class SMediatorPosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_mediator_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position'], 'required'],
            [['position'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdEmployees()
    {
        return $this->hasMany(MdEmployees::className(), ['position_id' => 'id']);
    }
}
