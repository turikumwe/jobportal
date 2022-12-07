<?php

namespace backend\modules\service\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceApprenticeship;

/**
 * ServiceApprenticeshipSearch represents the model behind the search form about `common\models\ServiceApprenticeship`.
 */
class ServiceApprenticeshipSearch extends ServiceApprenticeship
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'posted', 'district_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['apprenticeship_category_id', 'apprenticeship_name', 'apprenticeship_details', 'apprenticeship_duration', 'application_deadline', 'start_date', 'apprenticeship_center', 'apprenticeship_provider', 'action_id', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = ServiceApprenticeship::find();
        }else{
            $query = ServiceApprenticeship::find()->deleted();
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

        $query->andFilterWhere(['like', 'apprenticeship_category_id', $this->apprenticeship_category_id])
            ->andFilterWhere(['like', 'apprenticeship_name', $this->apprenticeship_name])
            ->andFilterWhere(['like', 'apprenticeship_details', $this->apprenticeship_details])
            ->andFilterWhere(['like', 'apprenticeship_duration', $this->apprenticeship_duration])
            ->andFilterWhere(['like', 'apprenticeship_center', $this->apprenticeship_center])
            ->andFilterWhere(['like', 'apprenticeship_provider', $this->apprenticeship_provider])
            ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }
}
