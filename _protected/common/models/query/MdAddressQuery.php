<?php

namespace common\models\query;
use Yii;
/**
 * This is the ActiveQuery class for [[\common\models\MdAddress]].
 *
 * @see \common\models\MdAddress
 */
class MdAddressQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\MdAddress[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\MdAddress|array|null
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

    public function mine() {
       return $this->where(['mediator_id' => Yii::$app->user->id]);
    }

    public function contact($sector_id) {
        return $this->where(['geo_sector_id' => $sector_id]);
    }
}
