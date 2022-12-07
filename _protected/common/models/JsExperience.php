<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_experience}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $company
 * @property int $occupation_id
 * @property string $exact_position
 * @property int $experience_in_this_occupation
 * @property string $start_date
 * @property string $end_date
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property EmplEmployer $company
 * @property SIsco08Level4 $occupation
 * @property User $user
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 */
class JsExperience extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

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
    public $iscolevel1_id;
    public $iscolevel2_id;
    public $iscolevel3_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%js_experience}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'occupation_id', 'experience_in_this_occupation', 'created_by','status', 'deleted_by', 'updated_by'], 'integer'],
            [['iscolevel1_id','iscolevel2_id','iscolevel3_id','exact_position'], 'required'],
            [['start_date', 'end_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['exact_position'], 'string', 'max' => 225],
            [['company'], 'string', 'max' => 100],            
            [['deleted_by'], 'default', 'value'=> 0],
            [['status'], 'default', 'value'=> 1],
            [['occupation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SIsco08Level4::class, 'targetAttribute' => ['occupation_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
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
            'company' => Yii::t('frontend', 'Employer'),
            'occupation_id' => Yii::t('frontend', 'Occupation level 4'),
            'exact_position' => Yii::t('frontend', 'Exact position'),
            'experience_in_this_occupation' => Yii::t('frontend', 'Experience in this occupation'),
            'start_date' => Yii::t('frontend', 'Start date'),
            'end_date' => Yii::t('frontend', 'End date'),
            'created_by' => Yii::t('frontend', 'Created By'),
            'created_at' => Yii::t('frontend', 'Created At'),
            'deleted_by' => Yii::t('frontend', 'Deleted By'),
            'deleted_at' => Yii::t('frontend', 'Deleted At'),
            'updated_by' => Yii::t('frontend', 'Updated By'),
            'updated_at' => Yii::t('frontend', 'Updated At'),
            'iscolevel1_id' => Yii::t('frontend', 'Occupation level1'),
            'iscolevel2_id' => Yii::t('frontend', 'Occupation level2'),
            'iscolevel3_id' => Yii::t('frontend', 'Occupation level3'),
        ];
    }   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccupation()
    {
        return $this->hasOne(\backend\models\SIsco08Level4::class, ['id' => 'occupation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExperienceInterval()
    {
        return $this->hasOne(\common\models\SExperienceInterval::class, ['id' => 'experience_in_this_occupation']);
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
     * {@inheritdoc}
     * @return \common\models\query\JsExperienceQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsExperienceQuery(get_called_class());
        return $query->where(['js_experience.deleted_by' => 0]);
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
