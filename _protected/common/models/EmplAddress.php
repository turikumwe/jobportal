<?php

namespace common\models;

use Yii;
use backend\models\SGeosector;
use backend\models\SDistrict;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%empl_address}}".
 *
 * @property int $id
 * @property int $employer_id
 * @property int $geo_sector_id
 * @property string $email_address
 * @property string $phone_number
 * @property string $pobox
 * @property string $website
 * @property string $physical_address
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property EmplEmployer $employer
 * @property User $createdBy
 * @property User $updatedBy
 * @property SGeosector $geoSector
 */
class EmplAddress extends \yii\db\ActiveRecord
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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%empl_address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_id','district_id','geo_sector_id'],'required'],
            [['employer_id', 'geo_sector_id', 'created_by', 'deleted_by', 'updated_by','status'], 'integer'],
            [['created_at', 'deleted_at', 'updated_at', 'created_by', 'deleted_by'], 'safe'],
            [['email_address', 'pobox', 'physical_address'], 'string', 'max' => 45],
            [['phone_number'], 'string', 'max' => 13],
            [['deleted_by'], 'default', 'value'=> 0],
            [['status'], 'default', 'value'=> 1],
            [['website'], 'string', 'max' => 100],
            // [['phone_number','email_address'], 'unique'],
            [['email_address'], 'email'],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmplEmployer::class, 'targetAttribute' => ['employer_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['geo_sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SGeosector::class, 'targetAttribute' => ['geo_sector_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'employer_id' => Yii::t('frontend', 'Employer'),
            'geo_sector_id' => Yii::t('frontend', 'Sector'),
            'email_address' => Yii::t('frontend', 'Email address'),
            'phone_number' => Yii::t('frontend', 'Phone number'),
            'pobox' => Yii::t('frontend', 'P.o.Box'),
            'website' => Yii::t('frontend', 'Website'),
            'physical_address' => Yii::t('frontend', 'Physical address'),
            'created_by' => Yii::t('frontend', 'Created by'),
            'created_at' => Yii::t('frontend', 'Created at'),
            'deleted_by' => Yii::t('frontend', 'Deleted by'),
            'deleted_at' => Yii::t('frontend', 'Deleted at'),
            'updated_by' => Yii::t('frontend', 'Updated by'),
            'updated_at' => Yii::t('frontend', 'Updated at'),
            'province_id' => Yii::t('frontend', 'Province'),
            'district_id' => Yii::t('frontend', 'District'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer()
    {
        return $this->hasOne(EmplEmployer::class, ['id' => 'employer_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoSector()
    {
        return $this->hasOne(SGeosector::class, ['id' => 'geo_sector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrictRelation()
    {
        return $this->hasOne(SDistrict::class, ['id' => 'district_id']);
    } 

    /**
     * {@inheritdoc}
     * @return \common\models\query\EmplAddressQuery the active query used by this AR class.
     */ 
    public static function find()
    {
        $query = new \common\models\query\EmplAddressQuery(get_called_class());
        return $query->where(['empl_address.deleted_by' => 0]);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        if(!Yii::$app->user->isGuest){
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

    public function getDistrict(){
        return isset($this->geoSector->district->id) ?  $this->geoSector->district->id  : 0;
    }

    public function getProvince(){
        return isset($this->geoSector->district->province->id) ?  $this->geoSector->district->province->id  : '';
    }
    public function totalEmployersByDistrict($district){
        return $this->find()->select(['employer_id'])
        ->Where(['district_id' => $district])
        ->AndWhere(['deleted_by' => 0])
        ->count();
    }
}
