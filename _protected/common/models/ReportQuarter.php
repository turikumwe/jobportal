<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class ReportQuarter extends \yii\db\ActiveRecord {

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
        return '{{%report_quarter}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['created_at', 'deleted_at', 'updated_at', 'from_date','to_date','quarter_name','quarter_year'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value' => 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'created_by' => Yii::t('common', 'Created by'),
            'created_at' => Yii::t('common', 'Created at'),
            'deleted_by' => Yii::t('common', 'Deleted by'),
            'deleted_at' => Yii::t('common', 'Deleted at'),
            'updated_by' => Yii::t('common', 'Updated by'),
            'updated_at' => Yii::t('common', 'Updated at'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceEventQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new \common\models\query\ReportQuarterQuery(get_called_class());
        return $query->where(['report_quarter.deleted_by' => null]);
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
