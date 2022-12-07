<?php

namespace common\models;

use backend\models\SDocumenttype;
use backend\models\SCountrycodeIso3166;
use backend\models\SGeosector;
use Yii;

/**
 * This is the model class for table "common_person".
 *
 * @property int $id
 * @property int $document_id
 * @property string $id_number
 * @property string $passport_number
 * @property int $country_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property int $gender_id
 * @property int $geo_sector_id
 * @property string $phone
 * @property string $email
 * @property int $terminate someone may decide to terminate his/her account
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property SDocumenttype $document
 * @property SCountrycodeIso3166 $country
 * @property SGeosector $geoSector
 * @property User $createdBy
 * @property User $updatedBy
 * @property SGender $gender
 * @property EmplManagers[] $emplManagers
 * @property MdEmployees[] $mdEmployees
 * @property MdManagers[] $mdManagers
 */
class CommonPerson extends \yii\db\ActiveRecord {

    public $pfirst_name;
    public $pmiddle_name;
    public $plast_name;
    public $pdate_of_birth;
    public $pcountry_id;
    public $ppassport_number;
    public $pgender_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'common_person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gender_id', 'phone', 'email'], 'required'],
            [['document_id', 'country_id', 'gender_id', 'geo_sector_id', 'terminate', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['first_name', 'last_name', 'date_of_birth', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['id_number'], 'string', 'max' => 16],
            [['passport_number'], 'string', 'max' => 20],
            [['first_name', 'middle_name', 'last_name', 'email'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 12],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [
                ['pfirst_name'], 'required', 'when' => function ($model) {
                    return $model->document_id == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_id').val() == 2;
                }", 'enableClientValidation' => true
            ],
            [
                ['plast_name'], 'required', 'when' => function ($model) {
                    return $model->document_id == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_id').val() == 2;
                }", 'enableClientValidation' => true
            ],
            [
                ['pgender_id'], 'required', 'when' => function ($model) {
                    return $model->document_id == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_id').val() == 2;
                }", 'enableClientValidation' => true
            ],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => SDocumenttype::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => SCountrycodeIso3166::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['geo_sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SGeosector::className(), 'targetAttribute' => ['geo_sector_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => SGender::className(), 'targetAttribute' => ['gender_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'document_id' => Yii::t('app', 'Document'),
            'id_number' => Yii::t('app', 'ID Number'),
            'passport_number' => Yii::t('app', 'Passport Number'),
            'country_id' => Yii::t('app', 'Country'),
            'first_name' => Yii::t('app', 'First Name'),
            'pfirst_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'pmiddle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'plast_name' => Yii::t('app', 'Last Name'),
            'date_of_birth' => Yii::t('app', 'Date Of Birth'),
            'gender_id' => Yii::t('app', 'Gender'),
            'pgender_id' => Yii::t('app', 'Gender'),
            'geo_sector_id' => Yii::t('app', 'Georgaphic Sector'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'terminate' => Yii::t('app', 'Terminate'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument() {
        return $this->hasOne(SDocumenttype::className(), ['id' => 'document_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry() {
        return $this->hasOne(SCountrycodeIso3166::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoSector() {
        return $this->hasOne(SGeosector::className(), ['id' => 'geo_sector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender() {
        return $this->hasOne(SGender::className(), ['id' => 'gender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplManagers() {
        return $this->hasMany(EmplManagers::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdEmployees() {
        return $this->hasMany(MdEmployees::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdManagers() {
        return $this->hasMany(MdManagers::className(), ['person_id' => 'id']);
    }

    public function getFullName() {
        if ($this->first_name || $this->last_name) {
            return implode(' ', [$this->first_name, $this->last_name]);
        }
        return null;
    }

    public static function employerManagers() {
        $employerManagers = static::find()->select(['id,concat(first_name," ",last_name) as fullName'])->orderBy('id');
        return $employerManagers;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CommonPersonQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\CommonPersonQuery(get_called_class());
        return $this->hasMany(MdManagers::className(), ['person_id' => 'id']);
    }

}
