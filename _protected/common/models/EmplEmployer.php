<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "{{%empl_employer}}".
 *
 * @property int $id
 * @property string $company_name
 * @property string $company_name_abbraviatio
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property int $parent
 * @property int $child
 * @property int $employer_type_id
 * @property string $opening_date
 * @property int $registration_authority_id
 * @property string $tin
 * @property int $ownership_id
 * @property int $show_address
 * @property int $show_economic_sector
 * @property int $show_employer_status
 * @property int $show_reference
 * @property int $show_employer_summary
  @property int $show_manager
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property EmplAddress[] $emplAddresses
 * @property EmplEconomicSector[] $emplEconomicSectors
 * @property SOwnership $ownership
 * @property User $createdBy
 * @property User $updatedBy
 * @property SEmployerType $employerType
 * @property SRegistrationauthority $registrationAuthority
 * @property EmplEmployerStatus[] $emplEmployerStatuses
 * @property EmplEmployerSummary[] $emplEmployerSummaries
 * @property EmplManagers[] $emplManagers
 * @property EmplReference[] $emplReferences
 */
class EmplEmployer extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    public $picture;
    private $_rt_softdelete;
    private $_rt_softrestore;
    public $global_search;
    public $district_id;
    public $empl_phone_number;
    public $empl_email;
    public $empl_economic_sector;
    public $stat;

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

    public $national_id;
    public $reg_number;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%empl_employer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['company_name'], 'required'],
            [['parent', 'child', 'employer_type_id', 'registration_authority_id', 'ownership_id', 'show_address', 'show_economic_sector', 'show_employer_status', 'show_reference', 'show_employer_summary', 'show_manager', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['opening_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['company_name', 'company_name_abbraviatio'], 'string', 'max' => 45],
            [['avatar_path', 'avatar_base_url'], 'string', 'max' => 255],
            [['tin', 'national_id', 'reg_number'], 'string', 'max' => 16],
            // [['tin'], 'match', 'pattern' => '/^\d{9}$/', 'message' => 'TIN number must contain exactly 9 digits.'],
            // [['national_id'], 'match', 'pattern' => '/^\d{16}$/', 'message' => 'ID number must contain exactly 16 digits.'],
            [['company_name'], 'unique'],
            [['ownership_id'], 'exist', 'skipOnError' => true, 'targetClass' => SOwnership::class, 'targetAttribute' => ['ownership_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['employer_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SEmployerType::class, 'targetAttribute' => ['employer_type_id' => 'id']],
            [['registration_authority_id'], 'exist', 'skipOnError' => true, 'targetClass' => SRegistrationauthority::class, 'targetAttribute' => ['registration_authority_id' => 'id']],
            [['picture'], 'file', 'extensions' => 'png', 'maxSize' => 2 * 1024 * 1024, 'mimeTypes' => ['image/png']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'company_name' => Yii::t('frontend', 'Employer name'),
            'company_name_abbraviatio' => Yii::t('frontend', 'Abbreviation'),
            'avatar_path' => Yii::t('frontend', 'Avatar Path'),
            'avatar_base_url' => Yii::t('frontend', 'Avatar Base Url'),
            'parent' => Yii::t('frontend', 'Parent'),
            'picture' => Yii::t('frontend', 'Logo'),
            'child' => Yii::t('frontend', 'Child'),
            'employer_type_id' => Yii::t('frontend', 'Employer type'),
            'opening_date' => Yii::t('frontend', 'Opening date'),
            'registration_authority_id' => Yii::t('frontend', 'Registration Authority'),
            'tin' => Yii::t('frontend', 'TIN'),
            'ownership_id' => Yii::t('frontend', 'Ownership'),
            'show_address' => Yii::t('frontend', 'Show Address'),
            'show_economic_sector' => Yii::t('frontend', 'Show Economic Sector'),
            'show_employer_status' => Yii::t('frontend', 'Show Employer Status'),
            'show_reference' => Yii::t('frontend', 'Show Reference'),
            'show_employer_summary' => Yii::t('frontend', 'Show Employer Summary'),
            'show_manager' => Yii::t('frontend', 'Show manager'),
            'created_by' => Yii::t('frontend', 'Created By'),
            'created_at' => Yii::t('frontend', 'Registration Date'),
            'deleted_by' => Yii::t('frontend', 'Deleted By'),
            'deleted_at' => Yii::t('frontend', 'Deleted At'),
            'updated_by' => Yii::t('frontend', 'Updated By'),
            'updated_at' => Yii::t('frontend', 'Updated At'),
            'national_id' => Yii::t('frontend', 'National ID number'),
            'reg_number' => Yii::t('frontend', 'Registration number'),
        ];
    }

    public function tinNumber() {

        switch ($this->employer_type_id) {

            case 1:
                return $this->tin = $this->national_id;
                break;

            case 3:
                return $this->tin = $this->tin;
                break;

            default:
                return $this->tin = $this->reg_number;
                break;
        }
    }

    function getEmployersByUser($user) {
        return $this->find()->where(['deleted_by is null'])->asArray()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplAddresses() {
        return $this->hasMany(EmplAddress::class, ['employer_id' => 'id']);
    }

    public function getEmplAddress() {
        return $this->hasOne(EmplAddress::class, ['employer_id' => 'id'])->where(['empl_address.status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEconomicSectors() {
        return $this->hasMany(EmplEconomicSector::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEconomicSector() {
        return $this->hasOne(EmplEconomicSector::class, ['employer_id' => 'id'])->where(['empl_economic_sector.status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnership() {
        return $this->hasOne(SOwnership::class, ['id' => 'ownership_id']);
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
    public function getEmployerType() {
        return $this->hasOne(SEmployerType::class, ['id' => 'employer_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistrationAuthority() {
        return $this->hasOne(SRegistrationauthority::class, ['id' => 'registration_authority_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEmployerStatuses() {
        return $this->hasMany(EmplEmployerStatus::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEmployerSummaries() {
        return $this->hasOne(EmplSummary::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplManagers() {
        return $this->hasMany(EmplManagers::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplReferences() {
        return $this->hasMany(EmplReference::class, ['employer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @param null $default
     * @return bool|null|string
     */
    public function getAvatar($default = null) {
        return $this->avatar_path ? Yii::getAlias($this->avatar_base_url . '/' . $this->avatar_path) : $default;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EmplEmployerQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\EmplEmployerQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function behaviors() {
        if (!Yii::$app->user->isGuest) {
            return [
                // 'picture' => [
                //     'class' => UploadBehavior::class,
                //     'attribute' => 'picture',
                //     'pathAttribute' => 'avatar_path',
                //     'baseUrlAttribute' => 'avatar_base_url'
                // ],          

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
        }

        return [
            // 'picture' => [
            //     'class' => UploadBehavior::class,
            //     'attribute' => 'picture',
            //     'pathAttribute' => 'avatar_path',
            //     // 'baseUrlAttribute' => 'avatar_base_url'
            // ],          

            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public static function data() {
        return static::find()
                        ->select(['concat(company_name,"(",company_name_abbraviatio,")") as value', 'company_name as  label', 'empl_employer.id as id'])
                        ->active()
                        ->asArray()
                        ->all();
    }

    public function getRegistrationdate() {
        $date = $this->created_at;
        $registrationdate = date("Y-m-d", strtotime($date));

        return $registrationdate;
    }

    public function totalpublic($district, $ownership = null) {
        if (isset($_GET['ownership']))
            $ownership = $_GET['ownership'];
        return $this->find()->publicEmployers($ownership)->andWhere(['district_id' => $district])->AndWhere(['deleted_by' => 0])->count();
    }

    // public static function data(){
    //     return array_merge(self::dataEmployer(), \common\models\UserProfile::data());
    // }
}
