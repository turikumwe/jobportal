<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_gender}}".
 *
 * @property int $id
 * @property string $gender
 *
 * @property CommonPerson[] $commonPeople
 */
class SGender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_gender}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender'], 'required'],
            [['gender'], 'string', 'max' => 6],
            [['gender'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'gender' => Yii::t('backend', 'Gender'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommonPeople()
    {
        return $this->hasMany(CommonPerson::className(), ['gender_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SGenderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SGenderQuery(get_called_class());
    }
}
