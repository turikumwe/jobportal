<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\SIsco08Level4]].
 *
 * @see \backend\models\SIsco08Level4
 */
class SIsco08Level4Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\SIsco08Level4[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\SIsco08Level4|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
