<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[SEventDuration]].
 *
 * @see SEventDuration
 */
class SEventDurationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SEventDuration[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SEventDuration|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
