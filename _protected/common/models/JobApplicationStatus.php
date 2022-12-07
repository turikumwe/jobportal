<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\SEmployerStatus;

/**
 * This is the model class for table "{{%empl_status}}".
 *
 * @property int $id
 * @property int $job_application_id
 * @property int $status_id
 * @property string $status_date
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
 * @property SEmployerStatus $employerStatus
 */
class JobApplicationStatus extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    const JOB_APPLICATION_STATUS_ACCEPTED = 2;
    const JOB_APPLICATION_STATUS_REJECTED = 3;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct() {
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
    public static function tableName() {
        return '{{%job_application_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['job_application_id', 'status_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['status_comment', 'job_application_id'], 'required'],
            [['status_comment', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['deleted_by'], 'default', 'value' => 0],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => SEmployerStatus::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'job_application_id' => Yii::t('common', 'Job application'),
            'status_id' => Yii::t('common', 'Status'),
            'status_comment' => Yii::t('common', 'Status comment'),
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
    public function getJobApplication() {
        return $this->hasOne(JsJobApplication::class, ['id' => 'job_application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerStatus() {
        return $this->hasOne(\backend\models\SStatus::class, ['id' => 'status_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EmplStatusQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new \common\models\query\JobApplicationStatusQuery(get_called_class());
        return $query->where(['job_application_status.deleted_by' => 0]);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors() {
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
