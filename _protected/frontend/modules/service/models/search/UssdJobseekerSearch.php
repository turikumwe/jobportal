<?php

namespace frontend\modules\service\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UssdJobseeker;

/**
 * UssdJobseekerSearch represents the model behind the search form about `common\models\UssdJobseeker`.
 */
class UssdJobseekerSearch extends UssdJobseeker
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nid', 'names', 'dob', 'domain', 'district', 'education_level', 'telephone'], 'safe'],
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
        $query = UssdJobseeker::find();

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
            'dob' => $this->dob,
        ]);

        $query->andFilterWhere(['like', 'nid', $this->nid])
            ->andFilterWhere(['like', 'names', $this->names])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'education_level', $this->education_level])
            ->andFilterWhere(['like', 'telephone', $this->telephone]);

        return $dataProvider;
    }
}
