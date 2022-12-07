<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "winning_number".
 *
 * @property int $id ID
 * @property string $number Winning number
 * @property string $created_on Created on
 */
class WinningNumber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'winning_number';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number'], 'required'],
            [['created_on'], 'safe'],
            [['number'], 'string', 'max' => 255],
            [['number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'number' => Yii::t('frontend', 'Winning number'),
            'created_on' => Yii::t('frontend', 'Created on'),
        ];
    }
}
