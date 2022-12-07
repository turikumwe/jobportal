<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\SIsco08Level2]].
 *
 * @see \backend\models\SIsco08Level2
 */
class SIsco08Level2Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\SIsco08Level2[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\SIsco08Level2|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
