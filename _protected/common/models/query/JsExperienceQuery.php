<?php

namespace common\models\query;
use Yii;
/**
 * This is the ActiveQuery class for [[\common\models\JsExperience]].
 *
 * @see \common\models\JsExperience
 */
class JsExperienceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\JsExperience[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsExperience|array|null
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

     /**
     * @return $this
     */
    public function experience()
    {   
        $this->leftJoin(['pr' => 'user_profile'], 'pr.user_id = js_experience.user_id')
               ->andWhere(
                    [
                        'pr.user_id' => Yii::$app->user->id,
                        'pr.show_experience' => 1
                    ]);    
      
        return $this;
    }
}
