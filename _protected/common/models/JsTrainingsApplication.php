<?php

namespace common\models;

use Yii;
use backend\models\SStatus;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_trainings_application}}".
 *
 * @property int $id Traning PK
 * @property int $user_id Job seeker
 * @property int $training_id Training
 * @property string $motivation Motivation
 * @property string $application_date Application date
 * @property int $status_id Application status
 * @property string $reason_rejection
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $user
 * @property ServiceTraining $training
 * @property SStatus $status
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 */
class JsTrainingsApplication extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

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
        return '{{%js_trainings_application}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'training_id', 'motivation'], 'required'],
            [['user_id', 'training_id', 'status_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['motivation'], 'string'],
            [['application_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['reason_rejection'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['training_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceTraining::className(), 'targetAttribute' => ['training_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => SStatus::className(), 'targetAttribute' => ['status_id' => 'pk_status']],
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
            'user_id' => Yii::t('common', 'Training applicant'),
            'training_id' => Yii::t('common', 'Training title'),
            'motivation' => Yii::t('common', 'Motivation'),
            'application_date' => Yii::t('common', 'Application date'),
            'status_id' => Yii::t('common', 'Application status'),
            'reason_rejection' => Yii::t('common', 'Rejection reason'),
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
    public function getTraining()
    {
        return $this->hasOne(ServiceTraining::className(), ['id' => 'training_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(SStatus::className(), ['pk_status' => 'status_id']);
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

    public function trainingApplied($id){
       return JsTrainingsApplication::find()->where(['user_id' => \Yii::$app->user->id])->andWhere(['training_id' => $id])->count(); 
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
     * @return \common\models\query\JsTrainingsApplicationQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsTrainingsApplicationQuery(get_called_class());
        return $query->where(['js_trainings_application.deleted_by' => 0]);
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
