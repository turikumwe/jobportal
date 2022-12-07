<?php

namespace common\models;

use Yii;
use backend\models\SGeosector;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%md_address}}".
 *
 * @property int $id
 * @property int $mediator_id
 * @property int $geo_sector_id
 * @property string $email_address
 * @property string $phone_number
 * @property string $pobox
 * @property string $physical_address
 * @property int $current_address
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property MdMediator $mediator
 * @property SGeosector $geoSector
 * @property User $createdBy
 * @property User $updatedBy
 */
class MdAddress extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    public $picture;
    private $_rt_softdelete;
    private $_rt_softrestore;
    public $global_search;

    public $province_id;
    public $district_id;

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
        return '{{%md_address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_id','district_id','geo_sector_id'],'required'],
            [['mediator_id', 'geo_sector_id', 'current_address', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['email_address', 'pobox'], 'string', 'max' => 45],
            [['phone_number'], 'string', 'max' => 13],
            [['deleted_by'], 'default', 'value'=> 0],
            [['physical_address'], 'string', 'max' => 100],
            [['email_address'], 'unique'],
            [['email_address'], 'email'],
            [['phone_number'], 'unique'],
            [['deleted_by'], 'default', 'value'=> 0],
            [['mediator_id'], 'exist', 'skipOnError' => true, 'targetClass' => MdMediator::class, 'targetAttribute' => ['mediator_id' => 'id']],
            [['geo_sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SGeosector::class, 'targetAttribute' => ['geo_sector_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'mediator_id' => Yii::t('common', 'Mediator'),
            'geo_sector_id' => Yii::t('common', 'Sector'),
            'province_id' => Yii::t('common', 'Province'),
            'district_id' => Yii::t('common', 'District'),
            'email_address' => Yii::t('common', 'Email address'),
            'phone_number' => Yii::t('common', 'Phone number'),
            'pobox' => Yii::t('common', 'P.o.Box'),
            'physical_address' => Yii::t('common', 'Physical address'),
            'current_address' => Yii::t('common', 'Current address'),
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
    public function getMediator()
    {
        return $this->hasOne(MdMediator::class, ['id' => 'mediator_id']);
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
     * {@inheritdoc}
     * @return \common\models\query\MdAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\MdAddressQuery(get_called_class());
        return $query->where(['md_address.deleted_by' => 0]);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
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

    public function getDistrict(){
        return isset($this->geoSector->district->id) ?  $this->geoSector->district->id  : 0;
    }

    public function getProvince(){
        return isset($this->geoSector->district->province->id) ?  $this->geoSector->district->province->id  : '';
    }
}
