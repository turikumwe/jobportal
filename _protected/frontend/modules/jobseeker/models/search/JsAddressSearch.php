<?php

namespace frontend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsAddress;
use common\models\UserProfile;

/**
 * JsAddressSearch represents the model behind the search form about `common\models\JsAddress`.
 */
class JsAddressSearch extends JsAddress {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'user_id', 'sector_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['emailAddress', 'phoneNumber', 'pobox', 'physicalAddress', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
        $query = JsAddress::find();

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
            'user_id' => $this->user_id,
            'sector_id' => $this->sector_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'emailAddress', $this->emailAddress])
                ->andFilterWhere(['like', 'phoneNumber', $this->phoneNumber])
                ->andFilterWhere(['like', 'pobox', $this->pobox])
                ->andFilterWhere(['like', 'physicalAddress', $this->physicalAddress]);

        return $dataProvider;
    }

    public function countdistrict($id) {

        return JsAddress::find()->where(['district_id' => $id])->count();
    }

    public function searchJobseekerReport($params) {
        $query = JsAddress::find()
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'sector_id' => $this->sector_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'emailAddress', $this->emailAddress])
                ->andFilterWhere(['like', 'phoneNumber', $this->phoneNumber])
                ->andFilterWhere(['like', 'pobox', $this->pobox])
                ->andFilterWhere(['like', 'physicalAddress', $this->physicalAddress]);

        return $dataProvider;
    }

    public function getJobSeekerFirstAddress($user_id) {
        return JsAddress::find()->where(['user_id' => $user_id])->one();
    }

}
