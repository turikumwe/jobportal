<?php

namespace common\models;

use Yii;
use backend\models\SActions;
use backend\models\SJobType;
use backend\models\SDistrict;
use backend\models\SIsco08Level4;
use backend\models\SEducationLevel;
use backend\models\SEducationField;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "{{%service_job}}".
 *
 * @property int $id
 * @property string $employer
 * @property string $jobtitle
 * @property string $link
 * @property string $job_summary
 * @property string $job_responsability
 * @property string $job_skill_requirement
 * @property string $employerlogo_path
 * @property string $employerlogo_base_url
 * @property string $job_remuneration
 * @property int $positions_number
 * @property int $economic_sector_id
 * @property int $education_level_id
 * @property int $education_field_id
 * @property string $posting_date
 * @property string $closure_date
 * @property string $how_to_apply
 * @property int $years_of_experience
 * @property string $contact_phone
 * @property string $contact_email
 * @property int $action_id
 * @property int $s_opportunity_id
 * @property int $district_id
 * @property int $posted
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 * @property string $other_source
 *
 * @property JsJobApplication[] $jsJobApplications
 * @property Sisco08Level4 $economicSector
 * @property SDistrict $district
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 * @property SEducationLevel $educationLevel
 * @property SEducationField $educationField
 */
class ServiceJob extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    const JOB_RECRUITMENT_STAGE_PUBLISHED = 1;
    const JOB_RECRUITMENT_STAGE_SHORLISTING = 2;
    const JOB_RECRUITMENT_STAGE_SELECTION = 3;
    const JOB_STATUS_PUBLISHED = 1;
    const JOB_RECRUITMENT_STAGE_CLOSED = 4;
    const RESULTS_NOTIFIED = 1;

    private $_rt_softdelete;
    private $_rt_softrestore;
    public $employer_logo;
    public $province;
    public $from;
    public $to;
    public $date_posted;
    public $isco08level1_id;
    public $isco08level2_id;
    public $isco08level3_id;
    public $district;
    public $position;
    public $active;
    public $archive;
    public $numberOfAdvertised;
    public $numberOfActive;
    public $start;
    public $end;
    public $closure_start;
    public $closure_end;
    public $docFile;

    const SCENARIO_CREATE = 'create';

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
        return '{{%service_job}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['province', 'district_id', 'employer', 'jobtitle', 's_opportunity_id', 'closure_date', 'occupation_grouping_id', 'apply_through_kora_flag', 'action_id'], 'required'],
            [
                [
                    'isco08level1_id', 'positions_number'
                ],
                'required',
                'when' => function ($model) {
                    return $model->other_source == 1;
                }
            ],
            [
                [
                    'employer_logo', 'link'
                ],
                'required',
                'when' => function ($model) {
                    return $model->other_source == 0;
                }
            ],
            [['job_summary', 'job_responsability', 'job_skill_requirement', 'how_to_apply', 'link'], 'string'],
            [['positions_number', 'economic_sector_id', 'education_level_id', 'education_field_id', 'action_id', 'district_id', 'posted', 'created_by', 'deleted_by', 'updated_by', 'date_posted', 'job_type_id', 's_opportunity_id', 'years_of_experience', 'occupation_grouping_id', 'competency_level_id', 'apply_through_kora_flag'], 'integer'],
            [['posting_date', 'closure_date', 'created_at', 'deleted_at', 'updated_at', 'publication_date', 'recruitment_stage', 'results_notified','competency_level_id'], 'safe'],
            [['employer'], 'string', 'max' => 100],
            [['jobtitle', 'employerlogo_path', 'employerlogo_base_url'], 'string', 'max' => 255],
            [['doc_path'], 'string', 'max' => 255],
            // [['link'], 'url'],
            [['other_source'], 'string', 'max' => 1],
            [['job_remuneration', 'from', 'to'], 'string', 'max' => 20],
            ['position', 'each', 'rule' => ['integer']],
            ['district', 'each', 'rule' => ['integer']],
            [['contact_phone'], 'string', 'max' => 15],
            [['contact_email'], 'string', 'max' => 50],
            [['economic_sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sisco08Level4::class, 'targetAttribute' => ['economic_sector_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SDistrict::class, 'targetAttribute' => ['district_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value' => 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['education_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => SEducationLevel::class, 'targetAttribute' => ['education_level_id' => 'id']],
            [['education_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => SEducationField::class, 'targetAttribute' => ['education_field_id' => 'id']],
            [['employer_logo'], 'file', 'extensions' => 'png', 'maxSize' => 2 * 1024 * 1024, 'mimeTypes' => ['image/png']],
            [['docFile'], 'file', 'extensions' => 'pdf', 'maxSize' => 2 * 1024 * 1024, 'mimeTypes' => ['application/pdf']],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = [
            'link', 'province', 'district_id', 'positions_number', 'isco08level1_id', 'isco08level2_id', 'isco08level3_id'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'employer' => Yii::t('frontend', 'Employer'),
            'other_source' => Yii::t('frontend', 'Other source'),
            'jobtitle' => Yii::t('frontend', 'Job title'),
            'occupation_grouping_id' => Yii::t('frontend', 'Occupation grouping'),
            'competency_level_id' => Yii::t('frontend', 'Competency level'),
            'apply_through_kora_flag' => Yii::t('frontend', 'Apply through kora'),
            'job_type_id' => Yii::t('frontend', 'Contract information'),
            'docFile' => Yii::t('frontend', 'Additional attachment'),
            'link' => Yii::t('frontend', 'Job Link'),
            'job_summary' => Yii::t('frontend', 'Any further information'),
            'job_responsability' => Yii::t('frontend', 'Job Description and main duties and responsibilities of the position'),
            'job_skill_requirement' => Yii::t('frontend', 'Required key skills,knowledge and personal strengths'),
            'job_remuneration' => Yii::t('frontend', 'Remuneration'),
            's_opportunity_id' => Yii::t('frontend', 'Opportunity Type'),
            'positions_number' => Yii::t('frontend', 'Number of positions'),
            'economic_sector_id' => Yii::t('frontend', 'Occupation level 4'),
            'education_level_id' => Yii::t('frontend', 'Education level'),
            'education_field_id' => Yii::t('frontend', 'Education field'),
            'posting_date' => Yii::t('frontend', 'Publication date'),
            'closure_date' => Yii::t('frontend', 'Application Deadline'),
            'how_to_apply' => Yii::t('frontend', 'How to apply'),
            'contact_phone' => Yii::t('frontend', 'Contact phone'),
            'contact_email' => Yii::t('frontend', 'Contact email'),
            'action_id' => Yii::t('frontend', 'Action taken'),
            'district_id' => Yii::t('frontend', 'District'),
            'years_of_experience' => Yii::t('frontend', 'Years of experience'),
            'posted' => Yii::t('frontend', 'Posted by'),
            'created_by' => Yii::t('frontend', 'Created by'),
            'created_at' => Yii::t('frontend', 'Created at'),
            'deleted_by' => Yii::t('frontend', 'Deleted by'),
            'deleted_at' => Yii::t('frontend', 'Deleted at'),
            'updated_by' => Yii::t('frontend', 'Updated by'),
            'updated_at' => Yii::t('frontend', 'Updated at'),
            'publication_date' => Yii::t('frontend', 'Publication date'),
            'archive' => Yii::t('frontend', 'Archived'),
            'isco08level1_id' => Yii::t('frontend', 'Occupation level 1'),
            'isco08level2_id' => Yii::t('frontend', 'Occupation level 2'),
            'isco08level3_id' => Yii::t('frontend', 'Occupation level 3'),
            'employer_logo' => Yii::t('frontend', 'Employer Logo'),
            'start' => Yii::t('frontend', 'Posted Start'),
            'end' => Yii::t('frontend', 'Posted End'),
            'closure_start' => Yii::t('frontend', 'Closure Start'),
            'closure_end' => Yii::t('frontend', 'Closure End'),
            'results_notified' => Yii::t('frontend', 'Results notified'),
            'recruitment_stage' => Yii::t('frontend', 'Recruitment stage'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsJobApplications() {
        return $this->hasMany(JsJobApplication::class, ['job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobType() {
        return $this->hasOne(SJobType::class, ['id' => 'job_type_id']);
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
    public function getEconomicSector() {
        return $this->hasOne(SIsco08Level4::class, ['id' => 'economic_sector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts() {
        return $this->hasOne(SDistrict::class, ['id' => 'district_id']);
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
    public function getDeletedBy() {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
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
    public function getActions() {
        return $this->hasOne(SActions::className(), ['pk_action' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationLevel() {
        return $this->hasOne(SEducationLevel::class, ['id' => 'education_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationField() {
        return $this->hasOne(SEducationField::class, ['id' => 'education_field_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceJobQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new \common\models\query\ServiceJobQuery(get_called_class());
        return $query->where(['service_job.deleted_by' => 0]);
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
                // 'employer_logo' => [
                //     'class' => UploadBehavior::class,
                //     'attribute' => 'employer_logo',
                //     'pathAttribute' => 'employerlogo_path',
                //     // 'baseUrlAttribute' => 'employerlogo_base_url'
                // ],
        ];
    }

    public static function data() {
        return static::find()
                        ->select(['jobtitle', 'jobtitle as  label', 'jobtitle AS id'])
                        ->published()
                        ->asArray()
                        ->all();
    }

    public function getOccupationGroupings() {
        return $this->hasOne(SOccupationGrouping::class, ['id' => 'occupation_grouping_id']);
    }

    public function getCompetencyLevels() {
        return $this->hasOne(SCompetencyLevel::class, ['id' => 'competency_level_id']);
    }

    public static function posted($id) {
        return $id;
    }

    public function totalJobByDistrict($district, $opportunity = null) {
        if (isset($_GET['opportunity']))
            $opportunity = $_GET['opportunity'];
        return $this->find()->opportunity($opportunity)->andWhere(['district_id' => $district])->count();
    }

    public function totalAvailableByDistrict($district, $opportunity = null) {
        if (isset($_GET['opportunity']))
            $opportunity = $_GET['opportunity'];
        return $this->find()->opportunity($opportunity)->available()->andWhere(['district_id' => $district])->count();
    }

    public function totalArchivedByDistrict($district, $opportunity = null) {
        if (isset($_GET['opportunity']))
            $opportunity = $_GET['opportunity'];
        return $this->find()->opportunity($opportunity)->unavailable()->andWhere(['district_id' => $district])->count();
    }

    public function totalJobByEconomicSector($economic_sector_id, $opportunity = null) {
        if (isset($_GET['opportunity']))
            $opportunity = $_GET['opportunity'];
        return $this->find()->opportunity($opportunity)->andWhere(['economic_sector_id' => $economic_sector_id])->count();
    }

    public function totalAvailableByEconomicSector($economic_sector_id, $opportunity = null) {
        if (isset($_GET['opportunity']))
            $opportunity = $_GET['opportunity'];
        return $this->find()->opportunity($opportunity)->available()->andWhere(['economic_sector_id' => $economic_sector_id])->count();
    }

    public function totalArchivedByEconomicSector($economic_sector_id, $opportunity = null) {
        if (isset($_GET['opportunity']))
            $opportunity = $_GET['opportunity'];
        return $this->find()->opportunity($opportunity)->unavailable()->andWhere(['economic_sector_id' => $economic_sector_id])->count();
    }

}
