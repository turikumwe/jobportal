<?php

namespace frontend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsEventApplication;

/**
 * JsEventApplicationSearch represents the model behind the search form about `common\models\JsEventApplication`.
 */
class JsEventApplicationSearch extends JsEventApplication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id','user_gender', 'area_of_expertise_id', 'employment_status_id', 'special_assistance_id', 'created_by', 'deleted_by', 'updated_by','s_opportunity_id'], 'integer'],
            [['s_opportunity_id','motivation', 'application_date', 'status_id','placement', 'created_at', 'deleted_at', 
            'updated_at','event_start_date','event_end_date','event','event_venue','start','end'], 'safe'],
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
        $query = JsEventApplication::find();

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
            'even_id' => $this->even_id,
            'application_date' => $this->application_date,
            'area_of_expertise_id' => $this->area_of_expertise_id,
            'employment_status_id' => $this->employment_status_id,
            'special_assistance_id' => $this->special_assistance_id,
            's_opportunity_id' => $this->s_opportunity_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'motivation', $this->motivation])
            ->andFilterWhere(['like', 'status_id', $this->status_id]);

        return $dataProvider;
    }

    public function searchReport($opportunity , $params)
    {
       
        $query = JsEventApplication::find()
                            ->select(['js_event_application.s_opportunity_id,even_id,COUNT(even_id) AS stat'])                            
                            ->where(['js_event_application.s_opportunity_id' => $opportunity])
                            ->orderBy(['even_id' => SORT_ASC ])
                            ->groupBy(['even_id']);
        $query->joinWith([
            'even' => function($q) {
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
            'even_id' => $this->even_id,
            'application_date' => $this->application_date,
            'area_of_expertise_id' => $this->area_of_expertise_id,
            'employment_status_id' => $this->employment_status_id,
            'special_assistance_id' => $this->special_assistance_id,
            's_opportunity_id' => $this->s_opportunity_id,
        ]);

        $query->andFilterWhere(['like', 'motivation', $this->motivation])
            ->andFilterWhere(['like', 'status_id', $this->status_id]);

        return $dataProvider;
    }

    public function searchReportBreakdown($eventtitle,$opportunity,$params)
    {
        $query = JsEventApplication::find()->where(['even_id' => $eventtitle])
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
            'even_id' => $this->even_id,
            'application_date' => $this->application_date,
            'area_of_expertise_id' => $this->area_of_expertise_id,
            'employment_status_id' => $this->employment_status_id,
            'special_assistance_id' => $this->special_assistance_id,
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
            ->andFilterWhere(['like', 'status_id', $this->status_id]);

        return $dataProvider;
    }

    public function searchReportEvent($params,$opportunity = null)
    {
    
        $query = Yii::$app->reports->eventsDetails($opportunity);
        $query->joinWith(['even']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
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
            'even_id' => $this->even_id,
            'application_date' => $this->application_date,
            'area_of_expertise_id' => $this->area_of_expertise_id,
            'employment_status_id' => $this->employment_status_id,
            'special_assistance_id' => $this->special_assistance_id,
            's_opportunity_id' => $this->s_opportunity_id,
            'placement' => $this->placement,
            //'user_profile.gender' => $this->user_gender

        ]);


        $query->andFilterWhere(['like', 'service_event.event_title', $this->event])
            ->andFilterWhere(['like', 'service_event.venue', $this->event_venue])
            ->andFilterWhere(['like', 'status_id', $this->status_id])
            ->andFilterWhere(['like', 'service_event.start_date', $this->event_start_date])
            ->andFilterWhere(['like', 'service_event.end_date', $this->event_end_date])
            ->andFilterWhere(['between', 'service_event.start_date', $this->start , $this->end]);;

        return $dataProvider;
    }

    
    public function searchReportEventStat($params,$opportunity = null)
    {
    
        $query = JsEventApplication::find()->select(['even_id'])->type($opportunity)->groupBy('even_id');
        $query->joinWith(['even']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
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
            'even_id' => $this->even_id,
            ]);

        $query->andFilterWhere(['like', 'service_event.event_title', $this->event])
            ->andFilterWhere(['like', 'service_event.venue', $this->event_venue])
            ->andFilterWhere(['like', 'service_event.start_date', $this->event_start_date])
            ->andFilterWhere(['like', 'service_event.end_date', $this->event_end_date])
            ->andFilterWhere(['between', 'service_event.start_date', $this->start , $this->end]);

        return $dataProvider;
    }

    public function searchReportEventStatBreakdown($params,$event_id, $opportunity = null)
    {
    
        $query = JsEventApplication::find()->type($opportunity)->andWhere(['even_id' => $event_id]);
        $query->joinWith(['even']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
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
            'even_id' => $this->even_id,
            ]);

        $query->andFilterWhere(['like', 'service_event.event_title', $this->event])
            ->andFilterWhere(['like', 'service_event.venue', $this->event_venue])
            ->andFilterWhere(['like', 'service_event.start_date', $this->event_start_date])
            ->andFilterWhere(['like', 'service_event.end_date', $this->event_end_date])
            ->andFilterWhere(['between', 'service_event.start_date', $this->start , $this->end]);;

        return $dataProvider;
    }
}
