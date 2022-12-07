<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\SSkill;

/**
 * This is the model class for table "{{%js_skill}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $skill_id
 * @property int $skill_level_id
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
  * @property string $name
 *
 * @property SSkillLevel $skillLevel
 * @property SSkill $skill
 * @property User $user
 * @property User $createdBy
 * @property User $updatedBy
 */
class JsSkill extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;
    public $skill_name;

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
        return '{{%js_skill}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'skill_level_id'], 'required'],
            [['user_id', 'skill_id', 'skill_level_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['skill_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SSkillLevel::class, 'targetAttribute' => ['skill_level_id' => 'id']],
            [['skill_name'], 'string', 'max' => 50],
            [['skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\SSkill::class, 'targetAttribute' => ['skill_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
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
            'skill_id' => Yii::t('common', 'Skill'),
            'skill_name' => Yii::t('common', 'Skill'),
            'skill_level_id' => Yii::t('common', 'Skill level'),
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
    public function getSkillLevel()
    {
        return $this->hasOne(\backend\models\SSkillLevel::class, ['id' => 'skill_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(\backend\models\SSkill::class, ['id' => 'skill_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public static function skills($user_id)
    { 
        return SSkill::find()->where(['IN','id',JsSkill::find()->select('skill_id')->distinct()->where('user_id=:u',['u'=>$user_id])])->all();        
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\JsSkillQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsSkillQuery(get_called_class());
        return $query->where(['deleted_by' => 0]);
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
