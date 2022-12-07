<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%js_message}}".
 *
 * @property int $id
 * @property string $subject
 * @property string $body
 * @property int $js_to
 * @property int $type :recommandation 2:normal message
 * @property int $status
 * @property int $created_by
 * @property string $created_at
 * @property int $updated_by
 * @property string $updated_at
 * @property int $deleted_by
 * @property string $deleted_at
 */
class JsMessage extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public $js_to_email;

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
        return '{{%js_message}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'body','js_to_email'], 'required'],
            [['body'], 'string'],
            [['js_to_email'], 'email'],
            [['deleted_by','status'], 'default', 'value'=> 0],
            [['js_to', 'type', 'status', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('common', 'ID'),
            'subject'    => Yii::t('common', 'Subject'),
            'body'       => Yii::t('common', 'Body'),
            'js_to'      => Yii::t('common', 'Js To'),
            'js_to_email'=> Yii::t('common', 'To'),
            'type'       => Yii::t('common', 'Type'),
            'status'     => Yii::t('common', 'Status'),
            'created_by' => Yii::t('common', 'Created By'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'deleted_by' => Yii::t('common', 'Deleted By'),
            'deleted_at' => Yii::t('common', 'Deleted At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser_from()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser_to()
    {
        return $this->hasOne(User::class, ['id' => 'js_to']);
    }

    /**
     * {@inheritdoc}
     * @return JsMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new JsMessageQuery(get_called_class());
        return $query->where(['js_message.deleted_by' => 0]);
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

