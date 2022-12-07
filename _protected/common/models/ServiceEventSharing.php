<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%service_event_sharing}}".
 *
 * @property int $id
 * @property int $user_id Sender
 * @property int $job_seeker_id Receiver
 * @property int $event_id Event to be shared
 * @property string $message ant kind of message to motivate the receiver to apply for the event
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $user
 * @property User $jobSeeker
  * @property User $email
 * @property ServiceEvent $event
 * @property User $createdBy
 * @property User $updatedBy
 */
class ServiceEventSharing extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;
    public $email ;
    public $certificateFile;


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
        return '{{%service_event_sharing}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'email', 'event_id'], 'required'],
            [['user_id', 'job_seeker_id', 'event_id', 'created_by', 'deleted_by', 'updated_by','s_opportunity_id'], 'integer'],
            [['message','email'], 'string'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['job_seeker_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['job_seeker_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceEvent::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
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
            'email' => Yii::t('common', 'Email'),
            'event_id' => Yii::t('common', 'Event title'),
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
    public function getEvent()
    {
        return $this->hasOne(ServiceEvent::className(), ['id' => 'event_id']);
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
     * @return \common\models\query\ServiceEventSharingQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\ServiceEventSharingQuery(get_called_class());
        return $query->where(['service_event_sharing.deleted_by' => 0]);
    }

    public function saved($id){ 
       return ServiceEventSharing::find()
                                    ->where(['user_id' => \Yii::$app->user->id])
                                    ->andWhere(['event_id' => $id])
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
