<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentTestType]].
 *
 * @see ApiAssessmentTestType
 */
class ApiAssessmentTestTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
