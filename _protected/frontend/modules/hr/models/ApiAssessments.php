<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $candidates
 * @property string|null $invited
 * @property string|null $started
 * @property string|null $finished
 * @property string|null $knocked_out
 * @property string|null $finished_percentage
 * @property string|null $content_type_name
 * @property string|null $status
 * @property string|null $created
 * @property string|null $modified
 * @property string|null $is_showing_hiring_feedback_survey
 * @property string|null $is_candidate_hired
 * @property string|null $is_highlighted
 * @property string|null $is_empty
 * @property string|null $video_at_end
 * @property string|null $pricing_state
 * @property string|null $has_consumed_credit
 * @property string|null $language
 *
 * @property ApiAssessmentDetails[] $apiAssessmentDetails
 * @property ApiAssessmentPublicLinks[] $apiAssessmentPublicLinks
 * @property ApiAssessmentTest[] $apiAssessmentTests
 */
class ApiAssessments extends \yii\db\ActiveRecord {

    const LANGUAGE_DICT = array('en' => 'English', 'fr' => 'French');

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_assessment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['name', 'candidates', 'invited', 'started', 'finished', 'knocked_out', 'finished_percentage', 'content_type_name', 'status', 'created', 'modified', 'is_showing_hiring_feedback_survey', 'is_candidate_hired', 'is_highlighted', 'is_empty', 'video_at_end', 'pricing_state', 'has_consumed_credit', 'language'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'candidates' => 'Candidates',
            'invited' => 'Invited',
            'started' => 'Started',
            'finished' => 'Finished',
            'knocked_out' => 'Knocked Out',
            'finished_percentage' => 'Finished Percentage',
            'content_type_name' => 'Content Type Name',
            'status' => 'Status',
            'created' => 'Created',
            'modified' => 'Modified',
            'is_showing_hiring_feedback_survey' => 'Is Showing Hiring Feedback Survey',
            'is_candidate_hired' => 'Is Candidate Hired',
            'is_highlighted' => 'Is Highlighted',
            'is_empty' => 'Is Empty',
            'video_at_end' => 'Video At End',
            'pricing_state' => 'Pricing State',
            'has_consumed_credit' => 'Has Consumed Credit',
            'language' => 'Language',
        ];
    }

    /**
     * Gets query for [[ApiAssessmentDetails]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentDetailsQuery
     */
    public function getApiAssessmentDetails() {
        return $this->hasMany(ApiAssessmentDetails::class, ['assessment_id' => 'id']);
    }

    /**
     * Gets query for [[ApiAssessmentPublicLinks]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentPublicLinksQuery
     */
    public function getApiAssessmentPublicLinks() {
        return $this->hasMany(ApiAssessmentPublicLinks::class, ['assessment_id' => 'id']);
    }

    /**
     * Gets query for [[ApiAssessmentTests]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentTestQuery
     */
    public function getApiAssessmentTests() {
        return $this->hasMany(ApiAssessmentTest::class, ['assessment_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentsQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApiAssessmentsQuery(get_called_class());
    }

    public static function get_assessment_duration($assessment_id) {
        if (($model = ApiAssessments::findOne(['id' => $assessment_id])) !== null) {
            if (isset($model->id)) {
                $assessment_tests = ApiAssessments::find()->select('api_assessment.*, api_assessment_test_test_list.duration as duration')
                                ->leftJoin('api_assessment_test', 'api_assessment_test.assessment_id = api_assessment.id')
                                ->leftJoin('api_assessment_test_test_list', 'api_assessment_test_test_list.test_id = api_assessment_test.id')
                                ->where(['api_assessment.id' => $model->id])->all();
                $total = 0;

                $assessment_tests = ApiAssessmentTest::find()->where(['assessment_id' => $model->id])->all();
                if (count($assessment_tests) > 0) {
                    $test_ids = array();
                    foreach ($assessment_tests as $test) {
                        array_push($test_ids, $test->id);
                    }
                    if (count($test_ids) > 0) {
                        $individual_tests = ApiAssessmentTestTestList::find()->where(['in', 'test_id', $test_ids])->all();
                        if (count($individual_tests) > 0) {

                            foreach ($individual_tests as $test) {
                                $total += intval($test->duration) / 60;
                            }
                        }
                    }
                }
                return $total;
            }
        } else {
            return 0;
        }
    }

    public static function getAssessmentTest($assessment_ids) {
        $assessment_tests_list = array();
        if (count($assessment_ids) > 0) {
            if (ApiAssessments::find()->where(['in', 'id', $assessment_ids])->count() > 0) {
                $assessment_tests = ApiAssessments::find()->select('api_assessment.*, api_assessment_test_test_list.duration as duration')
                                ->leftJoin('api_assessment_test', 'api_assessment_test.assessment_id = api_assessment.id')
                                ->leftJoin('api_assessment_test_test_list', 'api_assessment_test_test_list.test_id = api_assessment_test.id')
                                ->where(['in', 'api_assessment.id', $assessment_ids])->all();

                $all_assessment_tests = ApiAssessmentTest::find()->where(['in','assessment_id', $assessment_ids])->all();
                if (count($all_assessment_tests) > 0) {
                    $test_ids = array();
                    foreach ($all_assessment_tests as $test) {
                        array_push($test_ids, $test->id);
                    }
                    if (count($test_ids) > 0) {
                        $individual_tests = ApiAssessmentTestTestList::find()->where(['in', 'test_id', $test_ids])->all();
                        if (count($individual_tests) > 0) {

                            foreach ($individual_tests as $test) {
                                array_push($assessment_tests_list, $test->name);
                            }
                        }
                    }
                }
            }
        }
        return $assessment_tests_list;
    }

}
