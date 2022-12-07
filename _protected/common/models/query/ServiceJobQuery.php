<?php
namespace common\models\query;
use Yii;
/**
 * This is the ActiveQuery class for [[\common\models\ServiceJob]].
 *
 * @see \common\models\ServiceJob
 */
class ServiceJobQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceJob[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ServiceJob|array|null
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
        $this->andWhere(['<>', 'deleted_by', 0]);
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function published(){
         return $this->andWhere(['action_id' => 1]);
    }

     public function unpublished(){
        $this->andWhere(['action_id' => 2]);
         return  $this;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function freshFirst() {
        return $this->orderBy('created_at DESC');
    }

    public function forMediator(){
        return $this->where(['created_by' =>Yii::$app->user->id ]);
    }
    
    public function own(){
        return $this->where(['created_by' =>Yii::$app->user->id ]);
    }

    public function top($count = 10)
    {
        $this->orderBy('id desc');
        //$this->indexBy('frequency');
        $this->limit($count);

        return $this;
    }

    public function opportunity($opportunity=null){

        if(!is_null($opportunity)){
            return $this->andWhere(['s_opportunity_id' => (int)$opportunity ]);
        }else{
            return $this;//All opportunities
        }  
    }

    public function action($action_id=null){

        if(!is_null($action_id)){
            return $this->andWhere(['action_id' => $action_id]);
        }else{
            return $this;//All opportunities
        }  
    }

     public function economicSector($economic_sector_id=null){

        if(!is_null($economic_sector_id)){
            return $this->andWhere(['economic_sector_id' => (int)$economic_sector_id]);
        }else{
            return $this;//All opportunities
        }  
    }

    public function available(){ 

        return $this->andWhere(['>=', 'closure_date',date('Y-m-d') ]);   

    }

    public function unAvailable(){ 

        return $this->andWhere(['<', 'closure_date',date('Y-m-d') ]);   

    }

     public function throughKora(){
        return $this->andWhere(['apply_through_kora_flag' => 1]);
    }
}
