<?php

namespace backend\modules\mediator\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MdManagers;

/**
 * MdManagersSearch represents the model behind the search form about `common\models\MdManagers`.
 */
class MdManagersSearch extends MdManagers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mediator_id', 'person_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = MdManagers::find();
        }else{
            $query = MdManagers::find()->deleted();
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
