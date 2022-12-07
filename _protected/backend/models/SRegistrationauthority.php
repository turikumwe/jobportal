<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_registrationauthority}}".
 *
 * @property int $id
 * @property string $registrationauthority
 *
 * @property EmplEmployer[] $emplEmployers
 * @property MdMediator[] $mdMediators
 */
class SRegistrationauthority extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_registrationauthority}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registrationauthority'], 'required'],
            [['registrationauthority'], 'string', 'max' => 45],
            [['registrationauthority'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'registrationauthority' => Yii::t('backend', 'Registrationauthority'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEmployers()
    {
        return $this->hasMany(EmplEmployer::className(), ['registration_authority_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdMediators()
    {
        return $this->hasMany(MdMediator::className(), ['registration_authority_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SRegistrationauthorityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SRegistrationauthorityQuery(get_called_class());
    }
}
