<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentTestCoveredSkills]].
 *
 * @see ApiAssessmentTestCoveredSkills
 */
class ApiAssessmentTestCoveredSkillsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestCoveredSkills[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestCoveredSkills|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
