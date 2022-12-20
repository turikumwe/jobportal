<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_candidate_test_result".
 *
 * @property int $id
 * @property int|null $test_id
 * @property int|null $assessment_id
 * @property int|null $testtaker_id
 * @property int|null $name
 * @property int|null $score
 * @property int $status
 * @property string $completed
 * @property string|null $content_type_name
 * @property string|null $custom_questions
 * @property string|null $algorithm
 * @property string|null $is_code_test
 * @property string|null $score_display
 * @property string|null $review
 * @property string|null $score_description
 * @property string|null $number_questions_completed
 *
 * @property ApiAssessment $assessment
 */
class ApiAssessmentCandidateTestResult extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_assessment_candidate_test_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['test_id', 'assessment_id', 'testtaker_id'], 'integer'],
            [['status', 'completed'], 'required'],
            [['completed', 'content_type_name', 'custom_questions', 'algorithm', 'is_code_test', 'score_display', 'review', 'score_description', 'number_questions_completed','name', 'score', 'status'], 'safe'],
            [['test_id', 'assessment_id', 'testtaker_id'], 'unique', 'targetAttribute' => ['test_id', 'assessment_id', 'testtaker_id']],
            [['assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessments::class, 'targetAttribute' => ['assessment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'test_id' => 'Test ID',
            'assessment_id' => 'Assessment ID',
            'testtaker_id' => 'Testtaker ID',
            'name' => 'Name',
            'score' => 'Score',
            'status' => 'Status',
            'completed' => 'Completed',
            'content_type_name' => 'Content Type Name',
            'custom_questions' => 'Custom Questions',
            'algorithm' => 'Algorithm',
            'is_code_test' => 'Is Code Test',
            'score_display' => 'Score Display',
            'review' => 'Review',
            'score_description' => 'Score Description',
            'number_questions_completed' => 'Number Questions Completed',
        ];
    }

    /**
     * Gets query for [[Assessment]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentQuery
     */
    public function getAssessment() {
        return $this->hasOne(ApiAssessment::class, ['id' => 'assessment_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateTestResultQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApiAssessmentCandidateTestResultQuery(get_called_class());
    }

}
