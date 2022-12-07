<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ServiceEvent]].
 *
 * @see \common\models\ServiceEvent
 */
class ServiceEventQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceEvent[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceEvent|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function deleted() {
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function published() {
        return $this->andWhere(['action_id' => 1]);
    }

    public function freshFirst() {
        return $this->orderBy('created_at DESC');
    }

    public function shared() {
        $this->where(['job_seeker_id' => Yii::$app->user->id]);
        return $this;
    }

    public function opportunity($opportunity = null) {

        if (!is_null($opportunity)) {
            return $this->andWhere(['s_opportunity_id' => (int) $opportunity]);
        } else {
            return $this; //All opportunities
        }
    }

    public function action($action_id = null) {

        if (!is_null($action_id)) {
            return $this->andWhere(['action_id' => (int) $action_id]);
        } else {
            return $this; //All opportunities
        }
    }

    public function available($title = null, $district_id = null, $sort = null) {

        if (isset($title)) {
            $this->andWhere(['like', 'service_event.event_title', '%' . htmlspecialchars($title) . '%', false]);
        }
        if (isset($district_id) && intval($district_id) > 0) {
            $district_sectors = \backend\models\SGeosector::findByDistrict($district_id);
            if (count($district_sectors)) {
                $sectors = array();
                foreach ($district_sectors as $sector) {
                    array_push($sectors, $sector['id']);
                }
                $this->andWhere(['in', 'service_event.event_location', $sectors]);
            }
        }
        if (isset($sort)) {
            if ($sort == 'N') {
                $this->orderBy(['service_event.closure_date' => SORT_DESC]);
            }
            if ($sort == 'O') {
                $this->orderBy(['service_event.closure_date' => SORT_ASC]);
            }
        }
        return $this->andWhere(['or', ['>=', 'closure_date', date('Y-m-d')], ['always_open_flag' => 1]]);
    }

    public function allevents() {

        return $this->andWhere('deleted_by is null or deleted_by = 0');
    }

    public function unAvailable() {

        return $this->andWhere(['<', 'closure_date', date('Y-m-d')]);
    }

    public function throughKora() {
        return $this->andWhere(['apply_through_kora_flag' => 1]);
    }

}
