<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MediatorJobseekerService;

/**
 * ServiceJobSearch represents the model behind the search form about `common\models\ServiceJob`.
 */
class MediatorJobseekerServiceSearch extends MediatorJobseekerService {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['service_id', 'mediator_id', 'service_date'], 'required'],
            [['service_id', 'mediator_id',], 'integer'],
            [['service_description', 'institution'], 'string'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'default', 'value' => 0],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function getDateRangeOptions() {
        return [
            '0' => \Yii::t('frontend', 'Anytime'),
            '1' => \Yii::t('frontend', 'Today'),
            '2' => \Yii::t('frontend', 'Last 7 days'),
            '3' => \Yii::t('frontend', 'Last 14 days'),
            '4' => \Yii::t('frontend', 'Last 30 days'),
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

        $query = MediatorJobseekerService::find();

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

}
