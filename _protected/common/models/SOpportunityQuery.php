<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SOpportunity]].
 *
 * @see SOpportunity
 */
class SOpportunityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SOpportunity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SOpportunity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /*
    * For Job , Apprenticeship, Interneship
    *
    */
    public function firstType(){
        return $this->where(['type' => 1 ]);
    }

    /*
    * For event , Training, Workshop , Open House Day , Networking , Information sharing
    *
    */
    public function secondType(){
        return $this->where(['type' => 2 ]);
    }

    public function opportunity($opportunity){
        return $this->where(['type' => $opportunity ]);
    }
}
