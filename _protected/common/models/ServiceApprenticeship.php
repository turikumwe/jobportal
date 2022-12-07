<?php

namespace common\models;

use Yii;
use backend\models\STrainingCategory;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\SDistrict;
use backend\models\SActions;

/**
 * This is the model class for table "{{%service_apprenticeship}}".
 *
 * @property int $id
 * @property int $apprenticeship_category_id
 * @property string $apprenticeship_name
 * @property string $apprenticeship_details
 * @property int $apprenticeship_duration
 * @property string $application_deadline
 * @property string $start_date
 * @property string $apprenticeship_center
 * @property string $apprenticeship_provider
 * @property int $posted
 * @property int $district_id
 * @property int $action_id
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property JsApprenticeshipApplication[] $jsApprenticeshipApplications
 * @property STrainingCategory $apprenticeshipCategory
 * @property SDistrict $district
 * @property SActions $action
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 */
class ServiceApprenticeship extends \yii\db\ActiveRecord
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
        return '{{%service_apprenticeship}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apprenticeship_category_id', 'apprenticeship_name', 'apprenticeship_details', 'apprenticeship_duration', 'application_deadline', 'start_date', 'apprenticeship_center', 'apprenticeship_provider', 'district_id'], 'required'],
            [['apprenticeship_category_id', 'apprenticeship_duration', 'posted', 'district_id', 'action_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['apprenticeship_details'], 'string'],
            [['application_deadline', 'start_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['apprenticeship_name', 'apprenticeship_center'], 'string', 'max' => 100],
            [['apprenticeship_provider'], 'string', 'max' => 200],
            [['apprenticeship_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => STrainingCategory::className(), 'targetAttribute' => ['apprenticeship_category_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SDistrict::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['action_id'], 'exist', 'skipOnError' => true, 'targetClass' => SActions::className(), 'targetAttribute' => ['action_id' => 'id']],
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
            'apprenticeship_category_id' => Yii::t('common', 'Apprenticeship category'),
            'apprenticeship_name' => Yii::t('common', 'Apprenticeship title'),
            'apprenticeship_details' => Yii::t('common', 'Apprenticeship details'),
            'apprenticeship_duration' => Yii::t('common', 'Apprenticeship duration'),
            'application_deadline' => Yii::t('common', 'Application deadline'),
            'start_date' => Yii::t('common', 'Start date'),
            'apprenticeship_center' => Yii::t('common', 'Apprenticeship center'),
            'apprenticeship_provider' => Yii::t('common', 'Apprenticeship provider'),
            'posted' => Yii::t('common', 'Posted by'),
            'district_id' => Yii::t('common', 'District'),
            'action_id' => Yii::t('common', 'Action taken'),
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
    public function getJsApprenticeshipApplications()
    {
        return $this->hasMany(JsApprenticeshipApplication::className(), ['apprenticeship_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApprenticeshipCategory()
    {
        return $this->hasOne(STrainingCategory::className(), ['id' => 'apprenticeship_category_id']);
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
    public function getAction()
    {
        return $this->hasOne(SActions::className(), ['id' => 'action_id']);
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
     * @return \common\models\query\ServiceApprenticeshipQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\ServiceApprenticeshipQuery(get_called_class());
        return $query->where(['service_apprenticeship.deleted_by' => 0]);
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
