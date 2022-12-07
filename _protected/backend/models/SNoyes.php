<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_noyes}}".
 *
 * @property int $id
 * @property string $noyes
 *
 * @property UserProfile[] $userProfiles
 */
class SNoyes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_noyes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['noyes'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'noyes' => Yii::t('app', 'Noyes'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['disabled' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SNoyesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SNoyesQuery(get_called_class());
    }
}
