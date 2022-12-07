<?php

namespace backend\modules\content\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ArticleUrl;

/**
 * ArticleUrlSearch represents the model behind the search form about `common\models\ArticleUrl`.
 */
class ArticleUrlSearch extends ArticleUrl
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'article_id', 'created_at', 'order'], 'integer'],
            [['url', 'name'], 'safe'],
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
        $query = ArticleUrl::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'article_id' => $this->article_id,
            'created_at' => $this->created_at,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
