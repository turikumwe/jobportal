<?php

namespace common\models;

use Yii;
use backend\models\SStatus;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_job_application}}".
 *
 * @property int $id Application ID
 * @property int $user_id Job seeker
 * @property int $job_id Job
 * @property string $motivation Motivation
 * @property string $application_date Application date
 * @property int $status_id Application status
 * @property string $reason_rejection
 * @property int $placement
 * @property int $created_by
 * @property string $created_at
 * @property string $s_opportunity_id
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $user
 * @property SStatus $status
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 * @property ServiceJob $job
 */
class JsJobApplication extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    const JOB_APPLICATION_STATUS_ACCEPTED = 2;

    private $_rt_softdelete;
    private $_rt_softrestore;
    public $certificateFile;
    public $stat;
    public $accepted;
    public $rejected;
    public $waiting;
    public $end;
    public $start;
    public $closure_start;
    public $closure_end;

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
        return '{{%js_job_application}}';
    }

    public function search($params) {

        $query = JsJobApplication::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        return $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'job_id'], 'required'],
            [['user_id', 'job_id', 'job_application_status_id', 'placement_status_id', 'created_by', 'deleted_by', 'updated_by', 's_opportunity_id', 'placement'], 'integer'],
            [['motivation'], 'string'],
            [['application_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['motivation'], 'string', 'max' => 3700],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['job_application_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobApplicationStatus::class, 'targetAttribute' => ['job_application_status_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value' => 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceJob::class, 'targetAttribute' => ['job_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'Job applicant'),
            'job_id' => Yii::t('common', 'Job title'),
            'motivation' => Yii::t('common', 'Cover letter'),
            'application_date' => Yii::t('common', 'Application date'),
            'job_application_status_id' => Yii::t('common', 'Application status'),
            'placement_status_id' => Yii::t('common', 'Placement status'),
            'placement' => Yii::t('common', 'Placed'),
            'created_by' => Yii::t('common', 'Created by'),
            'created_at' => Yii::t('common', 'Created at'),
            'deleted_by' => Yii::t('common', 'Deleted by'),
            'deleted_at' => Yii::t('common', 'Deleted at'),
            'updated_by' => Yii::t('common', 'Updated by'),
            'updated_at' => Yii::t('common', 'Updated at'),
            'start' => Yii::t('frontend', 'Application start date'),
            'end' => Yii::t('frontend', 'Application End Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus() {
        return $this->hasOne(JobApplicationStatus::className(), ['id' => 'job_application_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy() {
        return $this->hasOne(User::className(), ['id' => 'deleted_by']);
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
    public function getJob() {
        return $this->hasOne(ServiceJob::class, ['id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunity() {
        return $this->hasOne(SOpportunity::class, ['id' => 's_opportunity_id']);
    }

    public function applied($id) {
        return JsJobApplication::find()->applied()->thatJob($id)->count();
    }

    public function countApplications($job_id) {
        return JsJobApplication::find()->where(['job_id' => $job_id])->count();
    }

    public function shortlisted($job_id) {
        return JsJobApplication::find()->leftJoin('job_application_status', 'job_application_status.id = js_job_application.job_application_status_id')
                        ->where(['job_application_status.status_id' => JsJobApplication::JOB_APPLICATION_STATUS_ACCEPTED])
                        ->andWhere(['js_job_application.job_id' => $job_id])->all();
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\JsJobApplicationQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new \common\models\query\JsJobApplicationQuery(get_called_class());
        return $query->where('js_job_application.deleted_by = 0 or js_job_application.deleted_by is null');
    }

    public function placed($application) {

        $application->placement = 1;
        $application->save(false);
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

    public static function jobseekersApplied($job, $opportunity) {
        $jobs = JsJobApplication::find()->select('user_id')->where(['job_id' => $job, 's_opportunity_id' => $opportunity])->groupBy('user_id')->all();
        $jobseekers = [];
        foreach ($jobs as $job) {
            $jobseekers[] = ['id' => $job->user_id, 'name' => $job->user->userProfile->fullname];
        }

        return $jobseekers;
    }

    public static function canApply($job_id) {

        if (Yii::$app->user->can('user')) {
            //Check if the user applied on this event
            $user_application = JsJobApplication::find()->select('user_id')->where(['job_id' => $job_id, 'user_id' => Yii::$app->user->id])->all();
            if (count($user_application) == 0) {
                if (User::isAJobSeeker(Yii::$app->user->id)) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function alreadyApplied($job_id) {

        //Check if the user applied on this event
        $user_application = JsJobApplication::find()->select('user_id')->where(['job_id' => $job_id, 'user_id' => Yii::$app->user->id])->all();
        if (count($user_application) > 0) {
            return true;
        }
        return false;
    }

}
