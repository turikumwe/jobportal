<?php

namespace common\models;
use Yii;
/**
 * This is the ActiveQuery class for [[UserProfile1]].
 *
 * @see UserProfile1
 */
class UserProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserProfile1[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserProfile1|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function owner(){

        return $this->where(['user_id' => Yii::$app->user->id]);
    }

    public function active(){

        return $this->andWhere(['terminate' => 1]);
    }
}
