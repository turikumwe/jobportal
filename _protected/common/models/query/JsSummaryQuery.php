<?php

namespace common\models\query;
use Yii;
/**
 * This is the ActiveQuery class for [[JsSummary]].
 *
 * @see JsSummary
 */
class JsSummaryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JsSummary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JsSummary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

     /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }

     /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function myProfile(){
       return $this->where(['user_id' => Yii::$app->user->id]);
    }
}
