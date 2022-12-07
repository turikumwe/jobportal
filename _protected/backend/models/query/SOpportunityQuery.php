<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\SOpportunity]].
 *
 * @see \backend\models\SOpportunity
 */
class SOpportunityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\SOpportunity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\SOpportunity|array|null
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
    /**
     * {@inheritdoc}
     * @return \common\models\JsSkill|array|null
     */
    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }
}
