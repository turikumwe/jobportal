<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\SReportListQuery;

/**
 * This is the model class for table "{{%s_notifications}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $opportunity_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 *
 * @property SOpportunity $opportunity
 * @property User $user
 */
class SReportList extends \yii\db\ActiveRecord {

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
        return '{{%s_report_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['report_title', 'report_description','report_url', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'required'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['report_url', 'access_user_groups', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['deleted_by'], 'default', 'value' => 0],
            [['opportunity_id'], 'exist', 'skipOnError' => true, 'targetClass' => SOpportunity::className(), 'targetAttribute' => ['opportunity_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'report_title' => Yii::t('common', 'Title'),
            'report_description' => Yii::t('common', 'Description'),
            'report_url' => Yii::t('common', 'Url'),
            'access_user_groups' => Yii::t('common', 'Access groups'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'deleted_at' => Yii::t('common', 'Deleted At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'deleted_by' => Yii::t('common', 'Deleted By'),
        ];
    }
    public static function find() {
        $query = new SReportListQuery(get_called_class());
        return $query->where(['or', ['s_report_list.deleted_by' => null], ['s_report_list.deleted_by' => 0]]);
    }

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
