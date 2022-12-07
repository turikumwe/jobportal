<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property string $id
 * @property string $qualification_title
 * @property string $school_name
 * @property string $school_acronym
 * @property string $province
 * @property string $district
 * @property string $accreditation_status
 * @property string $school_type
 * @property string $school_activity
 * @property string $school_status
 * @property string $phone
 * @property string $email

 */
class Tvet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    // public static function tableName()
    // {
    //     return 'tvet';
    // }

    public $id;
    public $qualification_title;
    public $school_name;
    public $school_acronym;
    public $province;
    public $district;
    public $accreditation_status;
    public $school_type;
    public $school_activity;
    public $school_status;
    public $phone;
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'qualification_title',
                    'school_name',
                    'school_acronym',
                    'province',
                    'district',
                    'accreditation_status',
                    'school_type',
                    'school_activity',
                    'school_status',
                    'phone',
                    'email'
                ], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend','ID'),
            'qualification_title' => Yii::t('frontend','Qualification Name'),
            'school_name' => Yii::t('frontend','School Name'),
            'school_acronym' => Yii::t('frontend','School Acronym'),
            'province' => Yii::t('frontend','Province'),
            'district' => Yii::t('frontend','District'),
            'accreditation_status' => Yii::t('frontend','Accreditation Status'),
            'school_type' => Yii::t('frontend','School Type'),
            'school_activity' => Yii::t('frontend','School Activity'),
            'school_status' => Yii::t('frontend','School Status'),
            'phone' => Yii::t('frontend','Phone'),
            'email' => Yii::t('frontend', 'Email'),
        ];
    }
}
