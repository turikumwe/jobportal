<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\SMainecosector;
use backend\models\SIsicr4Level4;



/**
 * This is the model class for table "{{%empl_economic_sector}}".
 *
 * @property int $id
 * @property int $employer_id
 * @property int $economic_sector_id
 * @property int $main_economic_sector_id
 * @property string $start_date
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property SMainecosector $mainEconomicSector
 * @property EmplEmployer $employer
 * @property SIsicr4Level4 $economicSector
 */
class EmplEconomicSector extends \yii\db\ActiveRecord
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
        return '{{%empl_economic_sector}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employer_id', 'economic_sector_id', 'main_economic_sector_id', 'created_by', 'deleted_by', 'updated_by','status'], 'integer'],
            [['start_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['main_economic_sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SMainecosector::class, 'targetAttribute' => ['main_economic_sector_id' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
            [['status'], 'default', 'value'=> 1],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmplEmployer::class, 'targetAttribute' => ['employer_id' => 'id']],
            [['economic_sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsicr4Level4::class, 'targetAttribute' => ['economic_sector_id' => 'id']],
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
            'economic_sector_id' => Yii::t('common', 'Economic sector'),
            'main_economic_sector_id' => Yii::t('common', 'Main sector'),
            'start_date' => Yii::t('common', 'Start date'),
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
    public function getMainEconomicSector()
    {
        return $this->hasOne(SMainecosector::class, ['id' => 'main_economic_sector_id']);
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
    public function getEconomicSector()
    {
        return $this->hasOne(SIsicr4Level4::class, ['id' => 'economic_sector_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EmplEconomicSectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\EmplEconomicSectorQuery(get_called_class());
        return $query->where(['empl_economic_sector.deleted_by' => 0]);
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
