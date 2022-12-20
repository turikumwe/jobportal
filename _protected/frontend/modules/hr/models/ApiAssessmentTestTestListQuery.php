<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentTestTestList]].
 *
 * @see ApiAssessmentTestTestList
 */
class ApiAssessmentTestTestListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestTestList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestTestList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
