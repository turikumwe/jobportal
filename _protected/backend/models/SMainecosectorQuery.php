<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[SMainecosector]].
 *
 * @see SMainecosector
 */
class SMainecosectorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SMainecosector[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SMainecosector|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
