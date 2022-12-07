<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[SDomainCat3]].
 *
 * @see SDomainCat3
 */
class SDomainCat3Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SDomainCat3[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SDomainCat3|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
