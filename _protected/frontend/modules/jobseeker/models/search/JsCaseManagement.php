<?php

namespace frontend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsCaseManagement as JsCaseManagementModel;

/**
 * JsCaseManagement represents the model behind the search form about `common\models\JsCaseManagement`.
 */
class JsCaseManagement extends JsCaseManagementModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'given_service', 'type_of_job', 'mediotor_id','jobseeker_id'], 'integer'],
            [['availability', 'willingness', 'license_permit', 'geven_service_description', 'cooperative'], 'safe'],
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
    public function search($params)
    {
        $query = JsCaseManagementModel::find();

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
            'given_service' => $this->given_service,
            'type_of_job' => $this->type_of_job,
            'mediotor_id' => $this->mediotor_id,
            'jobseeker_id' => $this->jobseeker_id,
        ]);

        $query->andFilterWhere(['like', 'availability', $this->availability])
            ->andFilterWhere(['like', 'willingness', $this->willingness])
            ->andFilterWhere(['like', 'license_permit', $this->license_permit])
            ->andFilterWhere(['like', 'geven_service_description', $this->geven_service_description])
            ->andFilterWhere(['like', 'cooperative', $this->cooperative]);

        return $dataProvider;
    }

    public function searchReportStat($params)
    {
        $query = JsCaseManagementModel::find()->select('given_service')->GroupBy('given_service');

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
            'given_service' => $this->given_service,
            'type_of_job' => $this->type_of_job,
            'mediotor_id' => $this->mediotor_id,
            'jobseeker_id' => $this->jobseeker_id,
        ]);

        $query->andFilterWhere(['like', 'availability', $this->availability])
            ->andFilterWhere(['like', 'willingness', $this->willingness])
            ->andFilterWhere(['like', 'license_permit', $this->license_permit])
            ->andFilterWhere(['like', 'geven_service_description', $this->geven_service_description])
            ->andFilterWhere(['like', 'cooperative', $this->cooperative]);

        return $dataProvider;
    }

     public function searchReportStatBreakdown($params, $service)
    {
        $query = JsCaseManagementModel::find()->andWhere(['given_service' => $service]);

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
            'given_service' => $this->given_service,
            'type_of_job' => $this->type_of_job,
            'mediotor_id' => $this->mediotor_id,
            'jobseeker_id' => $this->jobseeker_id,
        ]);

        $query->andFilterWhere(['like', 'availability', $this->availability])
            ->andFilterWhere(['like', 'willingness', $this->willingness])
            ->andFilterWhere(['like', 'license_permit', $this->license_permit])
            ->andFilterWhere(['like', 'geven_service_description', $this->geven_service_description])
            ->andFilterWhere(['like', 'cooperative', $this->cooperative]);

        return $dataProvider;
    }
    
}
