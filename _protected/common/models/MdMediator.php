<?php

namespace common\models;

use Yii;
use backend\models\SRegistrationauthority;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\SMediatorType;
use backend\models\SOwnership;

/**
 * This is the model class for table "{{%md_mediator}}".
 *
 * @property int $id
 * @property int $registration_authority_id
 * @property string $registration_number
 * @property string $madiator_name
 * @property int $mediator_type_id
 * @property string $opening_date
 * @property int $ownership_id
 * @property int $show_address
 * @property int $show_manager
 * @property int $show_employee
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property MdAddress[] $mdAddresses
 * @property MdEmployees[] $mdEmployees
 * @property MdManagers[] $mdManagers
 * @property SRegistrationauthority $registrationAuthority
 * @property SMediatorType $mediatorType
 * @property User $createdBy
 * @property User $updatedBy
 * @property SOwnership $ownership
 */
class MdMediator extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    const MEDIATOR_TYPE_PRIVATE = 2;
    const MEDIATOR_TYPE_PUBLIC = 1;
    public $picture;
    private $_rt_softdelete;
    private $_rt_softrestore;
    public $global_search;

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

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%md_mediator}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['registration_authority_id', 'mediator_type_id', 'ownership_id', 'show_address', 'show_manager', 'show_employee', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['madiator_name'], 'required'],
            [['mediator_status','opening_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['registration_number', 'madiator_name'], 'string', 'max' => 45],
            [['madiator_name'], 'unique'],
            // [['registration_number'], 'unique'],
            [['deleted_by'], 'default', 'value' => 0],
            [['registration_authority_id'], 'exist', 'skipOnError' => true, 'targetClass' => SRegistrationauthority::class, 'targetAttribute' => ['registration_authority_id' => 'id']],
            [['mediator_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SMediatorType::class, 'targetAttribute' => ['mediator_type_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['ownership_id'], 'exist', 'skipOnError' => true, 'targetClass' => SOwnership::class, 'targetAttribute' => ['ownership_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'registration_authority_id' => Yii::t('common', 'Registration authority'),
            'registration_number' => Yii::t('common', 'Registration number'),
            'madiator_name' => Yii::t('common', 'Mediator institution name'),
            'mediator_type_id' => Yii::t('common', 'Mediator type'),
            'opening_date' => Yii::t('common', 'Opening date'),
            'ownership_id' => Yii::t('common', 'Ownership'),
            'mediator_status' => Yii::t('common', 'Status'),
            'show_address' => Yii::t('common', 'Show address'),
            'show_manager' => Yii::t('common', 'Show manager'),
            'show_employee' => Yii::t('common', 'Show employee'),
            'created_by' => Yii::t('common', 'Created by'),
            'created_at' => Yii::t('common', 'Created at'),
            'deleted_by' => Yii::t('common', 'Deleted by'),
            'deleted_at' => Yii::t('common', 'Deleted at'),
            'updated_by' => Yii::t('common', 'Updated by'),
            'updated_at' => Yii::t('common', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdAddresses() {
        return $this->hasMany(MdAddress::class, ['mediator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts() {
        return $this->hasMany(SDistrict::className(), ['mediator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdEmployees() {
        return $this->hasMany(MdEmployees::class, ['mediator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdManagers() {
        return $this->hasMany(MdManagers::class, ['mediator_id' => 'id']);
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
    public function getMediatorType() {
        return $this->hasOne(SMediatorType::class, ['id' => 'mediator_type_id']);
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
    public function getOwnership() {
        return $this->hasOne(SOwnership::class, ['id' => 'ownership_id']);
    }

    /**
     * {@inheritdoc}
     * @return MdMediatorQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\MdMediatorQuery(get_called_class());
    }

    public static function isFromPublicMediator() {
        $user = User::findOne(Yii::$app->user->id);
        $mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;

        if (isset($mediator)) {
            if ($mediator->mediator_type_id == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function behaviors() {
        if (!Yii::$app->user->isGuest) {
            return [
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
                        ->select(['madiator_name as value', 'madiator_name as  label', 'md_mediator.id as id'])
                        ->active()
                        ->asArray()
                        ->all();
    }

}
