<?php

namespace backend\modules\employer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmplEconomicSector;

/**
 * EmplEconomicSectorSearch represents the model behind the search form about `common\models\EmplEconomicSector`.
 */
class EmplEconomicSectorSearch extends EmplEconomicSector
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'employer_id', 'economic_sector_id', 'main_economic_sector_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['start_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = EmplEconomicSector::find();
        }else{
            $query = EmplEconomicSector::find()->deleted();
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
            'employer_id' => $this->employer_id,
            'economic_sector_id' => $this->economic_sector_id,
            'main_economic_sector_id' => $this->main_economic_sector_id,
            'start_date' => $this->start_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
