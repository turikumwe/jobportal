<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[SRegistrationauthority]].
 *
 * @see SRegistrationauthority
 */
class SRegistrationauthorityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SRegistrationauthority[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SRegistrationauthority|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
