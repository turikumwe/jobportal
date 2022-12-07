<?php

namespace common\models;

use Yii;
use backend\models\SStatus;
use common\models\UserProfile;
use backend\models\SAreaExpertise;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\SEmploymentStatus;
use backend\models\SSpecialAssistance;

/**
 * This is the model class for table "{{%js_event_application}}".
 *
 * @property int $id Application ID
 * @property int $user_id Job seeker
 * @property int $even_id Event
 * @property string $motivation Motivation
 * @property string $application_date Application date
 * @property int $area_of_expertise_id Area of expertise
 * @property int $employment_status_id Employment Status
 * @property int $special_assistance_id If you need a special assistance
 * @property int $status_id Application status
 * @property int $placement Application status
 * @property int $created_by
 * @property string $created_at
 * @property string $s_opportunity_id
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $user
 * @property ServiceEvent $even
 * @property SStatus $status
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 * @property SAreaExpertise $areaOfExpertise
 * @property SEmploymentStatus $employmentStatus
 * @property SSpecialAssistance $specialAssistance
 */
class JsEventApplication extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;
    public $certificateFile;
    public $stat;
    public $event_end_date;
    public $event;
    public $event_venue;
    public $start;
    public $end;
    public $user_gender;
    public $event_start_date;

    //public $event_title;

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
        return '{{%js_event_application}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'even_id', 'motivation', 'area_of_expertise_id', 'employment_status_id', 'special_assistance_id'], 'required'],
            [['user_id', 'even_id', 'area_of_expertise_id', 'employment_status_id', 'special_assistance_id', 'status_id', 'created_by', 'deleted_by', 'updated_by', 's_opportunity_id', 'placement'], 'integer'],
            [['motivation'], 'string'],
            [['application_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['even_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceEvent::class, 'targetAttribute' => ['even_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => SStatus::class, 'targetAttribute' => ['status_id' => 'pk_status']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value' => 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['area_of_expertise_id'], 'exist', 'skipOnError' => true, 'targetClass' => SAreaExpertise::class, 'targetAttribute' => ['area_of_expertise_id' => 'id']],
            [['employment_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => SEmploymentStatus::class, 'targetAttribute' => ['employment_status_id' => 'id']],
            [['special_assistance_id'], 'exist', 'skipOnError' => true, 'targetClass' => SSpecialAssistance::class, 'targetAttribute' => ['special_assistance_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'Event applicant'),
            'even_id' => Yii::t('common', 'Even title'),
            'motivation' => Yii::t('common', 'Motivation'),
            'placement' => Yii::t('common', 'Completed'),
            'application_date' => Yii::t('common', 'Application date'),
            'area_of_expertise_id' => Yii::t('common', 'Area of expertise'),
            'employment_status_id' => Yii::t('common', 'Employment status'),
            'special_assistance_id' => Yii::t('common', 'Special assistance'),
            'status_id' => Yii::t('common', 'Application status'),
            'user_gender' => Yii::t('common', 'Gender'),
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
    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEven() {
        return $this->hasOne(ServiceEvent::class, ['id' => 'even_id']);
    }

    public function eventApplied($id) {
        return JsEventApplication::find()->where(['user_id' => \Yii::$app->user->id])->andWhere(['even_id' => $id])->count();
    }

    public function placed($application) {

        $application->placement = 1;
        $application->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus() {
        return $this->hasOne(SStatus::class, ['pk_status' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunity() {
        return $this->hasOne(SOpportunity::class, ['id' => 's_opportunity_id']);
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
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaOfExpertise() {
        return $this->hasOne(SAreaExpertise::className(), ['id' => 'area_of_expertise_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmploymentStatus() {
        return $this->hasOne(SEmploymentStatus::className(), ['id' => 'employment_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialAssistance() {
        return $this->hasOne(SSpecialAssistance::className(), ['id' => 'special_assistance_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\JsEventApplicationQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new \common\models\query\JsEventApplicationQuery(get_called_class());
        return $query->where(['js_event_application.deleted_by' => 0]);
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

    public static function jobseekersApplied($event, $opportunity) {
        $events = JsEventApplication::find()->select('user_id')->where(['even_id' => $event, 's_opportunity_id' => $opportunity])->groupBy('user_id')->all();
        $jobseekers = [];
        foreach ($events as $event) {
            $jobseekers[] = ['id' => $event->user_id, 'name' => $event->user->userProfile->fullname];
        }

        return $jobseekers;
    }

    public function numberofGenderApplied($gender, $event) {
        //TODO FIND BETTER WAY TO DO THIS QUERY
        $list = JsEventApplication::find()->joinWith('user')
                ->andWhere(['even_id' => $event])
                ->andWhere([
            'IN', 'user.id', UserProfile::find()->select('user_id')->where(['gender' => $gender])
        ]);

        return $list->count();
    }

    public static function canApply($event_id) {
       
        if (Yii::$app->user->can('user')) {
            //Check if the user applied on this event
            $user_application = JsEventApplication::find()->select('user_id')->where(['even_id' => $event_id, 'user_id' => Yii::$app->user->id])->all();
            if (count($user_application) == 0) {
                return true;
            }
        }
        return false;
    }

}
