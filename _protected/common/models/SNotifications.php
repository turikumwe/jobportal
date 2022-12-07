<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\SNotificationsQuery;

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
class SNotifications extends \yii\db\ActiveRecord {

    const MAIL_SENT = 1;
    const NOTIFICATION_TYPE_STATUS_CHANGE = 1;
    const NOTIFICATION_TYPE_APPLIED_JOB_UPDATED = 3;
    const NOTIFICATION_TYPE_MATCHING_SKILLS_JOB_POSTED = 2;
    const NOTIFICATION_TYPE_CUSTOM_USER_MESSAGE = 7;

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
        return '{{%s_notifications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'message_body', 'message_title'], 'required'],
            [['user_id', 'opportunity_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['message_body', 'message_title', 'mail_sent', 'is_opened', 'notification_type', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['deleted_by'], 'default', 'value' => 0],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'opportunity_id' => Yii::t('common', 'Opportunity ID'),
            'message_title' => Yii::t('common', 'Message title'),
            'message_body' => Yii::t('common', 'Message body'),
            'is_opened' => Yii::t('common', 'Is opned'),
            'notification_type' => Yii::t('common', 'Notification type'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'deleted_at' => Yii::t('common', 'Deleted At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'deleted_by' => Yii::t('common', 'Deleted By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpportunity() {
        return $this->hasOne(SOpportunity::className(), ['id' => 'opportunity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return SNotificationsQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new SNotificationsQuery(get_called_class());
        return $query->where(['or', ['s_notifications.deleted_by' => null], ['s_notifications.deleted_by' => 0]]);
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

    public static function check($opportunity_id) {
        $notification = SNotifications::find()
                ->where(['opportunity_id' => $opportunity_id])
                ->andWhere(['user_id' => Yii::$app->user->id]);

        if ($notification->count() == 0) {
            return 3;
        }

        return $notification->one();
    }

}
