<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentCandidateBulkReminder]].
 *
 * @see ApiAssessmentCandidateBulkReminder
 */
class ApiAssessmentCandidateBulkReminderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateBulkReminder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateBulkReminder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
