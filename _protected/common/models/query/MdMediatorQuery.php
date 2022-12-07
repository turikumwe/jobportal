<?php

namespace common\models\query;
use common\models\User;
/**
 * This is the ActiveQuery class for [[\common\models\MdMediator]].
 *
 * @see \common\models\MdMediator
 */
class MdMediatorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\MdMediator[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\MdMediator|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

     /**
     * @return $this
     */
    public function freshFirst()
    {
        return $this->orderBy('created_at DESC');
    }

     /**
     * @return $this
     */
    public function deleted()
    {
        return $this->where(['<>', 'deleted_by', 0]);
    }

    /**
     * @param User $user
     * @return $this
     */
    public function active()
    {
        $this->leftJoin('user u', 'u.id = md_mediator.id');
        return $this->andWhere([ '<>', 'u.status',  User::STATUS_DELETED]);
    }
}
