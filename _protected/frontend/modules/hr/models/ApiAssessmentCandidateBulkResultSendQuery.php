<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentCandidateBulkResultSend]].
 *
 * @see ApiAssessmentCandidateBulkResultSend
 */
class ApiAssessmentCandidateBulkResultSendQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateBulkResultSend[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateBulkResultSend|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
