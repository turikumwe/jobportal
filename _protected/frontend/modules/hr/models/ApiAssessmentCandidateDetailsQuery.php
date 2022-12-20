<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentCandidateDetails]].
 *
 * @see ApiAssessmentCandidateDetails
 */
class ApiAssessmentCandidateDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
