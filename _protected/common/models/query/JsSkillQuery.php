<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\JsSkill]].
 *
 * @see \common\models\JsSkill
 */
class JsSkillQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\JsSkill[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSkill|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

     /**
     * {@inheritdoc}
     * @return \common\models\JsSkill|array|null
     */
    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }
}
