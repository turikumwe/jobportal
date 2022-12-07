<?php

namespace backend\modules\service\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceTraining;

/**
 * ServiceTrainingSearch represents the model behind the search form about `common\models\ServiceTraining`.
 */
class ServiceTrainingSearch extends ServiceTraining
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'posted', 'district_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['training_category_id', 'training_name', 'training_details', 'training_duration', 'application_deadline', 'start_date', 'training_center', 'training_provider', 'action_id', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $restore=null)
    {
        if(is_null($restore)){
            $query = ServiceTraining::find();
        }else{
            $query = ServiceTraining::find()->deleted();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'application_deadline' => $this->application_deadline,
            'start_date' => $this->start_date,
            'posted' => $this->posted,
            'district_id' => $this->district_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'training_category_id', $this->training_category_id])
            ->andFilterWhere(['like', 'training_name', $this->training_name])
            ->andFilterWhere(['like', 'training_details', $this->training_details])
            ->andFilterWhere(['like', 'training_duration', $this->training_duration])
            ->andFilterWhere(['like', 'training_center', $this->training_center])
            ->andFilterWhere(['like', 'training_provider', $this->training_provider])
            ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }
}
