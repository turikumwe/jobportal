<?php

namespace frontend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsJobApplication;

/**
 * JsJobApplicationSearch represents the model behind the search form about `common\models\JsJobApplication`.
 */
class JsJobApplicationSearch extends JsJobApplication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'job_id', 'created_by', 'deleted_by', 'updated_by','s_opportunity_id','placement'], 'integer'],
            [['motivation', 's_opportunity_id','application_date', 'status_id', 'reason_rejection', 'placement','created_at','start','end','closure_start','closure_end', 'deleted_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = JsJobApplication::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'job_id' => $this->job_id,
            'application_date' => $this->application_date,
            's_opportunity_id' => $this->s_opportunity_id,
            'placement' => $this->placement,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'motivation', $this->motivation])
            ->andFilterWhere(['like', 'status_id', $this->status_id])
            ->andFilterWhere(['like', 'reason_rejection', $this->reason_rejection]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchReport($opportunity , $params)
    {
       
        $query = JsJobApplication::find()
                            ->select(['js_job_application.s_opportunity_id,job_id,COUNT(job_id) AS stat'])
                            ->andWhere(['js_job_application.s_opportunity_id' => $opportunity])
                            ->orderBy(['job_id' => SORT_ASC ])
                            ->groupBy(['job_id']);

        $query->joinWith([
            'job' => function($q) {
                $q->throughKora();
            }
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'job_id' => $this->job_id,
            'placement' => $this->placement,
            'application_date' => $this->application_date,
            's_opportunity_id' => $this->s_opportunity_id,
        ]);

        $query->andFilterWhere(['like', 'motivation', $this->motivation])
            ->andFilterWhere(['like', 'status_id', $this->status_id])
            ->andFilterWhere(['like', 'reason_rejection', $this->reason_rejection]);

        return $dataProvider;
    }

    public function searchReportBreakdown($params,$job, $opportunity)
    {
        $query = JsJobApplication::find()->where(['job_id' => $job])
                                         ->andWhere(['s_opportunity_id' => $opportunity]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'job_id' => $this->job_id,
            'application_date' => $this->application_date,
            's_opportunity_id' => $this->s_opportunity_id,
            'placement' => $this->placement,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'motivation', $this->motivation])
            ->andFilterWhere(['like', 'status_id', $this->status_id])
            ->andFilterWhere(['like', 'reason_rejection', $this->reason_rejection]);

        return $dataProvider;
    }

    public function searchReportPlacement($params, $opportunity)
    {
        $query = JsJobApplication::find()->type($opportunity);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'job_id' => $this->job_id,
            's_opportunity_id' => $this->s_opportunity_id,
            'placement' => $this->placement,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);
        //var_dump($this->start , $this->end);die;
        $query->andFilterWhere(['like', 'motivation', $this->motivation])
            ->andFilterWhere(['like', 'status_id', $this->status_id])
            ->andFilterWhere(['between', 'application_date', $this->start , $this->end]);

        return $dataProvider;
    }
    
}
