<?php

namespace backend\models;

use Yii;
use common\models\MdMediator;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%s_district_mediatorr}}".
 *
 * @property int $id
 * @property int $district_id
 * @property int $mediator_id
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property MdMediator $mediator
 * @property SDistrict $district
 * @property User $createdBy
 * @property User $updatedBy
 */
class SDistrictMediatorr extends \yii\db\ActiveRecord
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
        return '{{%s_district_mediatorr}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district_id', 'mediator_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['deleted_by'], 'default', 'value'=> 0],
            [['mediator_id'], 'exist', 'skipOnError' => true, 'targetClass' => MdMediator::className(), 'targetAttribute' => ['mediator_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SDistrict::className(), 'targetAttribute' => ['district_id' => 'id']],
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
            'id' => Yii::t('backend', 'ID'),
            'district_id' => Yii::t('backend', 'District'),
            'mediator_id' => Yii::t('backend', 'Mediator'),
            'created_by' => Yii::t('backend', 'Created by'),
            'created_at' => Yii::t('backend', 'Created at'),
            'deleted_by' => Yii::t('backend', 'Deleted by'),
            'deleted_at' => Yii::t('backend', 'Deleted at'),
            'updated_by' => Yii::t('backend', 'Updated by'),
            'updated_at' => Yii::t('backend', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediator()
    {
        return $this->hasOne(MdMediator::className(), ['id' => 'mediator_id']);
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
     * @return \backend\models\query\SDistrictMediatorrQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \backend\models\query\SDistrictMediatorrQuery(get_called_class());
        return $query->where(['s_district_mediatorr.deleted_by' => 0]);
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
