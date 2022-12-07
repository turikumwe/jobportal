<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\SDistrictMediatorr]].
 *
 * @see \backend\models\SDistrictMediatorr
 */
class SDistrictMediatorrQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\SDistrictMediatorr[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\SDistrictMediatorr|array|null
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
}
