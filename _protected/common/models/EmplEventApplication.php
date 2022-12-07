<?php

namespace common\models;

use Yii;
use backend\models\SStatus;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%empl_event_application}}".
 *
 * @property int $id Application ID
 * @property int $employer_id Job seeker
 * @property int $even_id Event
 * @property string $motivation Motivation
 * @property string $application_date Application date
 * @property int $status_id Application status
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property EmplEmployer $employer
 * @property ServiceEvent $even
 * @property SStatus $status
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 */
class EmplEventApplication extends \yii\db\ActiveRecord
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
        return '{{%empl_event_application}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employer_id', 'even_id', 'motivation'], 'required'],
            [['employer_id', 'even_id', 'status_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['motivation'], 'string'],
            [['application_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmplEmployer::className(), 'targetAttribute' => ['employer_id' => 'id']],
            [['even_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceEvent::className(), 'targetAttribute' => ['even_id' => 'id']],
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
            'employer_id' => Yii::t('common', 'Employer'),
            'even_id' => Yii::t('common', 'Event'),
            'motivation' => Yii::t('common', 'Motivation'),
            'application_date' => Yii::t('common', 'Application date'),
            'status_id' => Yii::t('common', 'Application status'),
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
    public function getEmployer()
    {
        return $this->hasOne(EmplEmployer::className(), ['id' => 'employer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEven()
    {
        return $this->hasOne(ServiceEvent::className(), ['id' => 'even_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EmplEventApplicationQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\EmplEventApplicationQuery(get_called_class());
        return $query->where(['empl_event_application.deleted_by' => 0]);
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
