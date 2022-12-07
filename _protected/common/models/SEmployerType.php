<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%s_employer_type}}".
 *
 * @property int $id
 * @property string $type
 *
 * @property EmplEmployer[] $emplEmployers
 */
class SEmployerType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_employer_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'type' => Yii::t('common', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEmployers()
    {
        return $this->hasMany(EmplEmployer::className(), ['employer_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SEmployerTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SEmployerTypeQuery(get_called_class());
    }
}
