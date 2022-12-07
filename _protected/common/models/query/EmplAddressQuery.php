<?php

namespace common\models\query;
use Yii;
/**
 * This is the ActiveQuery class for [[\common\models\EmplAddress]].
 *
 * @see \common\models\EmplAddress
 */
class EmplAddressQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\EmplAddress[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\EmplAddress|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\EmplAddress|array|null
     */
    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }

    public function current() {
        return $this->orderBy(['created_at' => SORT_DESC])->limit(1);
    }

    public function mine($user_id) {
       return $this->where(['employer_id' =>$user_id]);
    }
}
