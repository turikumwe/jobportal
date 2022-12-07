<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use common\models\MediatorJobseekerServiceSearch;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property int $user_id
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property string $locale
 * @property int $gender
 * @property string $reference_number
 * @property int $document_type ID/Passport
 * @property string $id_number
 * @property string $passport_number
 * @property string $dob
 * @property int $nationality Job seeker nationality
 * @property int $marital_status Single,married,...
 * @property int $disabled
 * @property int $disability_id
 * @property string $phone_number
 * @property int $terminate someone may decide to terminate his/her account
 * @property int $show_education
 * @property int $show_experience
 * @property int $show_profile_summary
 * @property int $show_contact
 * @property int $show_skill
 * @property int $show_drivinglicense
 * @property int $show_endorsement
 * @property int $show_recommendation
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property SCountrycodeIso3166 $nationality0
 * @property SDocumenttype $documentType
 * @property SMaritalStatus $maritalStatus
 * @property User $createdBy
 * @property User $updatedBy
 */
class UserProfile extends ActiveRecord {

    use \mootensai\relation\RelationTrait;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public $education_level_id;
    public $education_field_id;
    public $graduation_date;
    public $registration_start;
    public $registration_end;
    private $_rt_softrestore;
    private $_rt_softdelete;
    public $global_search;
    public $iscolevel1_id;
    public $iscolevel2_id;
    public $iscolevel3_id;
    public $occupation_id;
    public $district_id;
    public $picture;
    public $email;
    public $stat;
    public $pfirstname;
    public $pmiddlename;
    public $plastname;
    public $pgender;
    public $pdob;
    public $mediator_id;
    public $province_id;
    public $jobseeker_age;
    public $numberEducation;
    public $numberTraining;
    public $numberOfPostOccupied;
    public $country_id;
    public $knownthrough;

