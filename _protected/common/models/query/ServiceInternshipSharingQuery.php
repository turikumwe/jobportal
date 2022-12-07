<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ServiceInternshipSharing]].
 *
 * @see \common\models\ServiceInternshipSharing
 */
class ServiceInternshipSharingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceInternshipSharing[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceInternshipSharing|array|null
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

    public function saved(){
        $this->where(['job_seeker_id' => Yii::$app->user->id])
            ->andWhere(['user_id'     => Yii::$app->user->id]);
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
