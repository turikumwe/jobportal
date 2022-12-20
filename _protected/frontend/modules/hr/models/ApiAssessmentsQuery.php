<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessments]].
 *
 * @see ApiAssessments
 */
class ApiAssessmentsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessments[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessments|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
