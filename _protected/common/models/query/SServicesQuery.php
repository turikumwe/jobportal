<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SServices]].
 *
 * @see \common\models\SServices
 */
class SServicesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\SServices[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\SServices|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    /**
     * {@inheritdoc}
     * @return \backend\models\SSkill|array|null
     */
    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }
}
