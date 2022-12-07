<?php

namespace common\models\query;
use common\models\ServiceJob;
/**
 * This is the ActiveQuery class for [[\common\models\JsJobApplication]].
 *
 * @see \common\models\JsJobApplication
 */
class JsJobApplicationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\JsJobApplication[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsJobApplication|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }

    public function applied() {
        return $this->where(['user_id' => \Yii::$app->user->id]);
    }

    public function thatJob($id) {
        return $this->Where(['job_id' => $id]);
    }


    /**
     * @return $this
     */
    public function freshFirst()
    {
        return $this->orderBy('created_at DESC');
    }

    public function type($opportunity){
        if(!is_null($opportunity)){
            return $this->andWhere(['s_opportunity_id' => (int)$opportunity ]);
        }else{
            return $this;//All opportunities
        }  
    }
}
