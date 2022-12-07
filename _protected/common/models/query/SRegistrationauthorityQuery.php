<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SRegistrationauthority]].
 *
 * @see \common\models\SRegistrationauthority
 */
class SRegistrationauthorityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\SRegistrationauthority[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\SRegistrationauthority|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
