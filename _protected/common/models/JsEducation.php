<?php

namespace common\models;

use Yii;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%js_education}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $school
 * @property int $country_id
 * @property int $education_level_id
 * @property int $education_field_id
 * @property string $exact_quali
 * @property string $graduation_date
 * @property string $start_date
 * @property string $end_date
 * @property int $grade_id
 * @property int $certificate_id
 * @property string $certificate_path
 * @property string $certificate_base_url
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $user
 * @property User $createdBy
 * @property User $updatedBy
 * @property SEducationLevel $educationLevel
 * @property SEducationField $educationField
 * @property SGrade $grade
 * @property SCertificate $certificate
 * @property SCountrycodeIso3166 $country
 */
class JsEducation extends \yii\db\ActiveRecord
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
        return '{{%js_education}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    { 
        return [
            [['user_id', 'education_level_id','education_field_id'], 'required'],
            [['user_id', 'country_id', 'education_level_id', 'education_field_id', 'grade_id', 'certificate_id', 'created_by', 'deleted_by', 'updated_by','graduation_date','status'], 'integer'],
            [['start_date','end_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['school'], 'string', 'max' => 100],
            [['deleted_by'], 'default', 'value'=> 0],
            [['status'], 'default', 'value'=> 1],
            [['exact_quali'], 'string', 'max' => 200],
            [['certificateFile'], 'file', 'extensions' => 'pdf', 'maxSize' => 2 * 1024 * 1024, 'mimeTypes' => ['application/pdf']],
            // [
            //     'graduation_date','required', 'when' => function ($model) {
            //         return  $model->graduation_date == 0;
            //     },'whenClient' => "function (attribute, value) {
            //         return $('#graduation_date').val() == 0;
            //     }"
            // ],

            [['certificate_path', 'certificate_base_url'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
            [['education_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SEducationLevel::class, 'targetAttribute' => ['education_level_id' => 'id']],
            [['education_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SEducationField::class, 'targetAttribute' => ['education_field_id' => 'id']],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SGrade::class, 'targetAttribute' => ['grade_id' => 'id']],
            [['certificate_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SCertificate::class, 'targetAttribute' => ['certificate_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SCountrycodeIso3166::class, 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'user_id' => Yii::t('frontend', 'Job seeker'),
            'school' => Yii::t('frontend', 'Exact school Name'),
            'country_id' => Yii::t('frontend', 'Country'),            
            'certificateFile' => Yii::t('frontend', 'Attach certificate'),
            'education_level_id' => Yii::t('frontend', 'Education level'),
            'education_field_id' => Yii::t('frontend', 'Education field'),
            'exact_quali' => Yii::t('frontend', 'Exact qualification on certificate'),
            'graduation_date' => Yii::t('frontend', 'Graduation date'),
            'start_date' => Yii::t('frontend', 'Start date'),
            'end_date' => Yii::t('frontend', 'End date'),
            'grade_id' => Yii::t('frontend', 'Grade'),
            'certificate_id' => Yii::t('frontend', 'Certificate'),
            'certificate_path' => Yii::t('frontend', 'Certificate Path'),
            'certificate_base_url' => Yii::t('frontend', 'Certificate Base Url'),
            'created_by' => Yii::t('frontend', 'Created by'),
            'created_at' => Yii::t('frontend', 'Created at'),
            'deleted_by' => Yii::t('frontend', 'Deleted by'),
            'deleted_at' => Yii::t('frontend', 'Deleted at'),
            'updated_by' => Yii::t('frontend', 'Updated by'),
            'updated_at' => Yii::t('frontend', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function years(){
        $years = [];       
        $start_year = (int)date('Y') - 50; 
        $lastYear = (int)date('Y');
        $years[0] = Yii::t("frontend","Select Graduation Year");
        for($year = $start_year; $year <= $lastYear; $year++){
            $years[$year] = $year;
        }

        return $years;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationLevel()
    {
        return $this->hasOne(\backend\models\SEducationLevel::class, ['id' => 'education_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationField()
    {
        return $this->hasOne(\backend\models\SEducationField::class, ['id' => 'education_field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrade()
    {
        return $this->hasOne(\backend\models\SGrade::class, ['id' => 'grade_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificate()
    {
        return $this->hasOne(\backend\models\SCertificate::class, ['id' => 'certificate_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(\backend\models\SCountrycodeIso3166::class, ['id' => 'country_id']);
    }

    /**
     * {@inheritdoc}
     * @return JsEducationQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsEducationQuery(get_called_class());
        return $query->where(['js_education.deleted_by' => 0]);
    }

     /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        if(!Yii::$app->user->isGuest){
            return [
                // 'certificateFile' => [
                //     'class' => UploadBehavior::class,
                //     'attribute' => 'certificateFile',
                //     'pathAttribute' => 'certificate_path',
                //     'baseUrlAttribute' => 'certificate_base_url'
                // ],

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
        }else{
             return [
                // 'certificateFile' => [
                //     'class' => UploadBehavior::class,
                //     'attribute' => 'certificateFile',
                //     'pathAttribute' => 'certificate_path',
                //     // 'baseUrlAttribute' => 'certificate_base_url',
                // ],

                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'value' => new \yii\db\Expression('NOW()'),
                ],
            ];  
        }
    }
    public function totalJobseekersByEducationfield($educationField){
        return $this->find()
        ->Where(['education_field_id' => $educationField])
        ->AndWhere(['deleted_by' => 0])
        ->count();
    }

    public function totalWithPhd($educationField, $educationQualification=null){
        if(isset($_GET['educationQualification'])) $educationQualification = $_GET['educationQualification'];
        return $this->find()->educationPHD($educationQualification)->andWhere(['education_field_id' => $educationField])->AndWhere(['deleted_by' => 0])->count();
    }
    public function totalWithMasters($educationField, $educationQualification=null){
        if(isset($_GET['educationQualification'])) $educationQualification = $_GET['educationQualification'];
        return $this->find()->educationMasters($educationQualification)->andWhere(['education_field_id' => $educationField])->AndWhere(['deleted_by' => 0])->count();
    }
    public function totalWithBachelor($educationField, $educationQualification=null){
        if(isset($_GET['educationQualification'])) $educationQualification = $_GET['educationQualification'];
        return $this->find()->educationBachelor($educationQualification)->andWhere(['education_field_id' => $educationField])->AndWhere(['deleted_by' => 0])->count();
    }
    public function totalWithDiploma($educationField, $educationQualification=null){
        if(isset($_GET['educationQualification'])) $educationQualification = $_GET['educationQualification'];
        return $this->find()->educationDiploma($educationQualification)->andWhere(['education_field_id' => $educationField])->AndWhere(['deleted_by' => 0])->count();
    }
    public function totalWithALevel($educationField, $educationQualification=null){
        if(isset($_GET['educationQualification'])) $educationQualification = $_GET['educationQualification'];
        return $this->find()->educationALevel($educationQualification)->andWhere(['education_field_id' => $educationField])->AndWhere(['deleted_by' => 0])->count();
    }
    public function totalWith0Level($educationField, $educationQualification=null){
        if(isset($_GET['educationQualification'])) $educationQualification = $_GET['educationQualification'];
        return $this->find()->educationOLevel($educationQualification)->andWhere(['education_field_id' => $educationField])->AndWhere(['deleted_by' => 0])->count();
    }
    public function totalWith6Years($educationField, $educationQualification=null){
        if(isset($_GET['educationQualification'])) $educationQualification = $_GET['educationQualification'];
        return $this->find()->education6Years($educationQualification)->andWhere(['education_field_id' => $educationField])->AndWhere(['deleted_by' => 0])->count();
    }
    public function totalWithUknown($educationField, $educationQualification=null){
        if(isset($_GET['educationQualification'])) $educationQualification = $_GET['educationQualification'];
        return $this->find()->educationUknown($educationQualification)->andWhere(['education_field_id' => $educationField])->AndWhere(['deleted_by' => 0])->count();
    }
}
