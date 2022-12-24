<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentCandidateBulkRemove]].
 *
 * @see ApiAssessmentCandidateBulkRemove
 */
class ApiAssessmentCandidateBulkRemoveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateBulkRemove[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateBulkRemove|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
