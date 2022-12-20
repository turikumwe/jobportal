<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentCandidate]].
 *
 * @see ApiAssessmentCandidate
 */
class ApiAssessmentCandidateQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidate[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidate|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
