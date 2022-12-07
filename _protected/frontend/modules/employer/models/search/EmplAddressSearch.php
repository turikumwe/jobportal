<?php

namespace frontend\modules\employer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmplAddress;

/**
 * EmplAddressSearch represents the model behind the search form about `common\models\EmplAddress`.
 */
class EmplAddressSearch extends EmplAddress
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'employer_id', 'geo_sector_id','district_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['email_address', 'phone_number', 'pobox', 'website', 'physical_address', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
        $query = EmplAddress::find();

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
            'id'            => $this->id,
            'employer_id'   => $this->employer_id,
            'geo_sector_id' => $this->geo_sector_id,
            'district_id'   => $this->district_id,
            'created_by'    => $this->created_by,
            'created_at'    => $this->created_at,
            'deleted_by'    => $this->deleted_by,
            'deleted_at'    => $this->deleted_at,
            'updated_by'    => $this->updated_by,
            'updated_at'    => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'pobox', $this->pobox])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address]);

        return $dataProvider;
    }

    public function searchEmployersReport($params)
    {
        $query = EmplAddress::find()
                ->groupBy('district_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 35],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'            => $this->id,
            'employer_id'   => $this->employer_id,
            'geo_sector_id' => $this->geo_sector_id,
            'district_id'   => $this->district_id,
            'created_by'    => $this->created_by,
            'created_at'    => $this->created_at,
            'deleted_by'    => $this->deleted_by,
            'deleted_at'    => $this->deleted_at,
            'updated_by'    => $this->updated_by,
            'updated_at'    => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'pobox', $this->pobox])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address]);

        return $dataProvider;
    }
}
