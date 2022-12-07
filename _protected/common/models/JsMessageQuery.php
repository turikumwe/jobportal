<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[JsMessage]].
 *
 * @see JsMessage
 */
class JsMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JsMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JsMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function sent(){
        return $this->andWhere(['created_by' => \Yii::$app->user->id]);
    }

    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }

    public function received(){
        return $this->andWhere(['js_to' => \Yii::$app->user->id]);
    }

     public function new(){
        return $this->andWhere(['status' => 0]);
    }
}
