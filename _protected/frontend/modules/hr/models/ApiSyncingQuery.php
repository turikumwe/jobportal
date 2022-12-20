<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[ApiSyncing]].
 *
 * @see ApiSyncing
 */
class ApiSyncingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ApiSyncing[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ApiSyncing|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
