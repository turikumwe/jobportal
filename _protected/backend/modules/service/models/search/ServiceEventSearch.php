<?php

namespace backend\modules\service\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceEvent;

/**
 * ServiceEventSearch represents the model behind the search form about `common\models\ServiceEvent`.
 */
class ServiceEventSearch extends ServiceEvent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'event_category_id', 'posted', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['event_title', 'event_summary', 'event_requirement', 'event_location', 'start_date', 'closure_date', 'how_to_apply', 'contact_phone', 'contact_email', 'action_id', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = ServiceEvent::find();
        }else{
            $query = ServiceEvent::find()->deleted();
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
            'event_category_id' => $this->event_category_id,
            'start_date' => $this->start_date,
            'closure_date' => $this->closure_date,
            'posted' => $this->posted,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
            ->andFilterWhere(['like', 'event_summary', $this->event_summary])
            ->andFilterWhere(['like', 'event_requirement', $this->event_requirement])
            ->andFilterWhere(['like', 'event_location', $this->event_location])
            ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
            ->andFilterWhere(['like', 'contact_email', $this->contact_email])
            ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }
}
