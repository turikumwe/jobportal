<?php

namespace common\models;

use Yii;
use backend\models\SActions;
use \backend\models\SGeosector;
use backend\models\SEventDuration;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%service_event}}".
 *
 * @property int $id
 * @property string $event_title
 * @property int s_opportunity_id
 * @property string $event_summary
 * @property string $event_requirement
 * @property string $event_location
 * @property string $start_date
  * @property string $email
 * @property string $event_duration
 * @property string $description_organiser
 * @property string $description_event
 * @property string $qualification_participant
 * @property string $number_participant
 * @property string $closure_date
 * @property string $how_to_apply
 * @property string $contact_phone
 * @property string $contact_email
 * @property int $posted
 * @property int $action_id
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 * @property string $end_date
 *
 * @property EmplEventApplication[] $emplEventApplications
 * @property JsEventApplication[] $jsEventApplications
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 * @property SEventCategory $eventCategory
 */
class ServiceEvent extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public $certificateFile;
    public $date_posted;
    public $active;
    public $archive;
    public $province;
    public $district;
    public $email;
    public $from;
    public $to;
    public $start;
    public $end;
    public $closure_start;
    public $closure_end;

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
        return '{{%service_event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_summary', 'event_requirement', 'event_location', 'start_date', 'closure_date', 'how_to_apply','s_opportunity_id','apply_through_kora_flag'], 'required'],
            [[ 'posted', 'action_id', 'created_by', 'deleted_by', 'updated_by','date_posted','s_opportunity_id','number_participant','event_duration','apply_through_kora_flag'], 'integer'],
            [['event_summary', 'event_requirement', 'how_to_apply','description_organiser','description_event','qualification_participant'], 'string'],
            [['start_date', 'closure_date', 'created_at', 'deleted_at', 'updated_at','end_date', 'docFile'], 'safe'],
            [['event_title', 'event_location','venue'], 'string', 'max' => 100],
            [['contact_phone'], 'string', 'max' => 15],
            [['contact_email'], 'string', 'max' => 50],
            [['doc_path'], 'string', 'max' => 255],
            [['contact_email'], 'email'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['docFile'], 'file', 'extensions' => 'pdf', 'maxSize' => 2 * 1024 * 1024, 'mimeTypes' => ['application/pdf']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'event_title' => Yii::t('common', 'Event title'),
            'event_summary' => Yii::t('common', 'Any further information'),
            'event_requirement' => Yii::t('common', 'Required key skills, knowledge and personal strength'),
            'event_location' => Yii::t('common', 'Sector'),
            'start_date' => Yii::t('common', 'Start date'),
            'end_date' => Yii::t('common', 'End date'),
            'closure_date' => Yii::t('common', 'Application deadline'),
            'docFile' => Yii::t('frontend', 'Additional attachment'),
            's_opportunity_id'  => Yii::t('common', 'Opportunity Type'),
            'how_to_apply' => Yii::t('common', 'Contact person and how to apply'),
            'apply_through_kora_flag' => Yii::t('frontend', 'Apply through kora'),
            'contact_phone' => Yii::t('common', 'Contact phone'),
            'contact_email' => Yii::t('common', 'Contact email'),
            'posted' => Yii::t('common', 'Posted by'),
            'description_organiser' => Yii::t('common', 'Description of Organiser'),
            'description_event' => Yii::t('common', 'Description of Event'),
            'qualification_participant' => Yii::t('common', 'Required qualification for participants'),
            'event_duration' => Yii::t('common', 'Event duration'),
            'number_participant' => Yii::t('common', 'Maximum number of participants'),
            'venue' => Yii::t('common', 'Event Location'),
            'action_id' => Yii::t('common', 'Action taken'),
            'created_by' => Yii::t('common', 'Created by'),
            'created_at' => Yii::t('common', 'Created at'),
            'deleted_by' => Yii::t('common', 'Deleted by'),
            'deleted_at' => Yii::t('common', 'Deleted at'),
            'updated_by' => Yii::t('common', 'Updated by'),
            'updated_at' => Yii::t('common', 'Updated at'),
            'start' => Yii::t('frontend','start_date'),
            'end' => Yii::t('frontend','End Date'),
            'closure_start' => Yii::t('frontend','Closure Start'),
            'closure_end' => Yii::t('frontend','Closure End'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEventApplications()
    {
        return $this->hasMany(EmplEventApplication::class, ['even_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsEventApplications()
    {
        return $this->hasMany(JsEventApplication::class, ['even_id' => 'id']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getEventDuration()
    {
        return $this->hasOne(SEventDuration::class, ['id' => 'event_duration']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(SGeosector::class, ['id' => 'event_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(SActions::className(), ['pk_action' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunity()
    {
        return $this->hasOne(SOpportunity::class, ['id' => 's_opportunity_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\ServiceEventQuery(get_called_class());
        return $query->where(['service_event.deleted_by' => 0]);
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

    public static function data()
    {
        return  static::find()
                    ->select(['event_title', 'event_title as  label','event_title AS id'])
                    ->published()
                    ->asArray()
                    ->all();
    }


    public function totalJobByDistrict($district, $opportunity=null)
    {
        if (isset($_GET['opportunity'])) {
            $opportunity = $_GET['opportunity'];
        }
        return $this->find()->opportunity($opportunity)
                                ->andWhere([
                                    'IN','event_location', SGeosector::find()->select('id')->andWhere(['district_id' => $district])
                                ])->count();
    }

    public function totalAvailableByDistrict($district, $opportunity=null)
    {
        if (isset($_GET['opportunity'])) {
            $opportunity = $_GET['opportunity'];
        }
        return $this->find()->opportunity($opportunity)->available()
                                ->andWhere([
                                                'IN','event_location', SGeosector::find()->select('id')->andWhere(['district_id' => $district])
                                            ]
                                )->count();
    }

    public function totalArchivedByDistrict($district, $opportunity=null)
    {
        if (isset($_GET['opportunity'])) {
            $opportunity = $_GET['opportunity'];
        }
        return $this->find()->opportunity($opportunity)->unavailable()
                                ->andWhere([
                                    'IN','event_location', SGeosector::find()->select('id')->andWhere(['district_id' => $district])
                                ])->count();
    }
}
