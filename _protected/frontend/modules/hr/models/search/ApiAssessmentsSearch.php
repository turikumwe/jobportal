<?php

namespace frontend\modules\hr\models\search;

use frontend\modules\hr\models\ApiAssessments;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ApiAssessmentsSearch represents the model behind the search form of `app\models\ApiAssessments`.
 */
class ApiAssessmentsSearch extends ApiAssessments {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'candidates', 'invited', 'started', 'finished', 'status', 'finished_percentage'], 'integer'],
            [['name', 'modified', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = ApiAssessments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'candidates' => $this->candidates,
            'invited' => $this->invited,
            'started' => $this->started,
            'finished' => $this->finished,
            'status' => $this->status,
            'finished_percentage' => $this->finished_percentage,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'modified', $this->modified]);

        return $dataProvider;
    }

}
