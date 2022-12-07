<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "s_interest".
 *
 * @property int $id
 * @property string $interest
 *
 * @property AbroadInterest[] $abroadInterests
 */
class SInterest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_interest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['interest'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'interest' => 'Interest',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbroadInterests()
    {
        return $this->hasMany(AbroadInterest::className(), ['user_id' => 'id']);
    }
}
