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
 * @property int $employer_id
 * @property int $employer_status_id
 * @property string $status_effective_date
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
class EmplStatus extends \yii\db\ActiveRecord
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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%empl_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employer_id', 'employer_status_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['status_effective_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmplEmployer::class, 'targetAttribute' => ['employer_id' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['employer_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => SEmployerStatus::class, 'targetAttribute' => ['employer_status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'employer_id' => Yii::t('common', 'Employer'),
            'employer_status_id' => Yii::t('common', 'Employer status'),
            'status_effective_date' => Yii::t('common', 'Status effective date'),
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
    public function getEmployer()
    {
        return $this->hasOne(EmplEmployer::class, ['id' => 'employer_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerStatus()
    {
        return $this->hasOne(SEmployerStatus::class, ['id' => 'employer_status_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EmplStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\EmplStatusQuery(get_called_class());
        return $query->where(['empl_status.deleted_by' => 0]);
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
