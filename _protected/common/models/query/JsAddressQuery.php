<?php

namespace common\models\query;
use Yii;
/**
 * This is the ActiveQuery class for [[JsAddress]].
 *
 * @see JsAddress
 */
class JsAddressQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JsAddress[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JsAddress|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSkill|array|null
     */
    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }

    public function latest(){
        return $this->orderBy('created_at DESC');
    }

    public function owner(){
        return $this->where(['user_id' => Yii::$app->user->id]);
    }
}
