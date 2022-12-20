<?php

namespace frontend\modules\hr\models;
/**
 * This is the ActiveQuery class for [[ApiAssessmentDetails]].
 *
 * @see ApiAssessmentDetails
 */
class ApiAssessmentDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
