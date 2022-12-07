<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\JsEventApplication]].
 *
 * @see \common\models\JsEventApplication
 */
class JsEventApplicationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\JsEventApplication[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsEventApplication|array|null
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

    public function freshFirst()
    {
        return $this->orderBy('created_at DESC');
    }

    public function type($opportunity){
        if(!is_null($opportunity)){
            return $this->where(['js_event_application.s_opportunity_id' => (int)$opportunity ]);
        }else{
            return $this;//All opportunities
        }  
    }
}
