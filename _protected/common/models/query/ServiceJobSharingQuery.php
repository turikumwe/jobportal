<?php

namespace common\models\query;
use Yii;
/**
 * This is the ActiveQuery class for [[\common\models\ServiceJobSharing]].
 *
 * @see \common\models\ServiceJobSharing
 */
class ServiceJobSharingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceJobSharing[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceJobSharing|array|null
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

    public function shared(){
        $this->where(['job_seeker_id' => Yii::$app->user->id]);
        return $this;
    }

    public function type($opportunity){
        if(is_null($opportunity)){
            return $this;
        }
        $this->where(['s_opportunity_id' => (int)$opportunity]);
        return $this;
    }

    public function saved(){
        $this->andWhere(['job_seeker_id' => Yii::$app->user->id])
            ->andWhere(['user_id'        => Yii::$app->user->id]);

        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function freshFirst() {
        return $this->orderBy('created_at DESC');
    }
}
