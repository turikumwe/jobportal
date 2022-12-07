<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%s_skill}}".
 *
 * @property int $id
 * @property string $skill
 * @property int $status
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property string $deleted_at
 * @property int $deleted_by
 */
class JsSavedEvent extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

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
        return '{{%js_saved_event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['event_id', 'user_id'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['deleted_by'], 'default', 'value' => 0]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'user_id' => Yii::t('backend', 'Use'),
            'event_id' => Yii::t('backend', 'Event'),
            'created_at' => Yii::t('backend', 'Created At'),
            'created_by' => Yii::t('backend', 'Created By'),
            'updated_at' => Yii::t('backend', 'Updated At'),
            'updated_by' => Yii::t('backend', 'Updated By'),
            'deleted_at' => Yii::t('backend', 'Deleted At'),
            'deleted_by' => Yii::t('backend', 'Deleted By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\common\models\User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy() {
        return $this->hasOne(\common\models\User::class, ['id' => 'deleted_by']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SSkillQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new \backend\models\query\SSkillQuery(get_called_class());
        return $query->where(['js_saved_event.deleted_by' => 0]);
    }

    public function findByUserId($user_id) {

        $skills = JobSkills::find()->where(['js_saved_event.deleted_by' => 0])->andWhere(['user_id' => $user_id])->asArray()->all();

        return $skills;
    }

    public static function isSaved($event_id, $user_id) {

        $events = JsSavedEvent::find()->where(['or',['js_saved_event.deleted_by' => null],['js_saved_event.deleted_by' => 0]])->andWhere(['event_id' => $event_id, 'user_id' => $user_id])->asArray()->all();

        if (count($events) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
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
