<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\SJobType;
use common\models\SOpportunity;
use Yii;

/**
 * This is the model class for table "{{%js_case_management}}".
 *
 * @property int $id
 * @property string $availability
 * @property int $given_service
 * @property int $type_of_job
 * @property string $willingness
 * @property string $license_permit
 * @property string $geven_service_description
 * @property string $cooperative cooperative with other organisation
 * @property int $jobseeker_id
 * @property int $mediotor_id
 * @property integer $created_by
 * @property string $created_at
 * @property integer $deleted_by
 * @property string $deleted_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property SJobType $typeOfJob
 * @property MdMediator $mediotor
 * @property UserProfile $jobseeker
 */
class JsCaseManagement extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;
    public $stat;
    public $start;
    public $end;

    public function __construct()
    {
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
        return '{{%js_case_management}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['given_service', 'geven_service_description'], 'required'],
            [['given_service', 'type_of_job', 'jobseeker_id', 'mediotor_id','application_id'], 'integer'],
            [['geven_service_description', 'cooperative'], 'string'],
            [['availability'], 'string', 'max' => 4],
            [['willingness'], 'string', 'max' => 11],
            [['license_permit'], 'string', 'max' => 10],
            [['deleted_by'], 'default', 'value'=> 0],
            [['availability'], 'default', 'value'=> 'No'],
            [['willingness'], 'default', 'value'=> 'No'],
            [['type_of_job'], 'exist', 'skipOnError' => true, 'targetClass' => SJobType::class, 'targetAttribute' => ['type_of_job' => 'id']],
            [['mediotor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['mediotor_id' => 'id']],
            [['jobseeker_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['jobseeker_id' => 'user_id']],
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
            'availability' => Yii::t('common', 'Availability'),
            'given_service' => Yii::t('common', 'Given Service'),
            'application_id' => Yii::t('common' , 'Application'),
            'type_of_job' => Yii::t('common', 'Type Of Job'),
            'willingness' => Yii::t('common', 'Willingness to move'),
            'license_permit' => Yii::t('common', 'License Permit'),
            'geven_service_description' => Yii::t('common', 'Geven Service Description'),
            'cooperative' => Yii::t('common', 'Cooperation with other organisation'),
            'jobseeker_id' => Yii::t('common', 'Jobseeker'),
            'mediotor_id' => Yii::t('common', 'Mediotor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeOfJob()
    {
        return $this->hasOne(SJobType::class, ['id' => 'type_of_job']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(SServices::class, ['id' => 'given_service']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediotor()
    {
        return $this->hasOne(User::class, ['id' => 'mediotor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobseeker()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'jobseeker_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'jobseeker_id']);
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

    public function getApplicationJob()
    {
        return $this->hasOne(JsJobApplication::class, ['id' => 'application_id'])
                            ->andFilterCompare('s_opportunity_id' ,SOpportunity::find()->select('id')->firstType(),'IN');
    }

    public function getApplicationEvent()
    {
        return $this->hasOne(JsEventApplication::class, ['id' => 'application_id'])
                        ->andFilterCompare('s_opportunity_id' ,SOpportunity::find()->select('id')->secondType(),'IN');
    }
    /**
     * {@inheritdoc}
     * @return \common\models\query\JsCaseManagementQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsCaseManagementQuery(get_called_class());
        return $query->where(['js_case_management.deleted_by' => 0]);
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

    public function numberofGender($gender, $service) {
        //TODO FIND BETTER WAY TO DO THIS QUERY
        $list = JsCaseManagement::find()->joinWith('user')
                ->andWhere(['given_service' => $service])
                ->andWhere([
                    'IN' , 'user.id' , UserProfile::find()->select('user_id')->where(['gender' => $gender])
                ]);

        return $list->count();
    }

    public function numberofGenderTotal($service) {
        //TODO FIND BETTER WAY TO DO THIS QUERY
        $list = JsCaseManagement::find()->joinWith('user')
                ->andWhere(['given_service' => $service])
                ->andWhere([
                    'IN' , 'user.id' , UserProfile::find()->select('user_id')
                ]);

        return $list->count();
    }
}
