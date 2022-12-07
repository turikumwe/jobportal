<?php

namespace common\models\query;
use Yii;
/**
 * This is the ActiveQuery class for [[\common\models\ServiceEventSharing]].
 *
 * @see \common\models\ServiceEventSharing
 */
class ServiceEventSharingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceEventSharing[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceEventSharing|array|null
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

    public function freshFirst() {
        return $this->orderBy('created_at DESC');
    }

    public function saved(){
        $this->where(['job_seeker_id' => Yii::$app->user->id])
            ->andWhere(['user_id'     => Yii::$app->user->id]);
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
        $this->where(['s_opportunity_id' => $opportunity]);
        return $this;
    }
}
