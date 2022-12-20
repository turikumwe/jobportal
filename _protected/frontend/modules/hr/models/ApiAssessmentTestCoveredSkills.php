<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_test_covered_skills".
 *
 * @property int $id
 * @property int|null $test_list_id
 * @property string|null $description
 * @property string|null $preview
 * @property string|null $question_count
 *
 * @property ApiAssessmentTest $test
 */
class ApiAssessmentTestCoveredSkills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api_assessment_test_covered_skills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'test_list_id'], 'integer'],
            [['description', 'preview', 'question_count'], 'safe'],
            [['id'], 'unique'],
            [['test_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessmentTestTestList::class, 'targetAttribute' => ['test_list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_list_id' => 'Test  list ID',
            'description' => 'Description',
            'preview' => 'Preview',
            'question_count' => 'Question Count',
        ];
    }

    /**
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentTestQuery
     */
    public function getTest()
    {
        return $this->hasOne(ApiAssessmentTest::class, ['id' => 'test_list_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestCoveredSkillsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiAssessmentTestCoveredSkillsQuery(get_called_class());
    }
}
