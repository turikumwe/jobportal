<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_disability}}".
 *
 * @property int $id
 * @property string $disability
 *
 * @property UserProfile[] $userProfiles
 */
class SDisability extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_disability}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['disability'], 'required'],
            [['disability'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'disability' => Yii::t('app', 'Disability'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['disability_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SDisabilityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SDisabilityQuery(get_called_class());
    }
}
