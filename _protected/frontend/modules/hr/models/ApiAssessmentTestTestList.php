<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_test_test_list".
 *
 * @property int $id
 * @property int $test_id
 * @property string|null $status
 * @property string|null $name
 * @property string|null $duration
 * @property string|null $content_type_name
 * @property string|null $custom_questions
 * @property string|null $algorithm
 * @property string|null $is_premium
 * @property string|null $is_private_test
 * @property string|null $num_preview_questions
 *
 * @property ApiAssessmentTest $test
 */
class ApiAssessmentTestTestList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api_assessment_test_test_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'test_id'], 'required'],
            [['id', 'test_id'], 'integer'],
            [['status', 'name', 'duration', 'content_type_name', 'custom_questions', 'algorithm', 'is_premium', 'is_private_test', 'num_preview_questions'], 'safe'],
            [['id'], 'unique'],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessmentTest::class, 'targetAttribute' => ['test_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_id' => 'Test ID',
            'status' => 'Status',
            'name' => 'Name',
            'duration' => 'Duration',
            'content_type_name' => 'Content Type Name',
            'custom_questions' => 'Custom Questions',
            'algorithm' => 'Algorithm',
            'is_premium' => 'Is Premium',
            'is_private_test' => 'Is Private Test',
            'num_preview_questions' => 'Num Preview Questions',
        ];
    }

    /**
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentTestQuery
     */
    public function getTest()
    {
        return $this->hasOne(ApiAssessmentTest::class, ['id' => 'test_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentTestTestListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiAssessmentTestTestListQuery(get_called_class());
    }
}
