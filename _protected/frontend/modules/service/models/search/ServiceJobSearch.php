<?php

namespace frontend\modules\service\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceJob;

/**
 * ServiceJobSearch represents the model behind the search form about `common\models\ServiceJob`.
 */
class ServiceJobSearch extends ServiceJob {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'positions_number', 'economic_sector_id', 'education_level_id', 'education_field_id', 'action_id', 'district_id', 'posted', 'created_by', 'deleted_by', 'updated_by', 'occupation_grouping_id', 'competency_level_id'], 'integer'],
            [['employer', 'jobtitle', 'job_summary', 'from', 'to', 'date_posted', 'job_type_id', 'job_responsability', 'job_skill_requirement', 'job_remuneration', 'posting_date', 'closure_date', 'how_to_apply', 'contact_phone', 'contact_email', 'created_at', 'deleted_at', 'updated_at', 'start', 'end', 'closure_start', 'closure_end', 'publication_date'], 'safe'],
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
    public function search($params, $opportunity, $type, $search) {

        $query = ServiceJob::find()->available()->opportunity($opportunity);

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

        if ($type == 'dateposted') {

            switch ($search) {
                case 0:
                    //Anytime
                    $start = null;
                    $end = null;
                    break;

                case 1:
                    //Today
                    $start = date('Y-m-d 00:00:00');
                    $end = date('Y-m-d 23:59:59');
                    break;

                case 2:;
                    //last 7 days
                    $start = date('Y-m-d 23:59:59', strtotime('-7 days'));
                    $end = date('Y-m-d 23:59:59');
                    break;

                case 3:
                    //last 14 days
                    $start = date('Y-m-d 23:59:59', strtotime('-14 days'));
                    $end = date('Y-m-d 23:59:59');
                    break;

                case 4:
                    //last 30 days
                    $start = date('Y-m-d 23:59:59', strtotime('-30 days'));
                    $end = date('Y-m-d 23:59:59');
                    break;
            }

            $query->andFilterWhere(['between', 'created_at', $start, $end]);
        }

        if ($type == 'qualification') {
            $this->education_level_id = $search;
        }

        if ($type == 'jobtype') {
            $this->job_type_id = ($search == 4) ? null : $search;
        }

        if ($type == 'district') {
            $this->district_id = $search;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'positions_number' => $this->positions_number,
            'economic_sector_id' => $this->economic_sector_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'posting_date' => $this->posting_date,
            'closure_date' => $this->closure_date,
            'action_id' => $this->action_id,
            'job_type_id' => $this->job_type_id,
            'district_id' => $this->district_id,
            'posted' => $this->posted,
            'occupation_grouping_id' => $this->occupation_grouping_id,
            'competency_level_id' => $this->competency_level_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'employer', $this->employer])
                ->andFilterWhere(['like', 'jobtitle', $this->jobtitle])
                ->andFilterWhere(['like', 'job_summary', $this->job_summary])
                ->andFilterWhere(['like', 'job_responsability', $this->job_responsability])
                ->andFilterWhere(['like', 'job_skill_requirement', $this->job_skill_requirement])
                ->andFilterWhere(['like', 'job_remuneration', $this->job_remuneration])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['between', 'job_remuneration', $this->from, $this->to])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email]);

        return $dataProvider;
    }

    public function searchAll($params, $opportunity, $type, $search) {

        $query = ServiceJob::find()->opportunity($opportunity)->available();

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

        if ($type == 'dateposted') {

            switch ($search) {
                case 0:
                    //Anytime
                    $start = null;
                    $end = null;
                    break;

                case 1:
                    //Today
                    $start = date('Y-m-d 00:00:00');
                    $end = date('Y-m-d 23:59:59');
                    break;

                case 2:;
                    //last 7 days
                    $start = date('Y-m-d 23:59:59', strtotime('-7 days'));
                    $end = date('Y-m-d 23:59:59');
                    break;

                case 3:
                    //last 14 days
                    $start = date('Y-m-d 23:59:59', strtotime('-14 days'));
                    $end = date('Y-m-d 23:59:59');
                    break;

                case 4:
                    //last 30 days
                    $start = date('Y-m-d 23:59:59', strtotime('-30 days'));
                    $end = date('Y-m-d 23:59:59');
                    break;
            }

            $query->andFilterWhere(['between', 'created_at', $start, $end]);
        }

        if ($type == 'qualification') {
            $this->education_level_id = $search;
        }

        if ($type == 'jobtype') {
            $this->job_type_id = ($search == 4) ? null : $search;
        }

        if ($type == 'district') {
            $this->district_id = $search;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'positions_number' => $this->positions_number,
            'economic_sector_id' => $this->economic_sector_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'posting_date' => $this->posting_date,
            'closure_date' => $this->closure_date,
            'action_id' => $this->action_id,
            'job_type_id' => $this->job_type_id,
            'district_id' => $this->district_id,
            'posted' => $this->posted,
            'occupation_grouping_id' => $this->occupation_grouping_id,
            'competency_level_id' => $this->competency_level_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'employer', $this->employer])
                ->andFilterWhere(['like', 'jobtitle', $this->jobtitle])
                ->andFilterWhere(['like', 'job_summary', $this->job_summary])
                ->andFilterWhere(['like', 'job_responsability', $this->job_responsability])
                ->andFilterWhere(['like', 'job_skill_requirement', $this->job_skill_requirement])
                ->andFilterWhere(['like', 'job_remuneration', $this->job_remuneration])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['between', 'job_remuneration', $this->from, $this->to])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email]);

        return $dataProvider;
    }

    function countByJobType($job_type, $location = null, $category = null, $title=null) {
        $response = ServiceJob::find()->where('deleted_by = 0 and closure_date > curdate() and s_opportunity_id = ' . intval($job_type));

        if (isset($location) && intval($location) > 0) {
            $response->andWhere(['district_id' => $location]);
        }
        if (isset($category) && intval($category) > 0) {
            $response->andWhere(['occupation_grouping_id' => $category]);
        }
        if (isset($title)) {
            $response->andWhere(['like', 'jobtitle', '%'.htmlspecialchars($title) . '%', false]);
        }
        return($response->count());
    }
    
    function countByContractType($contract_type, $title = null, $group_id = null) {
        $response = ServiceJob::find()->where('deleted_by = 0 and closure_date > curdate() and job_type_id = ' . intval($contract_type));

        if (isset($location) && intval($location) > 0) {
            $response->andWhere(['district_id' => $location]);
        }
        if (isset($category) && intval($category) > 0) {
            $response->andWhere(['occupation_grouping_id' => $category]);
        }
        if (isset($title)) {
            $response->andWhere(['like', 'jobtitle', '%'.htmlspecialchars($title) . '%', false]);
        }
        return($response->count());
    }

    public function searchReport($params, $opportunity = null, $action_id = null) {
        $query = Yii::$app->reports->jobType($opportunity, $action_id);

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
            'occupation_grouping_id' => $this->occupation_grouping_id,
            'competency_level_id' => $this->competency_level_id,
            'economic_sector_id' => $this->economic_sector_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'positions_number' => $this->positions_number,
            'job_type_id' => $this->job_type_id,
            'district_id' => $this->district_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'action_id' => $this->action_id,
            'posted' => $this->posted,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'employer', $this->employer])
                ->andFilterWhere(['like', 'jobtitle', $this->jobtitle])
                ->andFilterWhere(['like', 'job_summary', $this->job_summary])
                ->andFilterWhere(['like', 'job_responsability', $this->job_responsability])
                ->andFilterWhere(['like', 'job_skill_requirement', $this->job_skill_requirement])
                ->andFilterWhere(['like', 'job_remuneration', $this->job_remuneration])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['between', 'job_remuneration', $this->from, $this->to])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email])
                ->andFilterWhere(['between', 'posting_date', $this->start, $this->end])
                ->andFilterWhere(['between', 'closure_date', $this->closure_start, $this->closure_end]);

        return $dataProvider;
    }

    public function searchReportLocation($params, $opportunity) {
        $query = ServiceJob::find()->opportunity($opportunity)->select(['district_id'])->groupBy('district_id');

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
            'district_id' => $this->district_id,
            'id' => $this->id,
        ]);

        return $dataProvider;
    }

    public function searchReportLocationByDistrict($params, $district, $opportunity) {

        $query = ServiceJob::find()->opportunity($opportunity)//->available()
                ->andWhere(['district_id' => $district]);

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
            'positions_number' => $this->positions_number,
            'economic_sector_id' => $this->economic_sector_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'posting_date' => $this->posting_date,
            'closure_date' => $this->closure_date,
            'action_id' => $this->action_id,
            'job_type_id' => $this->job_type_id,
            'district_id' => $this->district_id,
            'posted' => $this->posted,
            'occupation_grouping_id' => $this->occupation_grouping_id,
            'competency_level_id' => $this->competency_level_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'employer', $this->employer])
                ->andFilterWhere(['like', 'jobtitle', $this->jobtitle])
                ->andFilterWhere(['like', 'job_summary', $this->job_summary])
                ->andFilterWhere(['like', 'job_responsability', $this->job_responsability])
                ->andFilterWhere(['like', 'job_skill_requirement', $this->job_skill_requirement])
                ->andFilterWhere(['like', 'job_remuneration', $this->job_remuneration])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['between', 'job_remuneration', $this->from, $this->to])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email]);

        return $dataProvider;
    }

    public function searchReportEconomicSector($params, $opportunity = null, $economic_sector_id = null) {
        $query = Yii::$app->reports->jobEconomicSectorType($opportunity, $economic_sector_id);

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
            'occupation_grouping_id' => $this->occupation_grouping_id,
            'competency_level_id' => $this->competency_level_id,
            'economic_sector_id' => $this->economic_sector_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'positions_number' => $this->positions_number,
            'posting_date' => $this->posting_date,
            'closure_date' => $this->closure_date,
            'job_type_id' => $this->job_type_id,
            'district_id' => $this->district_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'action_id' => $this->action_id,
            'posted' => $this->posted,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'employer', $this->employer])
                ->andFilterWhere(['like', 'jobtitle', $this->jobtitle])
                ->andFilterWhere(['like', 'job_summary', $this->job_summary])
                ->andFilterWhere(['like', 'job_responsability', $this->job_responsability])
                ->andFilterWhere(['like', 'job_skill_requirement', $this->job_skill_requirement])
                ->andFilterWhere(['like', 'job_remuneration', $this->job_remuneration])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['between', 'job_remuneration', $this->from, $this->to])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email]);

        return $dataProvider;
    }

    public function searchReportEconomicSectorBreakdown($params, $economic_sector_id, $opportunity) {
        $query = Yii::$app->reports->jobEconomicSectorBreakdown($opportunity, $economic_sector_id);

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
            'positions_number' => $this->positions_number,
            'economic_sector_id' => $this->economic_sector_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'posting_date' => $this->posting_date,
            'closure_date' => $this->closure_date,
            'action_id' => $this->action_id,
            'job_type_id' => $this->job_type_id,
            'district_id' => $this->district_id,
            'posted' => $this->posted,
            'occupation_grouping_id' => $this->occupation_grouping_id,
            'competency_level_id' => $this->competency_level_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'employer', $this->employer])
                ->andFilterWhere(['like', 'jobtitle', $this->jobtitle])
                ->andFilterWhere(['like', 'job_summary', $this->job_summary])
                ->andFilterWhere(['like', 'job_responsability', $this->job_responsability])
                ->andFilterWhere(['like', 'job_skill_requirement', $this->job_skill_requirement])
                ->andFilterWhere(['like', 'job_remuneration', $this->job_remuneration])
                ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
                ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
                ->andFilterWhere(['between', 'job_remuneration', $this->from, $this->to])
                ->andFilterWhere(['like', 'contact_email', $this->contact_email]);

        return $dataProvider;
    }

    public function count($id) {
        return ServiceJob::find()->where(['education_level_id' => $id])->available()->count();
    }

    public function countdistrict($id) {
        return ServiceJob::find()->where(['district_id' => $id])->available()->count();
    }

    public function countAll() {
        return ServiceJob::find()->available()->count();
    }

    public function title($type) {
        return !is_null($type) ? \common\models\SOpportunity::find()->where(['id' => $type])->one()->name : 'Opportunity';
    }

}
