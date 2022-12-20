<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentCandidateTestResult]].
 *
 * @see ApiAssessmentCandidateTestResult
 */
class ApiAssessmentCandidateTestResultQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateTestResult[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateTestResult|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
