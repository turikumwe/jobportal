<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%service_job_sharing}}".
 *
 * @property int $id
 * @property int $user_id sender
 * @property int $job_seeker_id Receiver
 * @property int $job_id job to be shared
 * @property string $message ant kind of message to motivate the receiver to apply for the job
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 * @property string $email
 *
 * @property User $user
 * @property User $jobSeeker
 * @property ServiceJob $job
 * @property User $createdBy
 * @property User $updatedBy
 */
class ServiceJobSharing extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;
    public $certificateFile;
    public $email;


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
        return '{{%service_job_sharing}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'email', 'job_id'], 'required'],
            [['user_id', 'job_seeker_id', 'job_id', 'created_by', 'deleted_by', 'updated_by','s_opportunity_id'], 'integer'],
            [['message','email'], 'string'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
            //[['email'], 'email'],
            [['job_seeker_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['job_seeker_id' => 'id']],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceJob::className(), 'targetAttribute' => ['job_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'user_id' => Yii::t('common', 'User'),
            'job_seeker_id' => Yii::t('common', 'Job seeker'),
            'job_id' => Yii::t('common', 'Job title'),
            'email' => Yii::t('common' , 'Email'),
            'message' => Yii::t('common', 'Message'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobSeeker()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'job_seeker_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(ServiceJob::className(), ['id' => 'job_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceJobSharingQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\ServiceJobSharingQuery(get_called_class());
        return $query->where(['service_job_sharing.deleted_by' => 0]);
    }

    public function saved($id){ 
       return ServiceJobSharing::find()
                            ->where(['user_id' => \Yii::$app->user->id])
                            ->andWhere(['job_id' => $id])
                            ->andWhere(['job_seeker_id' => \Yii::$app->user->id])
                            ->count(); 
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
}
