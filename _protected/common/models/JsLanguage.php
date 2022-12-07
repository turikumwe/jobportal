<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_language}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $language
 * @property int $reading
 * @property int $writing
 * @property int $listening
 * @property int $speaking
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $user
 * @property SLanguage $language0
 * @property SLanguageRating $reading0
 * @property SLanguageRating $writing0
 * @property SLanguageRating $listening0
 * @property SLanguageRating $speaking0
 * @property User $createdBy
 * @property User $updatedBy
 */
class JsLanguage extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public $certificateFile;

    public function __construct()
    {
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
        return '{{%js_language}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'language', 'reading', 'writing', 'listening', 'speaking'], 'required'],
            [['user_id', 'language', 'reading', 'writing', 'listening', 'speaking', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['deleted_by'], 'default', 'value'=> 0],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SLanguage::class, 'targetAttribute' => ['language' => 'id']],
            [['reading'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SLanguageRating::class, 'targetAttribute' => ['reading' => 'id']],
            [['writing'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SLanguageRating::class, 'targetAttribute' => ['writing' => 'id']],
            [['listening'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SLanguageRating::class, 'targetAttribute' => ['listening' => 'id']],
            [['speaking'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SLanguageRating::class, 'targetAttribute' => ['speaking' => 'id']],
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
            'user_id' => Yii::t('common', 'Job seeker'),
            'language' => Yii::t('common', 'Language'),
            'reading' => Yii::t('common', 'Reading'),
            'writing' => Yii::t('common', 'Writing'),
            'listening' => Yii::t('common', 'Listening'),
            'speaking' => Yii::t('common', 'Speaking'),
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
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage0()
    {
        return $this->hasOne(\backend\models\SLanguage::class, ['id' => 'language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReading0()
    {
        return $this->hasOne(\backend\models\SLanguageRating::class, ['id' => 'reading']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWriting0()
    {
        return $this->hasOne(\backend\models\SLanguageRating::class, ['id' => 'writing']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListening0()
    {
        return $this->hasOne(\backend\models\SLanguageRating::class, ['id' => 'listening']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeaking0()
    {
        return $this->hasOne(\backend\models\SLanguageRating::class, ['id' => 'speaking']);
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
     * @return \common\models\query\JsLanguageQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsLanguageQuery(get_called_class());
        return $query->where(['js_language.deleted_by' => 0]);
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
