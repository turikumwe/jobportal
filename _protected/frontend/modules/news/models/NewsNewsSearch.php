<?php

namespace frontend\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NewsNews;

/**
 * NewsNewsSearch represents the model behind the search form about `common\models\NewsNews`.
 */
class NewsNewsSearch extends NewsNews {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'created_by', 'modified_by'], 'integer'],
            [['headline', 'link', 'source', 'publication_date', 'created_on', 'modified_on'], 'safe'],
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
    public function search($params, $title = null) {
        $query = NewsNews::find()->orderBy(['created_on' => SORT_DESC]);
        if (isset($title)) {
            $query->Where(['like', 'headline', '%' . htmlspecialchars($title) . '%', false]);
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
            'publication_date' => $this->publication_date,
            'created_by' => $this->created_by,
            'created_on' => $this->created_on,
            'modified_by' => $this->modified_by,
            'modified_on' => $this->modified_on,
        ]);

        $query->andFilterWhere(['like', 'headline', $this->headline])
                ->andFilterWhere(['like', 'link', $this->link])
                ->andFilterWhere(['like', 'source', $this->source]);

        return $dataProvider;
    }

    public function searchPublished($params) {
        $query = NewsNews::find()->orderBy(['created_on' => SORT_DESC]);

        $query->Where(['action_id' => \backend\models\SActions::ACTION_STATUS_PUBLISHED]);

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
            'publication_date' => $this->publication_date,
            'created_by' => $this->created_by,
            'created_on' => $this->created_on,
            'modified_by' => $this->modified_by,
            'modified_on' => $this->modified_on,
        ]);

        $query->andFilterWhere(['like', 'headline', $this->headline])
                ->andFilterWhere(['like', 'link', $this->link])
                ->andFilterWhere(['like', 'source', $this->source]);

        return $dataProvider;
    }

}
