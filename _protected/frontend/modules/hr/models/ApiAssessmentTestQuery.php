<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentTest]].
 *
 * @see ApiAssessmentTest
 */
class ApiAssessmentTestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
