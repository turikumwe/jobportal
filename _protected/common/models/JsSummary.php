<?php

namespace common\models;

use Yii;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_summary}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $professional_profile
 * @property string $specialty
 * @property string $cv_path
 * @property string $cover_letter
 * @property string $cv_base_url
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 */
class JsSummary extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public $cvFile;

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
        return '{{%js_summary}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['professional_profile'], 'required'],
            [['user_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['professional_profile', 'specialty','cover_letter'], 'string'],
            [['cv_path', 'cv_base_url'], 'string', 'max' => 255],
            [['cover_letter'], 'string', 'max' => 3700],
            [['deleted_by'], 'default', 'value'=> 0],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['cvFile'], 'file', 'extensions' => 'pdf', 'maxSize' => 2 * 1024 * 1024, 'mimeTypes' => ['application/pdf']],
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
            'professional_profile' => Yii::t('common', 'Professional profile'),
            'specialty' => Yii::t('common', 'Specialty'),
            'cover_letter' => Yii::t('common', 'Cover Letter'),
            'cvFile' => Yii::t('common', 'Attach your CV'),
            'cv_path' => Yii::t('common', 'CV path'),
            'cv_base_url' => Yii::t('common', 'CV base url'),
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'deleted_by']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return JsSummaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsSummaryQuery(get_called_class());
         return $query->where(['deleted_by' => 0]);
    }

     /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            // 'cvFile' => [
            //     'class' => UploadBehavior::class,
            //     'attribute' => 'cvFile',
            //     'pathAttribute' => 'cv_path',
            //     // 'baseUrlAttribute' => 'cv_base_url'
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
