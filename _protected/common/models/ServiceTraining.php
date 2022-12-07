<?php

namespace common\models;

use Yii;
use backend\models\STrainingCategory;
use backend\models\SDistrict;
use backend\models\SActions;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%service_training}}".
 *
 * @property int $id
 * @property int $training_category_id
 * @property string $training_name
 * @property string $training_details
 * @property int $training_duration
 * @property string $application_deadline
 * @property string $start_date
 * @property string $training_center
 * @property string $training_provider
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
 * @property JsTrainingsApplication[] $jsTrainingsApplications
 * @property STrainingCategory $trainingCategory
 * @property SDistrict $district
 * @property SActions $action
 * @property User $createdBy
 * @property User $updatedBy
 */
class ServiceTraining extends \yii\db\ActiveRecord
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
        return '{{%service_training}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_category_id', 'training_name', 'training_details', 'training_duration', 'application_deadline', 'start_date', 'training_center', 'training_provider'], 'required'],
            [['training_category_id', 'training_duration', 'posted', 'district_id', 'action_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['training_details'], 'string'],
            [['application_deadline', 'start_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['training_name', 'training_center'], 'string', 'max' => 100],
            [['training_provider'], 'string', 'max' => 200],
            [['deleted_by'], 'default', 'value'=> 0],
            [['training_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => STrainingCategory::className(), 'targetAttribute' => ['training_category_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SDistrict::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['action_id'], 'exist', 'skipOnError' => true, 'targetClass' => SActions::className(), 'targetAttribute' => ['action_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'training_category_id' => Yii::t('common', 'Training category'),
            'training_name' => Yii::t('common', 'Training title'),
            'training_details' => Yii::t('common', 'Training details'),
            'training_duration' => Yii::t('common', 'Training duration'),
            'application_deadline' => Yii::t('common', 'Application deadline'),
            'start_date' => Yii::t('common', 'Start date'),
            'training_center' => Yii::t('common', 'Training center'),
            'training_provider' => Yii::t('common', 'Training provider'),
            'posted' => Yii::t('common', 'Posted'),
            'district_id' => Yii::t('common', 'District'),
            'action_id' => Yii::t('common', 'Action'),
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
    public function getJsTrainingsApplications()
    {
        return $this->hasMany(JsTrainingsApplication::className(), ['training_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingCategory()
    {
        return $this->hasOne(STrainingCategory::className(), ['id' => 'training_category_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceTrainingQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\ServiceTrainingQuery(get_called_class());
        return $query->where(['service_training.deleted_by' => 0]);
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
