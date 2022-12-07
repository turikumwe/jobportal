<?php

namespace common\models;

use Yii;
use backend\models\SIsicr4Level4;
use backend\models\SEducationLevel;
use backend\models\SEducationField;
use backend\models\SActions;
use backend\models\SDistrict;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%service_internship}}".
 *
 * @property int $id
 * @property string $employer
 * @property string $employer_description
 * @property string $internship_name
 * @property string $internship_description
 * @property int $positions_number
 * @property string $intern_duties
 * @property string $intern_responsability Responsibilities are jobs, contents are for trainings or events
 * @property string $intern_skill_requirement Required key skills, knowledge and personal strengths
 * @property int $economic_sector_id
 * @property int $education_level_id
 * @property int $education_field_id
 * @property string $publication_date
 * @property string $closure_date
 * @property string $how_to_apply
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $any_further_information encouragement of female job seekers or people with disability
 * @property int $action_id published/unpublished
 * @property int $district_id Duty station
 * @property int $posted 0:mediator; 1:employer
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property SIsicr4Level4 $economicSector
 * @property SEducationLevel $educationLevel
 * @property SEducationField $educationField
 * @property SActions $action
 * @property SDistrict $district
 * @property User $createdBy
 * @property User $updatedBy
 */
class ServiceInternship extends \yii\db\ActiveRecord
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
        return '{{%service_internship}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employer', 'internship_name', 'positions_number'], 'required'],
            [['employer_description', 'internship_description', 'intern_duties', 'intern_responsability', 'intern_skill_requirement', 'how_to_apply', 'any_further_information'], 'string'],
            [['positions_number', 'economic_sector_id', 'education_level_id', 'education_field_id', 'action_id', 'district_id', 'posted', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['publication_date', 'closure_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['employer'], 'string', 'max' => 100],
            [['internship_name'], 'string', 'max' => 255],
            [['contact_phone'], 'string', 'max' => 15],
            [['contact_email'], 'string', 'max' => 50],
            [['economic_sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsicr4Level4::className(), 'targetAttribute' => ['economic_sector_id' => 'id']],
            [['education_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => SEducationLevel::className(), 'targetAttribute' => ['education_level_id' => 'id']],
            [['education_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => SEducationField::className(), 'targetAttribute' => ['education_field_id' => 'id']],
            [['action_id'], 'exist', 'skipOnError' => true, 'targetClass' => SActions::className(), 'targetAttribute' => ['action_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SDistrict::className(), 'targetAttribute' => ['district_id' => 'id']],
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
            'employer' => Yii::t('common', 'Employer'),
            'employer_description' => Yii::t('common', 'Employer description'),
            'internship_name' => Yii::t('common', 'Internship name'),
            'internship_description' => Yii::t('common', 'Internship description'),
            'positions_number' => Yii::t('common', 'Positions number'),
            'intern_duties' => Yii::t('common', 'Intern duties'),
            'intern_responsability' => Yii::t('common', 'Intern responsability'),
            'intern_skill_requirement' => Yii::t('common', 'Intern skill requirement'),
            'economic_sector_id' => Yii::t('common', 'Economic sector'),
            'education_level_id' => Yii::t('common', 'Education level'),
            'education_field_id' => Yii::t('common', 'Education field'),
            'publication_date' => Yii::t('common', 'Publication date'),
            'closure_date' => Yii::t('common', 'Closure date'),
            'how_to_apply' => Yii::t('common', 'How to apply'),
            'contact_phone' => Yii::t('common', 'Contact phone'),
            'contact_email' => Yii::t('common', 'Contact email'),
            'any_further_information' => Yii::t('common', 'Any further information'),
            'action_id' => Yii::t('common', 'Action taken'),
            'district_id' => Yii::t('common', 'District'),
            'posted' => Yii::t('common', 'Posted by'),
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
    public function getEconomicSector()
    {
        return $this->hasOne(SIsicr4Level4::className(), ['id' => 'economic_sector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationLevel()
    {
        return $this->hasOne(SEducationLevel::className(), ['id' => 'education_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationField()
    {
        return $this->hasOne(SEducationField::className(), ['id' => 'education_field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(SActions::className(), ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(SDistrict::className(), ['id' => 'district_id']);
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
     * @return \common\models\query\ServiceInternshipQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\ServiceInternshipQuery(get_called_class());
        return $query->where(['service_internship.deleted_by' => 0]);
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
