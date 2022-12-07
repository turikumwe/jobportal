<?php

namespace backend\models;

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
class SSkill extends \yii\db\ActiveRecord {

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
        return '{{%s_skill}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['skill'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by', 'status'], 'integer'],
            [['skill'], 'string', 'max' => 255],
            [['deleted_by'], 'default', 'value' => 0],
            [['skill'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'skill' => Yii::t('backend', 'Skill'),
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
        return $query->where(['s_skill.deleted_by' => 0]);
    }

    public function findByName($name) {

        $row = SSkill::find()->where(['s_skill.deleted_by' => 0])->andWhere(['upper(skill)' => strtoupper($name)])->one();

        if (isset($row->skill) && !empty($row->skill)) {
            if (strtolower(str_replace(' ', '', $row->skill)) == strtolower(str_replace(' ', '', $name))) {
                return $row->id;
            }
        }

        $this->skill = $name;
        $this->status = 0;
        $this->deleted_by = 0;
        $this->save(false);

        return $this->id;
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
