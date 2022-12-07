<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "{{%s_opportunity}}".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property string $deleted_at
 * @property int $deleted_by
 */
class SOpportunity extends \yii\db\ActiveRecord
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
        return '{{%s_opportunity}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['deleted_by'], 'default', 'value'=> 0],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Name'),
            'type' => Yii::t('backend', 'Type'),
            'created_at' => Yii::t('backend', 'Created at'),
            'created_by' => Yii::t('backend', 'Created by'),
            'updated_at' => Yii::t('backend', 'Updated at'),
            'updated_by' => Yii::t('backend', 'Updated by'),
            'deleted_at' => Yii::t('backend', 'Deleted at'),
            'deleted_by' => Yii::t('backend', 'Deleted by'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SOpportunityQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \backend\models\query\SOpportunityQuery(get_called_class());
        return $query->where(['s_opportunity.deleted_by' => 0]);
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
