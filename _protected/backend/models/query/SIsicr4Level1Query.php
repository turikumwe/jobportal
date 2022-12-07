<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\SIsicr4Level1]].
 *
 * @see \backend\models\SIsicr4Level1
 */
class SIsicr4Level1Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\SIsicr4Level1[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\SIsicr4Level1|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
