<?php

namespace common\models;

use Yii;
use backend\models\SActions;
use \backend\models\SGeosector;
use backend\models\SEventDuration;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\data\ActiveDataProvider;

class PrivateMediatorReport extends \yii\db\ActiveRecord {

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
        return '{{%private_mediator_report}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['service_id', 'quarter_id', 'mediator_id', 'female_count', 'male_count', 'disabled_count'], 'required'],
            [['service_id', 'mediator_id', 'female_count', 'male_count', 'disabled_count'], 'integer'],
            [['additional_comment'], 'string'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            'service_id' => Yii::t('common', 'Service'),
            'mediator_id' => Yii::t('common', 'Mediator'),
            'female_count' => Yii::t('common', 'Total female'),
            'male_count' => Yii::t('common', 'Total male'),
            'quarter_id' => Yii::t('common', 'Report quarter'),
            'disabled_count' => Yii::t('common', 'Total disabled'),
            'additional_comment' => Yii::t('common', 'Additional comment'),
            'created_by' => Yii::t('common', 'Created by'),
            'created_at' => Yii::t('common', 'Created at'),
            'deleted_by' => Yii::t('common', 'Deleted by'),
            'deleted_at' => Yii::t('common', 'Deleted at'),
            'updated_by' => Yii::t('common', 'Updated by'),
            'updated_at' => Yii::t('common', 'Updated at'),
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {

        $query = PrivateMediatorReport::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediatorServices() {
        return $this->hasMany(MdMediator::class, ['mediator_id' => 'id']);
    }

    public function getDeletedBy() {
        return $this->hasOne(User::className(), ['id' => 'deleted_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceEventQuery the active query used by this AR class.
     */
    public static function find() {
        $query = new \common\models\query\PrivateMediatorReportQuery(get_called_class());
        return $query->where(['private_mediator_report.deleted_by' => 0]);
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
