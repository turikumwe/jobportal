<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_address}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sector_id
 * @property integer $district_id
 * @property string $emailAddress
 * @property string $phoneNumber
 * @property string $pobox
 * @property string $physicalAddress
 * @property integer $created_by
 * @property string $created_at
 * @property integer $deleted_by
 * @property string $deleted_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property \common\models\SVillage $village
 * @property \common\models\User $user
 * @property \common\models\User $createdBy
 * @property \common\models\User $deletedBy
 * @property \common\models\User $updatedBy
 */
class JsAddress extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public $province_id;
    public $number;

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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id','district_id', 'sector_id'], 'required'],
            [['user_id', 'sector_id','district_id','country_id','status'], 'integer'],
            [['emailAddress', 'pobox', 'physicalAddress'], 'string', 'max' => 45],
            [['phoneNumber'], 'string', 'max' => 13],
            //[['emailAddress'], 'unique'],
            [['emailAddress'], 'email'],
            //[['phoneNumber'], 'unique'],
            [['deleted_by'], 'default', 'value'=> 0],
            [['status'], 'default', 'value'=> 1],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SGeosector::class, 'targetAttribute' => ['sector_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%js_address}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'user_id' => Yii::t('frontend', 'Job Seeker'),
            'province_id' => Yii::t('frontend', 'Province'),
            'district_id' => Yii::t('frontend', 'District'),
            'sector_id' => Yii::t('frontend', 'Sector'),
            'country_id' => Yii::t('frontend', 'Country'),
            'emailAddress' => Yii::t('frontend', 'Email Address'),
            'phoneNumber' => Yii::t('frontend', 'Phone Number'),
            'pobox' => Yii::t('frontend', 'Pobox'),
            'physicalAddress' => Yii::t('frontend', 'Physical Address'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeosector()
    {
        return $this->hasOne(\backend\models\SGeosector::class, ['id' => 'sector_id']);
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(\backend\models\SDistrict::class, ['id' => 'district_id']);
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(\backend\models\SCountrycodeIso3166::class, ['id' => 'country_id']);
    } 
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'deleted_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'updated_by']);
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
     * The following code shows how to apply a default condition for all queries:
     *
     * ```php
     * class Customer extends ActiveRecord
     * {
     *     public static function find()
     *     {
     *         return parent::find()->where(['deleted' => false]);
     *     }
     * }
     *
     * // Use andWhere()/orWhere() to apply the default condition
     * // SELECT FROM customer WHERE `deleted`=:deleted AND age>30
     * $customers = Customer::find()->andWhere('age>30')->all();
     *
     * // Use where() to ignore the default condition
     * // SELECT FROM customer WHERE age>30
     * $customers = Customer::find()->where('age>30')->all();
     * ```
     */

    /**
     * @inheritdoc
     * @return \common\models\query\JsAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsAddressQuery(get_called_class());
        return $query->where(['js_address.deleted_by' => 0]);
    }

    public static function currentAddress() {
        return isset(JsAddress::find()->latest()->owner()->one()->physicalAddress) ? 
        JsAddress::find()->latest()->owner()->one()->physicalAddress :  '-';
    }

    public function totalJobseekersByDistrict($district){
        return $this->find()->select(['user_id'])
        ->Where(['district_id' => $district])
        ->AndWhere(['deleted_by' => 0])
        ->distinct()
        ->count();
    }
}
