<?php

namespace common\models\query;
use common\models\User;
/**
 * This is the ActiveQuery class for [[\common\models\EmplEmployer]].
 *
 * @see \common\models\EmplEmployer
 */
class EmplEmployerQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return \common\models\EmplEmployer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\EmplEmployer|array|null
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
        $this->leftJoin('user u', 'u.id = empl_employer.id');
        return $this->andWhere([ '<>', 'u.status',  User::STATUS_DELETED]);
    }
    public function publicEmployers($ownership){
        return $this->where(['ownership_id' => 1 ]);
    }
    public function privateEmployers($ownership){
        return $this->where(['ownership_id' => 2 ]);
    }
    public function selfEmployers($ownership){
        return $this->where(['ownership_id' => 10 ]);
    }
}
