<?php

namespace frontend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsDrivingLicenseCategory;

/**
 * JsDrivingLicenseCategorySearch represents the model behind the search form about `common\models\JsDrivingLicenseCategory`.
 */
class JsDrivingLicenseCategorySearch extends JsDrivingLicenseCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'driving_license_id', 'license_category_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['issued_date', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
        $query = JsDrivingLicenseCategory::find();

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
            'driving_license_id' => $this->driving_license_id,
            'license_category_id' => $this->license_category_id,
            'issued_date' => $this->issued_date,
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
