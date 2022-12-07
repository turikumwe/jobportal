<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\SDistrictMediator]].
 *
 * @see \backend\models\SDistrictMediator
 */
class SDistrictMediatorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\SDistrictMediator[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\SDistrictMediator|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
