<?php

namespace frontend\modules\mediator\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MdEmployees;

/**
 * MdEmployeesSearch represents the model behind the search form about `common\models\MdEmployees`.
 */
class MdEmployeesSearch extends MdEmployees {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'mediator_id', 'person_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = MdEmployees::find();

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
            'mediator_id' => $this->mediator_id,
            'person_id' => $this->person_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    public function searchByMediator($params, $mediator_id, $name = null) {
        $query = MdEmployees::find()->andWhere(['mediator_id' => $mediator_id]);
        if (isset($name)) {
            $query->leftJoin('common_person', 'common_person.id = md_employees.person_id');
            $query->andWhere(['like', 'CONCAT(common_person.last_name,common_person.last_name)', '%' . htmlspecialchars($name) . '%', false]);
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
            'mediator_id' => $this->mediator_id,
            'person_id' => $this->person_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
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
