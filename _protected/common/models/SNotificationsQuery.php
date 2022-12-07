<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SNotifications]].
 *
 * @see SNotifications
 */
class SNotificationsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SNotifications[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SNotifications|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
