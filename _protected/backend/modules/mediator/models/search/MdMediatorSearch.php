<?php

namespace backend\modules\mediator\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MdMediator;

/**
 * MdMediatorSearch represents the model behind the search form about `common\models\MdMediator`.
 */
class MdMediatorSearch extends MdMediator
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'registration_authority_id', 'mediator_type_id', 'ownership_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['registration_number', 'madiator_name', 'opening_date', 'show_address', 'show_manager', 'show_employee', 'mediator_status','created_at', 'deleted_at', 'updated_at'], 'safe'],
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
        $query = MdMediator::find();

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
            'registration_authority_id' => $this->registration_authority_id,
            'mediator_type_id' => $this->mediator_type_id,
            'opening_date' => $this->opening_date,
            'ownership_id' => $this->ownership_id,
            'mediator_status' => $this->mediator_status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number])
            ->andFilterWhere(['like', 'madiator_name', $this->madiator_name])
            ->andFilterWhere(['like', 'show_address', $this->show_address])
            ->andFilterWhere(['like', 'show_manager', $this->show_manager])
            ->andFilterWhere(['like', 'show_employee', $this->show_employee]);

        return $dataProvider;
    }
}
