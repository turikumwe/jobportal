<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


use common\models\User;
use backend\models\SCountrycodeIso3166;
use backend\models\SNoyes;
use backend\models\SPermitType;


/**
 * This is the model class for table "{{%js_driving_license}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $having_license
 * @property int $license_type_id
 * @property int $country_id
 * @property string $expering_date
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $user
 * @property SCountrycodeIso3166 $country
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 * @property SNoyes $havingLicense
 * @property SPermitType $licenseType
 * @property JsDrivingLicenseCategory[] $jsDrivingLicenseCategories
 */
class JsDrivingLicense extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
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
    public static function tableName()
    {
        return '{{%js_driving_license}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'having_license'], 'required'],
            [['user_id', 'having_license', 'license_type_id', 'country_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['expering_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => SCountrycodeIso3166::class, 'targetAttribute' => ['country_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['having_license'], 'exist', 'skipOnError' => true, 'targetClass' => SNoyes::class, 'targetAttribute' => ['having_license' => 'id']],
            [['license_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SPermitType::class, 'targetAttribute' => ['license_type_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'Job seeker'),
            'having_license' => Yii::t('common', 'Do you have Driving License?'),
            'license_type_id' => Yii::t('common', 'License Type'),
            'country_id' => Yii::t('common', 'Country'),
            'expering_date' => Yii::t('common', 'Expering Date'),
            'created_by' => Yii::t('common', 'Created By'),
            'created_at' => Yii::t('common', 'Created At'),
            'deleted_by' => Yii::t('common', 'Deleted By'),
            'deleted_at' => Yii::t('common', 'Deleted At'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(SCountrycodeIso3166::class, ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHavingLicense()
    {
        return $this->hasOne(SNoyes::class, ['id' => 'having_license']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicenseType()
    {
        return $this->hasOne(SPermitType::class, ['id' => 'license_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsDrivingLicenseCategories()
    {
        return $this->hasMany(JsDrivingLicenseCategory::class, ['driving_license_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

     /**
     * @inheritdoc
     * @return \common\models\query\JsAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsDrivingLicenseQuery(get_called_class());
        return $query->where(['js_driving_license.deleted_by' => 0]);
    }
}
