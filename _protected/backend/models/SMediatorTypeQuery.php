<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[SMediatorType]].
 *
 * @see SMediatorType
 */
class SMediatorTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SMediatorType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SMediatorType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
