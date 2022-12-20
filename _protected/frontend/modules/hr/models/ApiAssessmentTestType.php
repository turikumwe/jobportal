<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_test_type".
 *
 * @property int $id
 * @property int|null $test_list_id
 * @property string|null $name
 * @property string|null $visible
 *
 * @property ApiAssessmentTest $test
 */
class ApiAssessmentTestType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api_assessment_test_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'test_list_id'], 'integer'],
            [['name', 'visible'], 'safe'],
            [['id'], 'unique'],
            [['test_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessmentTest::class, 'targetAttribute' => ['test_list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_list_id' => 'Test ID',
            'name' => 'Name',
            'visible' => 'Visible',
        ];
    }

    /**
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentTestQuery
     */
    public function getTest()
    {
        return $this->hasOne(ApiAssessmentTestTestList::class, ['id' => 'test_list_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiAssessmentTestTypeQuery(get_called_class());
    }
}
