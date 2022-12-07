<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%md_managers}}".
 *
 * @property int $id
 * @property int $mediator_id
 * @property int $person_id
 * @property string $start_date
 * @property string $end_date
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property MdMediator $mediator
 * @property CommonPerson $person
 * @property User $createdBy
 * @property User $updatedBy
 */
class MdManagers extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    public $picture;
    private $_rt_softdelete;
    private $_rt_softrestore;
    public $global_search;

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
        return '{{%md_managers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mediator_id', 'person_id','position'], 'required'],
            [['mediator_id', 'person_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['deleted_by'], 'default', 'value'=> 0],
            [['position'], 'string', 'max' => 100],
            [['mediator_id'], 'exist', 'skipOnError' => true, 'targetClass' => MdMediator::class, 'targetAttribute' => ['mediator_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => CommonPerson::class, 'targetAttribute' => ['person_id' => 'id']],
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
            'id' => Yii::t('common', 'ID'),
            'mediator_id' => Yii::t('common', 'Mediator'),
            'person_id' => Yii::t('common', 'Contact person'),
            'position' => Yii::t('common', 'Position'),
            'start_date' => Yii::t('common', 'Start date'),
            'end_date' => Yii::t('common', 'End date'),
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
    public function getMediator()
    {
        return $this->hasOne(MdMediator::class, ['id' => 'mediator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(CommonPerson::class, ['id' => 'person_id']);
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
     * {@inheritdoc}
     * @return \common\models\query\MdManagersQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\MdManagersQuery(get_called_class());
        return $query->where(['md_managers.deleted_by' => 0]);
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
