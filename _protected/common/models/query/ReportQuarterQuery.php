<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ServiceEvent]].
 *
 * @see \common\models\ServiceEvent
 */
class ReportQuarterQuery extends \yii\db\ActiveQuery {
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


    public function freshFirst() {
        return $this->orderBy('created_at DESC');
    }

    public function allQuarters() {

        return $this->andWhere('deleted_by is null or deleted_by = 0');
    }

}
