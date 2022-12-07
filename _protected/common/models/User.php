<?php

namespace common\models;

use common\commands\AddToTimelineCommand;
use kartik\password\StrengthValidator;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\query\UserQuery;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use Yii;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property string $access_token
 * @property string $oauth_client
 * @property string $oauth_client_user_id
 * @property string $publicIdentity
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 *
 * @property \common\models\UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;
    CONST STATUS_SLEEPING = 4;
    const VALIDATION = true;
    const ROLE_RDB = 'rdb';
    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_EMPLOYER = 'employer';
    const ROLE_MEDIATOR = 'mediator';
    const ROLE_ADMINISTRATOR = 'administrator';
    const ROLE_MEDIATOR_PRIVATE = 'mediator_private';
    const ROLE_MEDIATOR_ADMIN = 'mediator_admin';
    const ROLE_ABROAD = 'abroad';
    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::find()
                        ->active()
                        ->andWhere(['id' => $id])
                        ->one();
    }

    /**
     * @return UserQuery
     */
    public static function find() {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::find()
                        ->active()
                        ->andWhere(['access_token' => $token])
                        ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User|array|null
     */
    public static function findByUsername($username) {
        return static::find()
                        ->active()
                        ->andWhere(['username' => $username])
                        ->one();
    }

    /**
     * Finds user by username or email
     *
     * @param string $login
     * @return User|array|null
     */
    public static function findByLogin($login) {
        return static::find()
                        ->active()
                        ->andWhere(['or', ['username' => $login], ['phone' => $login]])
                        ->one();
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::class,
            'auth_key' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            'access_token' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
                ],
                'value' => function () {
                    return Yii::$app->getSecurity()->generateRandomString(40);
                }
            ]
        ];
    }

    /**
     * @return array
     */
    public function scenarios() {
        return ArrayHelper::merge(
                        parent::scenarios(),
                        [
                            'oauth_create' => [
                                'oauth_client', 'oauth_client_user_id', 'phone', 'username', '!status'
                            ]
                        ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'phone'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::statuses())],
            //[['phone'], 'string', 'min' => 10, 'max' => 13],
            [['username'], 'filter', 'filter' => '\yii\helpers\Html::encode'],
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses() {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('frontend', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('frontend', 'Active'),
            self::STATUS_DELETED => Yii::t('frontend', 'Deleted')
        ];
    }

    /**
     * Returns a user status
     * @return array|mixed
     */
    public static function status($user_status) {
        if ($user_status == self::STATUS_NOT_ACTIVE) {
            return Yii::t('frontend', 'Not Active');
        }

        if ($user_status == self::STATUS_ACTIVE) {
            return Yii::t('frontend', 'Active');
        }

        if ($user_status == self::STATUS_DELETED) {
            return Yii::t('frontend', 'Deleted');
        }

        if ($user_status == self::STATUS_SLEEPING) {
            return Yii::t('frontend', 'Sleeping');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => Yii::t('frontend', 'Username'),
            'email' => Yii::t('frontend', 'E-mail'),
            'phone' => Yii::t('frontend', 'Phone Number'),
            'status' => Yii::t('frontend', 'Status'),
            'access_token' => Yii::t('frontend', 'API access token'),
            'created_at' => Yii::t('frontend', 'Created at'),
            'updated_at' => Yii::t('frontend', 'Updated at'),
            'logged_at' => Yii::t('frontend', 'Last login'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile() {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    public function getRole() {
        return $this->hasOne(\backend\modules\rbac\models\RbacAuthAssignment::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerProfile() {
        return $this->hasOne(EmplEmployer::class, ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediatorProfile() {
        return $this->hasOne(MdMediator::class, ['id' => 'id']);
    }

    public function getMediatorEmployee() {
        return $this->hasOne(MdEmployees::class, ['id' => 'id']);
    }

    public function getEmployeeProfile() {
        return $this->hasOne(CommonPerson::class, ['email' => 'email']);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function getPassword() {

        return '';
    }

    /**
     * Creates user profile and application event
     * @param array $profileData
     */
    public function afterSignup($role) {
        $this->refresh();
        Yii::$app->commandBus->handle(new AddToTimelineCommand([
                    'category' => 'user',
                    'event' => 'signup',
                    'data' => [
                        'public_identity' => $this->getPublicIdentity(),
                        'user_id' => $this->getId(),
                        'created_at' => $this->created_at
                    ]
        ]));

        $this->trigger(self::EVENT_AFTER_SIGNUP);
        // Default role
        $auth = Yii::$app->authManager;

        $auth->assign($auth->getRole($role), $this->getId());
    }

    /**
     * @return string
     */
    public function getPublicIdentity() {
        if ($this->userProfile && $this->userProfile->getFullname()) {
            return $this->userProfile->getFullname();
        }
        if ($this->username) {
            return $this->username;
        }
        return $this->phone;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsAddresses() {
        return $this->hasMany(JsAddress::class, ['user_id' => 'id']);
    }

    public function getJsAddress() {
        return $this->hasOne(JsAddress::class, ['user_id' => 'id'])->where(['js_address.status' => 1]);
    }

    public function getEmplAddress() {
        return $this->hasOne(EmplAddress::class, ['employer_id' => 'id'])->orderBy(['empl_address.id' => SORT_DESC]);
        ;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEconomicSector() {
        return $this->hasOne(EmplEconomicSector::class, ['employer_id' => 'id'])->orderBy(['empl_economic_sector.id' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEducations() {
        return $this->hasMany(JsEducation::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEducation() {
        return $this->hasOne(JsEducation::class, ['user_id' => 'id'])->where(['js_education.status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEndorses() {
        return $this->hasMany(JsEndorse::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsFromMessage() {
        return $this->hasMany(JsMessage::class, ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEndorses0() {
        return $this->hasMany(JsEndorse::class, ['who_endorsed_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsExperiences() {
        return $this->hasMany(JsExperience::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsRecommendations() {
        return $this->hasMany(JsRecommendation::class, ['user_id' => 'id']);
    }

    public function getJsCaseManagements() {
        return $this->hasMany(JsCaseManagement::class, ['jobseeker_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsRecommendations2() {
        return $this->hasMany(JsRecommendation::class, ['who_recommended_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsSkills() {
        return $this->hasMany(JsSkill::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsDrivingLicenses() {
        return $this->hasMany(JsDrivingLicense::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsSummaries() {
        return $this->hasMany(JsSummary::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsLanguages() {
        return $this->hasMany(JsLanguage::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsTrainings() {
        return $this->hasMany(JsTraining::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplAddresss() {
        return $this->hasMany(EmplAddress::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplSummary() {
        return $this->hasMany(EmplSummary::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplStatus() {
        return $this->hasMany(EmplStatus::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplManager() {
        return $this->hasMany(EmplManagers::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEconomicSector() {
        return $this->hasMany(EmplEconomicSector::class, ['employer_id' => 'id']);
    }

    public function getMdAddresss() {
        return $this->hasMany(MdAddress::class, ['mediator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdManager() {
        return $this->hasMany(MdManagers::class, ['mediator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdEmployee() {
        return $this->hasMany(MdEmployees::class, ['mediator_id' => 'id']);
    }

    public static function getUserIdsFromSameMediator() {
        //Users from same mediator
        $user = User::findOne(Yii::$app->user->id);
        $mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;
        //Users from same mediator
        $mediator_employees = \common\models\MdEmployees::find()->where(['mediator_id' => $mediator->id])->asArray()->all();
        $user_ids = array();
        if (count($mediator_employees) > 0) {
            foreach ($mediator_employees as $employee) {
                array_push($user_ids, $employee['id']); //ID in employee is same as user ID
            }
        }
        array_push($user_ids, Yii::$app->user->id);
        return $user_ids;
    }

    public static function isAJobSeeker($user_id) {
        //All jobseeker must have an education
        $user_education = JsEducation::find()->where(['user_id' => $user_id])->all();
        if (count($user_education) > 0) {
            return true;
        }
        return false;
    }

    public static function isFromEmployer($user_id) {
       
        //All jobseeker must have an education
        $employer = User::findOne($user_id);
        if (isset($employer->employerProfile)) {
            return true;
        }
        return false;
    }

}
