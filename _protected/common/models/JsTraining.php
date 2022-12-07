<?php

namespace common\models;

use Yii;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_training}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $training_center
 * @property string $training_title
 * @property string $start_date
 * @property string $end_date
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
 */
class JsTraining extends \yii\db\ActiveRecord
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
        return '{{%js_training}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['training_center', 'training_title'], 'string', 'max' => 100],
            [['certificate_path', 'certificate_base_url'], 'string', 'max' => 255],
            [['deleted_by'], 'default', 'value'=> 0],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['certificateFile'], 'file', 'extensions' => 'pdf', 'maxSize' => 2 * 1024 * 1024, 'mimeTypes' => ['application/pdf'], 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'Job seeker'),
            'training_center' => Yii::t('common', 'Training center'),
            'training_title' => Yii::t('common', 'Training title'),
            'start_date' => Yii::t('common', 'Start date'),
            'end_date' => Yii::t('common', 'End date'),
            'certificateFile' => Yii::t('common', 'Attach certificate'),
            'certificate_path' => Yii::t('common', 'Certificate path'),
            'certificate_base_url' => Yii::t('common', 'Certificate base url'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
     * @return \common\models\query\JsTrainingQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsTrainingQuery(get_called_class());
        return $query->where(['js_training.deleted_by' => 0]);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            // 'certificateFile' => [
            //     'class' => UploadBehavior::class,
            //     'attribute' => 'certificateFile',
            //     'pathAttribute' => 'certificate_path',
            //     // 'baseUrlAttribute' => 'certificate_base_url'
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
    }
}
