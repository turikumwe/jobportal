<?php

namespace common\models;

use Yii;
use backend\models\SActions;
use \backend\models\SGeosector;
use backend\models\SEventDuration;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class MediatorJobseekerService extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

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
        return '{{%mediator_jobseeker_service}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['service_id','mediator_id', 'service_date'], 'required'],
            [['service_id','mediator_id',], 'integer'],
            [['service_description', 'institution'], 'string'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value' => 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'service_id' => Yii::t('common', 'Service'),
            'mediator_id' => Yii::t('common', 'Mediator'),
            'service_date' => Yii::t('common', 'Service date'),
            'service_description' => Yii::t('common', 'Service description'),
            'institution' => Yii::t('common', 'Institution'),
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
    public function getMediatorServices() {
        return $this->hasMany(MdMediator::class, ['center_id' => 'id']);
    }

    public function getServicedUser() {
        //return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

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
     * {@inheritdoc}
     * @return \common\models\query\ServiceEventQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new \common\models\query\MediatorJobseekerServiceQuery(get_called_class());
        return $query->where(['mediator_jobseeker_service.deleted_by' => 0]);
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

}
