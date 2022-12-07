<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\SIsco08Level3]].
 *
 * @see \backend\models\SIsco08Level3
 */
class SIsco08Level3Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\SIsco08Level3[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\SIsco08Level3|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
