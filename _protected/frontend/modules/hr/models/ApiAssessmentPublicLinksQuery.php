<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiAssessmentPublicLinks]].
 *
 * @see ApiAssessmentPublicLinks
 */
class ApiAssessmentPublicLinksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiAssessmentPublicLinks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentPublicLinks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
