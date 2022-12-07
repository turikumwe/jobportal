<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use backend\models\SPermitCategory;
use common\models\User;

/**
 * This is the model class for table "{{%js_driving_license_category}}".
 *
 * @property int $id
 * @property int $driving_license_id
 * @property int $license_category_id
 * @property string $issued_date
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property JsDrivingLicense $drivingLicense
 * @property SPermitCategory $licenseCategory
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 */
class JsDrivingLicenseCategory extends \yii\db\ActiveRecord
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
        return '{{%js_driving_license_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['license_category_id'], 'required'],
            [['driving_license_id', 'license_category_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['issued_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['driving_license_id'], 'exist', 'skipOnError' => true, 'targetClass' => JsDrivingLicense::className(), 'targetAttribute' => ['driving_license_id' => 'id']],
            [['license_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SPermitCategory::className(), 'targetAttribute' => ['license_category_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'driving_license_id' => Yii::t('common', 'Driving License'),
            'license_category_id' => Yii::t('common', 'License Category'),
            'issued_date' => Yii::t('common', 'Issued Date'),
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
    public function getDrivingLicense()
    {
        return $this->hasOne(JsDrivingLicense::className(), ['id' => 'driving_license_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicenseCategory()
    {
        return $this->hasOne(SPermitCategory::className(), ['id' => 'license_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'deleted_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
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
        $query = new \common\models\query\JsDrivingLicenseCategoryQuery(get_called_class());
        return $query->where(['js_driving_license_category.deleted_by' => 0]);
    }

    public function categories($id)
    {
        return JsDrivingLicenseCategory::find()->where('driving_license_id=:u',['u'=>$id])->all();
        
    }
}
