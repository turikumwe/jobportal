<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_recommendation}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $recommendation
 * @property int $who_recommended_id
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property User $user
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 * @property User $whoRecommended
 */
class JsRecommendation extends \yii\db\ActiveRecord
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
        return '{{%js_recommendation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'recommendation'], 'required'],
            [['user_id', 'who_recommended_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['recommendation'], 'string'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value'=> 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['who_recommended_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['who_recommended_id' => 'id']],
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
            'recommendation' => Yii::t('common', 'Recommendation'),
            'who_recommended_id' => Yii::t('common', 'Who recommended'),
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
    public function getDeletedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'deleted_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWhoRecommended()
    {
        return $this->hasOne(User::className(), ['id' => 'who_recommended_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\JsRecommendationQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \common\models\query\JsRecommendationQuery(get_called_class());
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
