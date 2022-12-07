<?php

namespace frontend\modules\service\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceEvent;
use backend\models\SGeosector;

/**
 * ServiceEventSearch represents the model behind the search form about `common\models\ServiceEvent`.
 */
class ServiceEventSearch extends ServiceEvent {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'event_category_id', 'posted', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['event_title', 'event_summary', 'from', 'to', 'date_posted', 'event_requirement', 'event_location', 'start_date', 'closure_date', 'how_to_apply', 'contact_phone', 'contact_email', 'action_id', 'created_at', 'deleted_at', 'updated_at', 'start', 'end', 'closure_start', 'closure_end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
    public function search($params, $opportunity, $title = null, $district_id = null, $sort = null) {

        $query = ServiceEvent::find()->where(['s_opportunity_id' => 1])->opportunity($opportunity)->available($title, $district_id, $sort);

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
            'event_category_id' => $this->event_category_id,
            'start_date' => $this->start_date,
            'closure_date' => $this->closure_date,
            'posted' => $this->posted,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
                ->andFilterWhere(['like', 'event_summary', $this->event_summary])
                ->andFilterWhere(['like', 'event_requirement', $this->event_requirement])
                ->andFilterWhere(['like', 'event_location', $this->event_location])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email])
                ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }

    public function searchEvents($params, $opportunity, $title = null, $district_id = null, $sort = null) {

        $query = ServiceEvent::find()->where(['s_opportunity_id' => 2])->opportunity($opportunity)->available($title, $district_id, $sort);

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
            'event_category_id' => $this->event_category_id,
            'start_date' => $this->start_date,
            'closure_date' => $this->closure_date,
            'posted' => $this->posted,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
                ->andFilterWhere(['like', 'event_summary', $this->event_summary])
                ->andFilterWhere(['like', 'event_requirement', $this->event_requirement])
                ->andFilterWhere(['like', 'event_location', $this->event_location])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email])
                ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }

    public function searchAll($params, $opportunity, $type, $search, $title = null) {

        $query = ServiceEvent::find()->opportunity($opportunity)->allevents()->orderBy('created_at desc');
        if (isset($title)) {
            $query->andWhere(['like', 'event_title', htmlspecialchars($title) . '%', false]);
        }
        //User from Mediation center
        if (Yii::$app->user->can('mediator')) {
            $user_ids_from_same_mediator = \common\models\User::getUserIdsFromSameMediator();
            $query->andWhere(['in', 'created_by', $user_ids_from_same_mediator]);
        }
        if (Yii::$app->user->can('employer')) {
            //An employer has this currently logged in user
            $query->andWhere(['in', 'created_by', Yii::$app->user->id]);
        }
        $query->andWhere(['s_opportunity_id'=>$type]);
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
            'event_category_id' => $this->event_category_id,
            'start_date' => $this->start_date,
            'closure_date' => $this->closure_date,
            'posted' => $this->posted,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
                ->andFilterWhere(['like', 'event_summary', $this->event_summary])
                ->andFilterWhere(['like', 'event_requirement', $this->event_requirement])
                ->andFilterWhere(['like', 'event_location', $this->event_location])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email])
                ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }

    public function searchReport($params, $opportunity = null, $action_id = null) {

        $query = Yii::$app->reports->eventType($opportunity, $action_id);

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
            'event_category_id' => $this->event_category_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'posted' => $this->posted,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
                ->andFilterWhere(['like', 'event_summary', $this->event_summary])
                ->andFilterWhere(['like', 'event_requirement', $this->event_requirement])
                ->andFilterWhere(['like', 'event_location', $this->event_location])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email])
                ->andFilterWhere(['like', 'action_id', $this->action_id])
                ->andFilterWhere(['between', 'start_date', $this->start, $this->end])
                ->andFilterWhere(['between', 'closure_date', $this->closure_start, $this->closure_end]);
        ;

        return $dataProvider;
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

    public function searchReportLocation($params, $opportunity) {
        $query = ServiceEvent::find()->leftJoin('s_geosector', 's_geosector.id = service_event.event_location')
                ->opportunity($opportunity)
                ->select(['s_geosector.district_id as district', 'event_location'])
                ->groupBy('s_geosector.district_id,event_location');

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
            //'s_geosector.district_id' => $this->district_id,
            'id' => $this->id,
        ]);

        return $dataProvider;
    }

    public function searchReportLocationByDistrict($params, $district, $opportunity) {

        $query = ServiceEvent::find()->opportunity($opportunity)//->available()
                ->andWhere(['IN', 'event_location', SGeosector::find()->select('id')->andWhere(['district_id' => $district])]);

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
            'event_category_id' => $this->event_category_id,
            'closure_date' => $this->closure_date,
            'start_date' => $this->start_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'posted' => $this->posted,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
                ->andFilterWhere(['like', 'event_summary', $this->event_summary])
                ->andFilterWhere(['like', 'event_requirement', $this->event_requirement])
                ->andFilterWhere(['like', 'event_location', $this->event_location])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email])
                ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }

    public function searchReportEconomicSector($params, $opportunity = null, $economic_sector_id = null) {

        $query = Yii::$app->reports->eventEconomicSectorType($opportunity, $economic_sector_id);

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
            'event_category_id' => $this->event_category_id,
            'closure_date' => $this->closure_date,
            'start_date' => $this->start_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'posted' => $this->posted,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
                ->andFilterWhere(['like', 'event_summary', $this->event_summary])
                ->andFilterWhere(['like', 'event_requirement', $this->event_requirement])
                ->andFilterWhere(['like', 'event_location', $this->event_location])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email])
                ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }

    public function searchReportEconomicSectorBreakdown($params, $economic_sector_id, $opportunity) {

        $query = Yii::$app->reports->eventEconomicSectorBreakdown($opportunity, $economic_sector_id);

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
            'event_category_id' => $this->event_category_id,
            'closure_date' => $this->closure_date,
            'start_date' => $this->start_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'posted' => $this->posted,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
                ->andFilterWhere(['like', 'event_summary', $this->event_summary])
                ->andFilterWhere(['like', 'event_requirement', $this->event_requirement])
                ->andFilterWhere(['like', 'event_location', $this->event_location])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email])
                ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }

    public function count($id) {
        return ServiceEvent::find()->where(['event_category_id' => $id])->available()->count();
    }

    public function countdistrict($id) {
        return ServiceEvent::find()->where(['event_location' => $id])->available()->count();
    }

    public function title($type) {
        return !is_null($type) ? \common\models\SOpportunity::find()->where(['id' => $type])->one()->name : 'Opportunity';
    }

}