    public function __construct() {
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    public static function primaryKey() {
        return ['user_id'];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nationality', 'disability_id', 'marital_status', 'document_type', 'idKnownThrough'], 'required'],
            [['phone_number', 'passport_number', 'id_number'], 'unique'],
            [['profile'], 'file', 'extensions' => 'png,jpg,jpeg', 'maxSize' => 2097152, 'mimeTypes' => ['image/png']],
            [['numberEducation', 'gender', 'document_type', 'nationality', 'disabled', 'disability_id', 'terminate', 'show_education', 'show_experience', 'show_profile_summary', 'show_contact', 'show_skill', 'show_drivinglicense', 'show_endorsement', 'show_recommendation', 'notification_phone', 'notification_email', 'created_by', 'deleted_by', 'updated_by', 'show_training', 'show_language'], 'integer'],
            [['gender'], 'in', 'range' => [NULL, self::GENDER_FEMALE, self::GENDER_MALE]],
            [['firstname', 'middlename', 'lastname', 'gender', 'pfirstname', 'pmiddlename', 'plastname', 'pgender', 'avatar_path', 'avatar_base_url', 'email', 'otherKnownThrough', 'idAreaOfInterest'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => Yii::$app->language],
            ['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
            [['dob', 'pdob', 'created_at', 'deleted_at', 'updated_at', 'picture'], 'safe'],
            ['phone_number', 'string', 'min' => 10, 'max' => 13],
            [['reference_number'], 'string', 'max' => 20],
            [['reference_number'], 'default', 'value' => uniqid('u_')],
            [['terminate'], 'default', 'value' => 1],
            [['id_number'], 'string', 'min' => 16, 'max' => 16],
            [
                ['id_number'], 'required', 'when' => function ($model) {
                    return $model->document_type == 1;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_type').val() == 1;
                }", 'enableClientValidation' => true
            ],
            [['passport_number'], 'string', 'min' => 8],
            //[['passport_number'], 'unique', 'targetAttribute' => ['passport_number']],
            [
                ['passport_number'], 'required', 'when' => function ($model) {
                    return $model->document_type == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_type').val() == 2;
                }", 'enableClientValidation' => true
            ],
            [
                ['pfirstname'], 'required', 'when' => function ($model) {
                    return $model->document_type == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_type').val() == 2;
                }", 'enableClientValidation' => true
            ],
            [
                ['plastname'], 'required', 'when' => function ($model) {
                    return $model->document_type == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_type').val() == 2;
                }", 'enableClientValidation' => true
            ],
            [
                ['pgender'], 'required', 'when' => function ($model) {
                    return $model->document_type == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_type').val() == 2;
                }", 'enableClientValidation' => true
            ],
            [
                ['pdob'], 'required', 'when' => function ($model) {
                    return $model->document_type == 2;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#userprofile-document_type').val() == 2;
                }", 'enableClientValidation' => true
            ],
        ];
    }

    public function ageRestriction() {

        $from = new \DateTime($this->dob);
        $to = new \DateTime('today');
        $age = $from->diff($to)->y;

        return ($age < 15 || $age > 60) ? false : true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('frontend', 'User ID'),
            'firstname' => Yii::t('frontend', 'First name'),
            'middlename' => Yii::t('frontend', 'Middle name'),
            'lastname' => Yii::t('frontend', 'Last name'),
            'avatar_path' => Yii::t('frontend', 'Avatar Path'),
            'avatar_base_url' => Yii::t('frontend', 'Avatar Base Url'),
            'locale' => Yii::t('frontend', 'Language'),
            'picture' => Yii::t('frontend', 'Picture'),
            'gender' => Yii::t('frontend', 'Gender'),
            'document_type' => Yii::t('frontend', 'Document type'),
            'education_level_id' => Yii::t('frontend', 'Education Level'),
            'education_field_id' => Yii::t('frontend', 'Education Field'),
            'district_id' => Yii::t('frontend', 'District'),
            'province_id' => Yii::t('frontend', 'Province'),
            'mediator_id' => Yii::t('frontend', 'Employment Service Center'),
            'id_number' => Yii::t('frontend', 'ID number'),
            'passport_number' => Yii::t('frontend', 'Passport number'),
            'dob' => Yii::t('frontend', 'Date of birth'),
            'nationality' => Yii::t('frontend', 'Nationality'),
            'marital_status' => Yii::t('frontend', 'Marital status'),
            'disabled' => Yii::t('frontend', 'Disabled'),
            'disability_id' => Yii::t('frontend', 'Disability'),
            'phone_number' => Yii::t('frontend', 'Phone number'),
            'terminate' => Yii::t('frontend', 'Terminate'),
            'show_education' => Yii::t('frontend', 'Show education'),
            'show_experience' => Yii::t('frontend', 'Show experience'),
            'show_profile_summary' => Yii::t('frontend', 'Show summary'),
            'show_contact' => Yii::t('frontend', 'Show Residence'),
            'show_skill' => Yii::t('frontend', 'Show skill'),
            'show_drivinglicense' => Yii::t('frontend', 'Show driving license'),
            'show_endorsement' => Yii::t('frontend', 'Show endorsement'),
            'show_recommendation' => Yii::t('frontend', 'Show recommendation'),
            'show_training' => Yii::t('frontend', 'Show training'),
            'show_language' => Yii::t('frontend', 'Show language'),
            'registration_start' => Yii::t('frontend', 'Registration date (start)'),
            'registration_end' => Yii::t('frontend', 'Registration date (end)'),
            'created_by' => Yii::t('frontend', 'Created by'),
            'created_at' => Yii::t('frontend', 'Created at'),
            'deleted_by' => Yii::t('frontend', 'Deleted by'),
            'deleted_at' => Yii::t('frontend', 'Deleted at'),
            'updated_by' => Yii::t('frontend', 'Updated by'),
            'updated_at' => Yii::t('frontend', 'Updated at'),
            'iscolevel1_id' => Yii::t('frontend', 'Occupation level 1'),
            'iscolevel2_id' => Yii::t('frontend', 'Occupation level 2'),
            'iscolevel3_id' => Yii::t('frontend', 'Occupation level 3'),
            'occupation_id' => Yii::t('frontend', 'Occupation level 4'),
            'pfirstname' => Yii::t('frontend', 'First name'),
            'pmiddlename' => Yii::t('frontend', 'Middle name'),
            'plastname' => Yii::t('frontend', 'Last name'),
            'pgender' => Yii::t('frontend', 'Gender'),
            'pdob' => Yii::t('frontend', 'Date of birth'),
            'jobseeker_age' => Yii::t('frontend', 'jobseeker Age'),
            'numberEducation' => Yii::t('frontend', 'Number Of Educations'),
            'numberTraining' => Yii::t('frontend', 'Number Of Trainings'),
            'numberOfPostOccupied' => Yii::t('frontend', 'Number Of Jobs'),
            'country_id' => Yii::t('frontend', 'Residence'),
            'graduation_date' => Yii::t('frontend', 'Graduation Year'),
            'idKnownThrough' => Yii::t('frontend', 'I know KORA through'),
            'otherknownthrough' => Yii::t('frontend', 'Other source'),
            'idAreaOfInterest' => Yii::t('frontend', 'Area of interest'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return null|string
     */
    public function getFullName() {
        if ($this->firstname || $this->lastname) {
            return implode(' ', [$this->firstname, $this->lastname]);
        }
        return null;
    }

    public function getCountEducation() {

        return JsEducation::find()
                        ->where(['user_id' => $this->user_id])
                        ->Andwhere(['deleted_by' => 0])
                        ->count();
    }

    public function getCountTraining() {

        return JsTraining::find()
                        ->where(['user_id' => $this->user_id])
                        ->Andwhere(['deleted_by' => 0])
                        ->count();
    }

    public function getCountJobPosition() {

        return JsExperience::find()
                        ->where(['user_id' => $this->user_id])
                        ->Andwhere(['deleted_by' => 0])
                        ->count();
    }

    public function getAge() {
        //date in mm/dd/yyyy format; or it can be in other formats as well
        $birthDate = $this->dob;
        $age = floor((time() - strtotime($birthDate)) / 31556926);

        return $age;
    }

    public static function jobSeekers() {
        $jobSeekers = static::find()->select(['user_id,concat(firstname," ",lastname) as fullName'])->orderBy('user_id');
        return $jobSeekers;
    }

    public function getJsEducation() {
        return $this->hasOne(JsEducation::class, ['user_id' => 'user_id'])->where(['js_education.status' => 1]);
    }

    public function getJsExperience() {
        return $this->hasOne(JsExperience::class, ['user_id' => 'user_id'])->where(['js_experience.status' => 1]);
    }

    public function getJsAddress() {
        return $this->hasOne(JsAddress::class, ['user_id' => 'user_id'])->where(['js_address.status' => 1]);
    }

    /**
     * @param null $default
     * @return bool|null|string
     */
    public function getAvatar($default = null) {
        return $this->avatar_path ? Yii::getAlias($this->avatar_base_url . '/' . $this->avatar_path) : $default;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNationality0() {
        return $this->hasOne(\backend\models\SCountrycodeIso3166::class, ['id' => 'nationality']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentType() {
        return $this->hasOne(\backend\models\SDocumenttype::class, ['id' => 'document_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaritalStatus() {
        return $this->hasOne(\backend\models\SMaritalStatus::class, ['id' => 'marital_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisabled0() {
        return $this->hasOne(\backend\models\SNoyes::class, ['id' => 'disabled']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisability() {
        return $this->hasOne(\backend\models\SDisability::class, ['id' => 'disability_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserProfileQuery the active query used by this AR class.
     */
    public static function find() {
        return new UserProfileQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function behaviors() {
        if (!Yii::$app->user->isGuest) {
            return [
                'picture' => [
                    'class' => UploadBehavior::class,
                    'attribute' => 'picture',
                    'pathAttribute' => 'avatar_path',
                    'baseUrlAttribute' => 'avatar_base_url'
                ],
                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'value' => new \yii\db\Expression('NOW()'),
                ],
                'blameable' => [
                    'class' => BlameableBehavior::class,
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
            ];
        } else {
            return [
                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'value' => new \yii\db\Expression('NOW()'),
                ],
            ];
        }
    }

    public static function data() {
        return static::find()
                        ->select(['concat(firstname," ",lastname) as value', 'firstname as  label', 'user_id as id'])
                        ->active()
                        ->asArray()
                        ->all();
    }

    public static function getUsersByMediator($mediator_id) {
        return static::find()
                        ->select(['concat(lastname," ",firstname) as names', 'firstname as  label', 'user_id as id'])
                        ->active()
                        ->andWhere(['mediator_id' => $mediator_id])
                        ->orderBy(['lastname' => SORT_ASC])
                        ->asArray()
                        ->all();
    }

    public static function findUserIdByUser($user_id) {
        if ($user_id !== 0) {
            return UserProfile::find()
                            ->where(['user_id' => $user_id])
                            ->one()->user_id;
        }
        return null;
    }

    public static function getProfileCompletionPercentage($user_id) {
        $summary = JsSummary::find()->where(['user_id' => $user_id])->count();
        $experience = JsExperience::find()->where(['user_id' => $user_id])->count();
        $education = JsEducation::find()->where(['user_id' => $user_id])->count();
        $training = JsTraining::find()->where(['user_id' => $user_id])->count();
        $language = JsLanguage::find()->where(['user_id' => $user_id])->count();
        $skill = JsSkill::find()->where(['user_id' => $user_id])->count();
        $address = JsAddress::find()->where(['user_id' => $user_id])->count();
        $completed = 0;
        if ($summary >= 1) {
            $completed++;
        }
        if ($experience >= 1) {
            $completed++;
        }
        if ($education >= 1) {
            $completed++;
        }
        if ($training >= 1) {
            $completed++;
        }
        if ($language >= 1) {
            $completed++;
        }
        if ($skill >= 1) {
            $completed++;
        }
        if ($address >= 1) {
            $completed++;
        }
        $completness = ($completed * 100) / 7;

        return $completness;
    }

}
