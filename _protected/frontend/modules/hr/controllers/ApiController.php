<?php

namespace frontend\modules\hr\controllers;

use frontend\modules\hr\models\ApiAssessments;
use frontend\modules\hr\models\ApiAssessmentCandidate;
use frontend\modules\hr\models\ApiAssessmentCandidateDetails;
use frontend\modules\hr\models\ApiAssessmentDetails;
use frontend\modules\hr\models\ApiAssessmentPublicLinks;
use frontend\modules\hr\models\ApiAssessmentTest;
use frontend\modules\hr\models\ApiAssessmentTestCoveredSkills;
use frontend\modules\hr\models\ApiAssessmentCandidateTestResult;
use frontend\modules\hr\models\ApiAssessmentTestTestList;
use frontend\modules\hr\models\ApiAssessmentTestType;
use frontend\modules\hr\models\search\ApiAssessmentCandidateSearch;
use frontend\modules\hr\models\search\ApiAssessmentsSearch;
use frontend\modules\jobseeker\models\search\UserProfileSearch;
use frontend\modules\hr\models\ApiSyncing;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * AssessmentsController implements the CRUD actions for ApiAssessments model.
 */
class ApiController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                ]
        );
    }

    public function actionSyncAssessments() {

        $url = 'https://app.testgorilla.com/api/assessments?limit=10000';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $result_array = json_decode($response, true);

        $conn = \Yii::$app->db;
        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Assessment sychrinization','" . str_replace("'", " ", $response) . "')";
        $conn->CreateCommand($query)->execute();

        $sync_assessment_query = "update api_syncing set sync_started = now(), is_syncing = 1 where object_name = 'assessment'";
        $conn->CreateCommand($sync_assessment_query)->execute();
        $conn->CreateCommand($sync_assessment_query)->execute();

        if (count($result_array['results']) > 0) {
            foreach ($result_array['results'] as $key => $assessment_data) {
                //Save the assessement
                $assessment = ApiAssessments::find()->where(['id' => $assessment_data['id']])->one();

                if (!isset($assessment->id)) {
                    $assessment = new ApiAssessments();
                }
                //Save the assessement
                $assessment->id = $assessment_data['id'];
                $assessment->name = $assessment_data['name'];
                $assessment->candidates = $assessment_data['candidates'];
                $assessment->invited = $assessment_data['invited'];
                $assessment->started = $assessment_data['started'];
                $assessment->finished = $assessment_data['finished'];
                $assessment->knocked_out = $assessment_data['knocked_out'];
                $assessment->finished_percentage = $assessment_data['finished_percentage'];
                $assessment->content_type_name = $assessment_data['content_type_name'];
                $assessment->status = $assessment_data['status'];
                $assessment->created = $assessment_data['created'];
                $assessment->modified = $assessment_data['modified'];
                $assessment->is_showing_hiring_feedback_survey = $assessment_data['is_showing_hiring_feedback_survey'];
                $assessment->is_candidate_hired = $assessment_data['is_candidate_hired'];
                $assessment->is_highlighted = $assessment_data['is_highlighted'];
                $assessment->is_empty = $assessment_data['is_empty'];
                $assessment->video_at_end = $assessment_data['video_at_end'];
                $assessment->pricing_state = $assessment_data['pricing_state'];
                $assessment->has_consumed_credit = $assessment_data['has_consumed_credit'];
                $assessment->language = $assessment_data['language'];

                if (!$assessment->save()) {
                    error_log("Assessment creation error");
                    error_log(json_encode($assessment->errors));
                }
            }
            $sync_assessment_update = "update api_syncing set sync_ended = now(), is_syncing = 0 where object_name = 'assessment'";
            $conn->CreateCommand($sync_assessment_update)->execute();
            $conn->CreateCommand($sync_assessment_update)->execute();
        }
    }

    public function actionSyncAssessmentDetails($id) {

        Yii::$app->db->schema->refresh();
        $url = 'https://app.testgorilla.com/api/assessments/' . $id;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);
        $conn = \Yii::$app->db;
        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Assessment details sychrinization','" . str_replace("'", " ", $response) . "')";
        $conn->CreateCommand($query)->execute();

        //Cehck if this assessment was ever synchronized
        $assessment_synchronization = ApiSyncing::find()->where(['object_name' => ApiSyncing::OBJECT_NAME_ASSESSMENT_DETAILS])->andWhere(['assessment_id' => $id])->one();
        if (isset($assessment_synchronization->id)) {
            //Update
            $assessment_synchronization->sync_started = date("Y-m-d H:i:s");
            $assessment_synchronization->is_syncing = 1;
            $assessment_synchronization->save();
        } else {
            //Create new
            $assessment_synchronization = new ApiSyncing();
            $assessment_synchronization->object_name = ApiSyncing::OBJECT_NAME_ASSESSMENT_DETAILS;
            $assessment_synchronization->assessment_id = $id;
            $assessment_synchronization->sync_started = date("Y-m-d H:i:s");
            $assessment_synchronization->is_syncing = 1;
            if (!$assessment_synchronization->save()) {
                var_dump($assessment_synchronization->errors);
            }
        }
        $assessment_details_data = json_decode($response, true);

        $current_assessment = ApiAssessments::find()->where(['id' => $id])->one();
        if (count($assessment_details_data) > 0 && isset($current_assessment->id)) {
            //Save the assessement
            $assessment_details = ApiAssessmentDetails::find()->where(['id' => $assessment_details_data['id']])->one();

            if (!isset($assessment_details->id)) {
                $assessment_details = new ApiAssessmentDetails();
            }
            $assessment_details->assessment_id = $id;
            $assessment_details->id = $current_assessment->id;
            $assessment_details->name = isset($assessment_details_data['name']) ? $assessment_details_data['name'] : null;
            $assessment_details->job_role = isset($assessment_details_data['job_role']) ? $assessment_details_data['job_role'] : null;
            $assessment_details->other_job_role = isset($assessment_details_data['other_job_role']) ? $assessment_details_data['other_job_role'] : null;
            $assessment_details->owner = isset($assessment_details_data['owner']) ? $assessment_details_data['owner'] : null;
            $assessment_details->benchmark = isset($assessment_details_data['benchmark']) ? $assessment_details_data['benchmark'] : null;
            $assessment_details->benchmark_name = isset($assessment_details_data['benchmark_name']) ? $assessment_details_data['benchmark_name'] : null;
            $assessment_details->invited = isset($assessment_details_data['invited']) ? $assessment_details_data['invited'] : null;
            $assessment_details->started = isset($assessment_details_data['started']) ? $assessment_details_data['started'] : null;
            $assessment_details->finished = isset($assessment_details_data['finished']) ? $assessment_details_data['finished'] : null;
            $assessment_details->knocked_out = isset($assessment_details_data['knocked_out']) ? $assessment_details_data['knocked_out'] : null;
            $assessment_details->content_type_name = isset($assessment_details_data['content_type_name']) ? $assessment_details_data['content_type_name'] : null;
            $assessment_details->status = isset($assessment_details_data['status']) ? $assessment_details_data['status'] : null;
            $assessment_details->modified = isset($assessment_details_data['modified']) ? $assessment_details_data['modified'] : null;
            $assessment_details->is_showing_hiring_feedback_survey = isset($assessment_details_data['is_showing_hiring_feedback_survey']) ? $assessment_details_data['is_showing_hiring_feedback_survey'] : null;
            $assessment_details->is_candidate_hired = isset($assessment_details_data['is_candidate_hired']) ? $assessment_details_data['is_candidate_hired'] : null;
            $assessment_details->reason_for_not_fill_hiring_feedback = isset($assessment_details_data['reason_for_not_fill_hiring_feedback']) ? $assessment_details_data['reason_for_not_fill_hiring_feedback'] : null;
            $assessment_details->is_highlighted = isset($assessment_details_data['is_highlighted']) ? $assessment_details_data['is_highlighted'] : null;
            $assessment_details->has_culture_fit = isset($assessment_details_data['has_culture_fit']) ? $assessment_details_data['has_culture_fit'] : null;
            $assessment_details->candidates_source = isset($assessment_details_data['candidates_source']) ? $assessment_details_data['candidates_source'] : null;
            $assessment_details->video_id = isset($assessment_details_data['video_id']) ? $assessment_details_data['video_id'] : null;
            $assessment_details->video_at_end = isset($assessment_details_data['video_at_end']) ? $assessment_details_data['video_at_end'] : null;
            $assessment_details->use_snapshots = isset($assessment_details_data['use_snapshots']) ? $assessment_details_data['use_snapshots'] : null;
            $assessment_details->date_of_expiry = isset($assessment_details_data['date_of_expiry']) ? $assessment_details_data['date_of_expiry'] : null;
            $assessment_details->assessment_extra_time = isset($assessment_details_data['assessment_extra_time']) ? $assessment_details_data['assessment_extra_time'] : null;
            $assessment_details->pricing_state = isset($assessment_details_data['pricing_state']) ? $assessment_details_data['pricing_state'] : null;
            $assessment_details->has_consumed_credit = isset($assessment_details_data['has_consumed_credit']) ? $assessment_details_data['has_consumed_credit'] : null;
            $assessment_details->permitted_extra_time_non_native_speakers = isset($assessment_details_data['permitted_extra_time_non_native_speakers']) ? $assessment_details_data['permitted_extra_time_non_native_speakers'] : null;
            $assessment_details->permitted_extra_time_person_for_other_capacities = isset($assessment_details_data['permitted_extra_time_person_for_other_capacities']) ? $assessment_details_data['permitted_extra_time_person_for_other_capacities'] : null;
            $assessment_details->language = isset($assessment_details_data['language']) ? $assessment_details_data['language'] : null;
            $assessment_details->template_id = isset($assessment_details_data['template_id']) ? $assessment_details_data['template_id'] : null;

            if ($assessment_details->save()) {
                //Save the public links
                $public_links = $assessment_details_data['public_links'];
                if (count($public_links) > 0) {
                    foreach ($public_links as $public_link_data) {
                        //Save the public link
                        $public_link = ApiAssessmentPublicLinks::find()->where(['id' => $public_link_data['id']])->one();

                        if (!isset($public_link->id)) {
                            $public_link = new ApiAssessmentPublicLinks();
                        }
                        $public_link->assessment_id = $current_assessment->id;
                        $public_link->id = $public_link_data['id'];
                        $public_link->label = $public_link_data['label'];
                        $public_link->public_uuid = $public_link_data['public_uuid'];
                        $public_link->assessment = $public_link_data['assessment'];
                        $public_link->active = $public_link_data['active'];
                        $public_link->candidates_limit = $public_link_data['candidates_limit'];
                        $public_link->candidates_count = $public_link_data['candidates_count'];
                        $public_link->invitation_link = $public_link_data['invitation_link'];
                        $public_link->short_invitation_link = $public_link_data['short_invitation_link'];
                    }
                    if (!$public_link->save()) {
                        var_dump($public_link->errors);
                        die;
                    }
                }

                $tests_details = $assessment_details_data['tests_detail'];
                if (count($tests_details) > 0) {
                    foreach ($tests_details as $tests_detail) {
                        //Save the test details
                        $test_detail = ApiAssessmentTest::find()->where(['id' => $tests_detail['id']])->one();

                        if (!isset($test_detail->id)) {
                            $test_detail = new ApiAssessmentTest();
                            $test_detail->id = $tests_detail['id'];
                        }
                        $test_detail->assessment_id = $current_assessment->id;
                        $test_detail->ordering = $tests_detail['order'];
                        if ($test_detail->save()) {
                            //Save the test
                            $test_list_data = $tests_detail['test'];
                            $test_list = ApiAssessmentTestTestList::find()->where(['id' => $test_list_data['id']])->one();
                            if (!isset($test_list->id)) {
                                $test_list = new ApiAssessmentTestTestList();
                            }
                            $test_list->test_id = $test_detail->id;
                            $test_list->id = $test_list_data['id'];
                            $test_list->status = $test_list_data['status'];
                            $test_list->name = $test_list_data['name'];
                            $test_list->duration = $test_list_data['duration'];
                            $test_list->content_type_name = $test_list_data['content_type_name'];
                            $test_list->custom_questions = json_encode($test_list_data['custom_questions']);
                            $test_list->algorithm = $test_list_data['algorithm'];
                            $test_list->is_premium = $test_list_data['is_premium'];
                            $test_list->is_private_test = $test_list_data['is_private_test'];
                            $test_list->num_preview_questions = $test_list_data['num_preview_questions'];

                            if ($test_list->save()) {
                                //Save the types and the covered skills
                                $test_types = $test_list_data['type'];

                                if (count($test_types) > 0) {
                                    foreach ($test_types as $test_type) {
                                        $current_test_type = ApiAssessmentTestType::find()->where(['id' => $test_type['id']])->one();
                                        if (!isset($current_test_type->id)) {
                                            $current_test_type = new ApiAssessmentTestType();
                                        }
                                        $current_test_type->id = $test_type['id'];
                                        $current_test_type->test_list_id = $test_list->id;
                                        $current_test_type->name = $test_type['name'];
                                        $current_test_type->visible = $test_type['visible'];

                                        if (!$current_test_type->save(false)) {
                                            var_dump($current_test_type->errors);
                                            die;
                                        }
                                    }
                                }

                                $test_covered_skills = $test_list_data['covered_skills'];
                                if (count($test_covered_skills) > 0) {
                                    foreach ($test_covered_skills as $covered_skill) {
                                        $current_covered_skill = ApiAssessmentTestCoveredSkills::find()->where(['id' => $covered_skill['id']])->one();
                                        if (!isset($current_covered_skill->id)) {
                                            $current_covered_skill = new ApiAssessmentTestCoveredSkills();
                                        }
                                        $current_covered_skill->id = $covered_skill['id'];
                                        $current_covered_skill->test_list_id = $test_list->id;
                                        $current_covered_skill->description = $covered_skill['description'];
                                        $current_covered_skill->preview = $covered_skill['preview'];
                                        $current_covered_skill->question_count = $covered_skill['question_count'];

                                        if (!$current_covered_skill->save(false)) {
                                            var_dump($current_covered_skill->errors);
                                            die;
                                        } else {

                                            $assessment_synchronization->sync_ended = date("Y-m-d H:i:s");
                                            $assessment_synchronization->is_syncing = 0;
                                            $assessment_synchronization->save();

                                            //Call the candidate synchronization action
                                            return $this->redirect(Yii::getAlias('@FullfrontendUrl') . '/hr/api/sync-assessment-candidates?id=' . $current_assessment->id);
                                        }
                                    }
                                }
                            } else {
                                var_dump($test_list->errors);
                                die;
                            }
                        } else {
                            var_dump($test_detail->errors);
                            die;
                        }
                    }
                }
            } else {
                var_dump($assessment_details->errors);
                die;
            }
        }
    }

    public function actionInviteCandidates($id) {

        $url = 'https://app.testgorilla.com/api/assessments/' . $id . '/invite_candidate/';

        $data = array(
            'email' => 'jp@bluhub.rw',
            'first_name' => 'Jean Paul',
            'last_name' => 'Turikumwe');

        $body = json_encode($data);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        print_r($result);
        exit();
    }

    public function actionSendBulkInvitation($id) {
        $selected_assessment = ApiAssessments::find()->where(['id' => $id])->one();
        if (!isset($selected_assessment->id)) {
            return "Assessment not found";
        }
        //Load all user who are not invited
        $assessment_candidates = ApiAssessmentCandidate::find()->where(['assessment_id' => $selected_assessment->id])->andWhere(['testtaker_id' => null])->all();
        if (count($assessment_candidates) > 0) {
            foreach ($assessment_candidates as $canidate) {
                //Invite candidates
                $url = 'https://app.testgorilla.com/api/assessments/' . $id . '/invite_candidate/';
                $candidate_user = \common\models\UserProfile::find()->where(['user_id' => $canidate->user_id])->one();
                $data = array(
                    'email' => $canidate->email,
                    'first_name' => $candidate_user->firstname,
                    'last_name' => $candidate_user->lastname
                );

                $body = json_encode($data);
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                $response_data = json_decode($response, true);

                $conn = \Yii::$app->db;

                $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','" . $body . "','" . str_replace("'", " ", $response) . "')";
                $conn->CreateCommand($query)->execute();

                curl_close($ch);

                //Update the current candidates information
                $candidate = ApiAssessmentCandidate::find()->where(['email' => $canidate->email])->andWhere(['assessment_id' => $selected_assessment->id])->one();

                $candidate->candidate_id = isset($response_data['id']) ? $response_data['id'] : null;
                $candidate->assessment_id = $selected_assessment->id;
                $candidate->invitation_uuid = isset($response_data['invitation_uuid']) ? $response_data['invitation_uuid'] : null;
                $candidate->created = isset($response_data['created']) ? $response_data['created'] : null;
                $candidate->testtaker_id = isset($response_data['testtaker_id']) ? $response_data['testtaker_id'] : null;
                $candidate->status = isset($response_data['status']) ? $response_data['status'] : null;
                $candidate->average = isset($response_data['average']) ? $response_data['average'] : null;
                $candidate->is_with_feedback_about_hired = isset($response_data['is_with_feedback_about_hired']) ? $response_data['is_with_feedback_about_hired'] : null;
                $candidate->reminder_sent = isset($response_data['reminder_sent']) ? $response_data['reminder_sent'] : null;
                $candidate->last_reminder_sent = isset($response_data['last_reminder_sent']) ? $response_data['last_reminder_sent'] : null;
                $candidate->content_type_name = isset($response_data['content_type_name']) ? $response_data['content_type_name'] : null;
                $candidate->is_hired = isset($response_data['is_hired']) ? $response_data['is_hired'] : null;
                $candidate->personality = isset($response_data['personality']) ? $response_data['personality'] : null;
                $candidate->personality_algorithm = isset($response_data['personality_algorithm']) ? $response_data['personality_algorithm'] : null;
                $candidate->greenhouse_profile_url = isset($response_data['greenhouse_profile_url']) ? $response_data['greenhouse_profile_url'] : null;
                $candidate->stage = isset($response_data['stage']) ? $response_data['stage'] : null;
                $candidate->status_notification = isset($response_data['status_notification']) ? $response_data['status_notification'] : null;
                $candidate->modified = isset($response_data['modified']) ? $response_data['modified'] : null;
                $candidate->last_activity = isset($response_data['last_activity']) ? $response_data['last_activity'] : null;
                $candidate->rating = isset($response_data['rating']) ? $response_data['rating'] : null;
                $candidate->has_consumed_credit = isset($response_data['has_consumed_credit']) ? $response_data['has_consumed_credit'] : null;
                $candidate->review = isset($response_data['review']) ? $response_data['review'] : null;
                $candidate->results_sent = isset($response_data['results_sent']) ? $response_data['results_sent'] : null;
                $candidate->invitation_link = isset($response_data['invitation_link']) ? $response_data['invitation_link'] : null;
                $candidate->role = isset($response_data['role']) ? $response_data['role'] : null;

                $candidate->save();
            }
        }
    }
    public function actionSendBulkInvitationForAllAssessments() {
        
        //Load all user who are not invited
        $assessment_candidates = ApiAssessmentCandidate::find()->where(['testtaker_id' => null])->all();
        if (count($assessment_candidates) > 0) {
            foreach ($assessment_candidates as $canidate) {
                //Invite candidates
                $url = 'https://app.testgorilla.com/api/assessments/' . $canidate->assessment_id . '/invite_candidate/';
                $candidate_user = \common\models\UserProfile::find()->where(['user_id' => $canidate->user_id])->one();
                $data = array(
                    'email' => $canidate->email,
                    'first_name' => $candidate_user->firstname,
                    'last_name' => $candidate_user->lastname
                );

                $body = json_encode($data);
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                $response_data = json_decode($response, true);

                $conn = \Yii::$app->db;

                $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','" . $body . "','" . str_replace("'", " ", $response) . "')";
                $conn->CreateCommand($query)->execute();

                curl_close($ch);

                //Update the current candidates information
                $candidate = ApiAssessmentCandidate::find()->where(['email' => $canidate->email])->andWhere(['assessment_id' => $canidate->assessment_id])->one();

                $candidate->candidate_id = isset($response_data['id']) ? $response_data['id'] : null;
                $candidate->assessment_id = $canidate->assessment_id;
                $candidate->invitation_uuid = isset($response_data['invitation_uuid']) ? $response_data['invitation_uuid'] : null;
                $candidate->created = isset($response_data['created']) ? $response_data['created'] : null;
                $candidate->testtaker_id = isset($response_data['testtaker_id']) ? $response_data['testtaker_id'] : null;
                $candidate->status = isset($response_data['status']) ? $response_data['status'] : null;
                $candidate->average = isset($response_data['average']) ? $response_data['average'] : null;
                $candidate->is_with_feedback_about_hired = isset($response_data['is_with_feedback_about_hired']) ? $response_data['is_with_feedback_about_hired'] : null;
                $candidate->reminder_sent = isset($response_data['reminder_sent']) ? $response_data['reminder_sent'] : null;
                $candidate->last_reminder_sent = isset($response_data['last_reminder_sent']) ? $response_data['last_reminder_sent'] : null;
                $candidate->content_type_name = isset($response_data['content_type_name']) ? $response_data['content_type_name'] : null;
                $candidate->is_hired = isset($response_data['is_hired']) ? $response_data['is_hired'] : null;
                $candidate->personality = isset($response_data['personality']) ? $response_data['personality'] : null;
                $candidate->personality_algorithm = isset($response_data['personality_algorithm']) ? $response_data['personality_algorithm'] : null;
                $candidate->greenhouse_profile_url = isset($response_data['greenhouse_profile_url']) ? $response_data['greenhouse_profile_url'] : null;
                $candidate->stage = isset($response_data['stage']) ? $response_data['stage'] : null;
                $candidate->status_notification = isset($response_data['status_notification']) ? $response_data['status_notification'] : null;
                $candidate->modified = isset($response_data['modified']) ? $response_data['modified'] : null;
                $candidate->last_activity = isset($response_data['last_activity']) ? $response_data['last_activity'] : null;
                $candidate->rating = isset($response_data['rating']) ? $response_data['rating'] : null;
                $candidate->has_consumed_credit = isset($response_data['has_consumed_credit']) ? $response_data['has_consumed_credit'] : null;
                $candidate->review = isset($response_data['review']) ? $response_data['review'] : null;
                $candidate->results_sent = isset($response_data['results_sent']) ? $response_data['results_sent'] : null;
                $candidate->invitation_link = isset($response_data['invitation_link']) ? $response_data['invitation_link'] : null;
                $candidate->role = isset($response_data['role']) ? $response_data['role'] : null;

                $candidate->save();
            }
        }
    }

    public function actionSyncAssessmentCandidates($id) {
        $selected_assessment = ApiAssessments::find()->where(['id' => $id])->one();
        if (!isset($selected_assessment->id)) {
            return "Assessment not found";
        }
        //Invited candidates
        $url = 'https://app.testgorilla.com/api/assessments/candidature/?assessment=' . $id . '&limit=100000';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        curl_close($ch);

        $conn = \Yii::$app->db;

        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Getting assessment candidates','" . str_replace("'", " ", $response) . "')";
        $conn->CreateCommand($query)->execute();

        if (count($response_data['results']) > 0) {
            $candidate_counter = 0;
            foreach ($response_data['results'] as $candidate_data) {
                //Update the current candidates information
                $candidate = ApiAssessmentCandidate::find()->where(['email' => $candidate_data['email']])->andWhere(['assessment_id' => $selected_assessment->id])->one();
                echo $candidate_data['email'] . ' - ' . $selected_assessment->id . '<br />';
                if (isset($candidate->id)) {

                    $candidate->candidate_id = $candidate_data['id'];
                    $candidate->assessment_id = $selected_assessment->id;
                    $candidate->invitation_uuid = isset($candidate_data['invitation_uuid']) ? $candidate_data['invitation_uuid'] : null;
                    $candidate->created = isset($candidate_data['created']) ? $candidate_data['created'] : null;
                    $candidate->testtaker_id = isset($candidate_data['testtaker_id']) ? $candidate_data['testtaker_id'] : null;
                    $candidate->status = isset($candidate_data['status']) ? $candidate_data['status'] : null;
                    $candidate->average = isset($candidate_data['average']) ? $candidate_data['average'] : null;
                    $candidate->is_with_feedback_about_hired = isset($candidate_data['is_with_feedback_about_hired']) ? $candidate_data['is_with_feedback_about_hired'] : null;
                    $candidate->reminder_sent = isset($candidate_data['reminder_sent']) ? $candidate_data['reminder_sent'] : null;
                    $candidate->last_reminder_sent = isset($candidate_data['last_reminder_sent']) ? $candidate_data['last_reminder_sent'] : null;
                    $candidate->content_type_name = isset($candidate_data['content_type_name']) ? $candidate_data['content_type_name'] : null;
                    $candidate->is_hired = isset($candidate_data['is_hired']) ? $candidate_data['is_hired'] : null;
                    $candidate->personality = isset($candidate_data['personality']) ? $candidate_data['personality'] : null;
                    $candidate->personality_algorithm = isset($candidate_data['personality_algorithm']) ? $candidate_data['personality_algorithm'] : null;
                    $candidate->greenhouse_profile_url = isset($candidate_data['greenhouse_profile_url']) ? $candidate_data['greenhouse_profile_url'] : null;
                    $candidate->stage = isset($candidate_data['stage']) ? $candidate_data['stage'] : null;
                    $candidate->status_notification = isset($candidate_data['status_notification']) ? $candidate_data['status_notification'] : null;
                    $candidate->modified = isset($candidate_data['modified']) ? $candidate_data['modified'] : null;
                    $candidate->last_activity = isset($candidate_data['last_activity']) ? $candidate_data['last_activity'] : null;
                    $candidate->rating = isset($candidate_data['rating']) ? $candidate_data['rating'] : null;
                    $candidate->has_consumed_credit = isset($candidate_data['has_consumed_credit']) ? $candidate_data['has_consumed_credit'] : null;
                    $candidate->review = isset($candidate_data['review']) ? $candidate_data['review'] : null;
                    $candidate->results_sent = isset($candidate_data['results_sent']) ? $candidate_data['results_sent'] : null;
                    $candidate->invitation_link = isset($candidate_data['invitation_link']) ? $candidate_data['invitation_link'] : null;
                    $candidate->role = isset($candidate_data['role']) ? $candidate_data['role'] : null;
                    if ($candidate->save()) {
                        $candidate_counter++;
                    }
                } else {
                    //Try to check if the user exists
                    $user = \common\models\User::find()->where(['email' => $candidate_data['email']])->one();
                    if (isset($user->id)) {
                        $candidate = new ApiAssessmentCandidate();
                        $candidate->user_id = $user->id;
                        $candidate->candidate_id = $candidate_data['id'];
                        $candidate->assessment_id = $selected_assessment->id;

                        $candidate->email = isset($candidate_data['email']) ? $candidate_data['email'] : null;
                        $candidate->full_name = isset($candidate_data['full_name']) ? $candidate_data['full_name'] : null;
                        $candidate->invitation_uuid = isset($candidate_data['invitation_uuid']) ? $candidate_data['invitation_uuid'] : null;
                        $candidate->created = isset($candidate_data['created']) ? $candidate_data['created'] : null;
                        $candidate->testtaker_id = isset($candidate_data['testtaker_id']) ? $candidate_data['testtaker_id'] : null;
                        $candidate->status = isset($candidate_data['status']) ? $candidate_data['status'] : null;
                        $candidate->average = isset($candidate_data['average']) ? $candidate_data['average'] : null;
                        $candidate->is_with_feedback_about_hired = isset($candidate_data['is_with_feedback_about_hired']) ? $candidate_data['is_with_feedback_about_hired'] : null;
                        $candidate->reminder_sent = isset($candidate_data['reminder_sent']) ? $candidate_data['reminder_sent'] : null;
                        $candidate->last_reminder_sent = isset($candidate_data['last_reminder_sent']) ? $candidate_data['last_reminder_sent'] : null;
                        $candidate->content_type_name = isset($candidate_data['content_type_name']) ? $candidate_data['content_type_name'] : null;
                        $candidate->is_hired = isset($candidate_data['is_hired']) ? $candidate_data['is_hired'] : null;
                        $candidate->personality = isset($candidate_data['personality']) ? $candidate_data['personality'] : null;
                        $candidate->personality_algorithm = isset($candidate_data['personality_algorithm']) ? $candidate_data['personality_algorithm'] : null;
                        $candidate->greenhouse_profile_url = isset($candidate_data['greenhouse_profile_url']) ? $candidate_data['greenhouse_profile_url'] : null;
                        $candidate->stage = isset($candidate_data['stage']) ? $candidate_data['stage'] : null;
                        $candidate->status_notification = isset($candidate_data['status_notification']) ? $candidate_data['status_notification'] : null;
                        $candidate->modified = isset($candidate_data['modified']) ? $candidate_data['modified'] : null;
                        $candidate->last_activity = isset($candidate_data['last_activity']) ? $candidate_data['last_activity'] : null;
                        $candidate->rating = isset($candidate_data['rating']) ? $candidate_data['rating'] : null;
                        $candidate->has_consumed_credit = isset($candidate_data['has_consumed_credit']) ? $candidate_data['has_consumed_credit'] : null;
                        $candidate->review = isset($candidate_data['review']) ? $candidate_data['review'] : null;
                        $candidate->results_sent = isset($candidate_data['results_sent']) ? $candidate_data['results_sent'] : null;
                        $candidate->invitation_link = isset($candidate_data['invitation_link']) ? $candidate_data['invitation_link'] : null;
                        $candidate->role = isset($candidate_data['role']) ? $candidate_data['role'] : null;
                        if ($candidate->save()) {
                            $candidate_counter++;
                        } else {
                            echo json_encode($candidate->errors);
                        }
                    }
                }
            }

            //Get all assessment candidate results details
            $candidate_details = ApiAssessmentCandidate::find()->where(['assessment_id' => $selected_assessment->id])->all();
            if (count($candidate_details) > 0) {
                foreach ($candidate_details as $candidate_detail) {
                    echo $candidate_detail->testtaker_id . '<br />';

                    chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                    if (substr(php_uname(), 0, 7) == "Windows") {
                        //windows
                        popen("start /B php yii jobportal/sync-asssessment-candidate-details " . $candidate_detail->testtaker_id . "", "r"); //Wait one by one until all candidates are fetched
                    } else {
                        //linux
                        shell_exec("php yii jobportal/sync-asssessment-candidate-details " . $candidate_detail->testtaker_id . " > log.txt 2>&1 &");
                    }
                }
            }
        }
    }

    public function actionDeleteCandidate($id) {
        $selected_candidate = ApiAssessmentCandidate::find()->where(['candidate_id' => $id])->one();
        if (!isset($selected_candidate->candidate_id)) {
            return "Candidate not found";
        }
        //Invited candidates
        $url = 'https://app.testgorilla.com/api/assessments/candidature/' . $id;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        curl_close($ch);

        $conn = \Yii::$app->db;

        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Delete candidate','" . str_replace("'", " ", $response) . "')";
        $conn->CreateCommand($query)->execute();
        if (!isset($response_data['detail'])) {
            ApiAssessmentCandidate::find()->where(['candidate_id' => $selected_candidate->candidate_id])->one()->delete();
            echo $selected_candidate->candidate_id . ' Successfully deleted';
        } else {
            echo ' Nothing deleted';
        }
    }

    public function actionSyncAssessmentCandidateResults($assessment_id, $testtaker_id) {

        $selected_candidate = ApiAssessmentCandidate::find()->where(['testtaker_id' => $testtaker_id])->andWhere(['assessment_id' => $assessment_id])->one();
        if (!isset($selected_candidate->candidate_id)) {
            return "Candidate not found";
        }
        //Invited candidates
        $url = 'https://app.testgorilla.com/api/assessments/results/?candidature__assessment=' . $assessment_id . '&candidature__test_taker=' . $testtaker_id;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        curl_close($ch);

        $conn = \Yii::$app->db;

        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Candidate assessment results','" . str_replace("'", " ", $response) . "')";
        $conn->CreateCommand($query)->execute();

        $test_counter = 0;
        if (isset($response_data['results'])) {
            foreach ($response_data['results'] as $result_data) {
                $test_result = ApiAssessmentCandidateTestResult::find()->where(['id' => $result_data['id']])->one();
                if (isset($test_result->id)) {
                    //Update
                    $test_result->name = isset($result_data['name']) ? $result_data['name'] : null;
                    $test_result->score = isset($result_data['score']) ? $result_data['score'] : null;
                    $test_result->status = isset($result_data['status']) ? $result_data['status'] : null;
                    $test_result->completed = isset($result_data['completed']) ? $result_data['completed'] : null;
                    $test_result->content_type_name = isset($result_data['content_type_name']) ? $result_data['content_type_name'] : null;
                    $test_result->custom_questions = isset($result_data['custom_questions']) ? json_encode($result_data['custom_questions']) : null;
                    $test_result->algorithm = isset($result_data['algorithm']) ? $result_data['algorithm'] : null;
                    $test_result->is_code_test = isset($result_data['is_code_test']) ? $result_data['is_code_test'] : null;
                    $test_result->score_display = isset($result_data['score_display']) ? $result_data['score_display'] : null;
                    $test_result->review = isset($result_data['review']) ? $result_data['review'] : null;
                    $test_result->score_description = isset($result_data['score_description']) ? $result_data['score_description'] : null;
                    $test_result->number_questions_completed = isset($result_data['number_questions_completed']) ? $result_data['number_questions_completed'] : null;
                    if ($test_result->save()) {
                        $test_counter++;
                    } else {
                        echo json_encode($test_result->errors);
                    }
                } else {
                    //Create new
                    $test_result = new ApiAssessmentCandidateTestResult();

                    $test_result->id = isset($result_data['id']) ? $result_data['id'] : null;
                    $test_result->test_id = isset($result_data['test_id']) ? $result_data['test_id'] : null;
                    $test_result->assessment_id = $assessment_id;
                    $test_result->testtaker_id = $testtaker_id;
                    $test_result->name = isset($result_data['name']) ? $result_data['name'] : null;
                    $test_result->score = isset($result_data['score']) ? $result_data['score'] : null;
                    $test_result->status = isset($result_data['status']) ? $result_data['status'] : null;
                    $test_result->completed = isset($result_data['completed']) ? $result_data['completed'] : null;
                    $test_result->content_type_name = isset($result_data['content_type_name']) ? $result_data['content_type_name'] : null;
                    $test_result->custom_questions = isset($result_data['custom_questions']) ? json_encode($result_data['custom_questions']) : null;
                    $test_result->algorithm = isset($result_data['algorithm']) ? $result_data['algorithm'] : null;
                    $test_result->is_code_test = isset($result_data['is_code_test']) ? $result_data['is_code_test'] : null;
                    $test_result->score_display = isset($result_data['score_display']) ? $result_data['score_display'] : null;
                    $test_result->review = isset($result_data['review']) ? $result_data['review'] : null;
                    $test_result->score_description = isset($result_data['score_description']) ? $result_data['score_description'] : null;
                    $test_result->number_questions_completed = isset($result_data['number_questions_completed']) ? $result_data['number_questions_completed'] : null;
                    if ($test_result->save()) {
                        $test_counter++;
                    } else {
                        echo json_encode($test_result->errors);
                    }
                }
            }
        }
        if ($test_counter > 0) {
            echo $test_counter . ' candidate tests successfully loaded';
        } else {
            echo 'Nothing Fetched';
        }
    }

    public function actionAssessmentTestResults() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $assessment_id = $request->get('assessent_id');
        $tt_id = $request->get('tt_id');
        $assessment = ApiAssessmentCandidate::find()->where(['assessment_id' => $assessment_id])->andWhere(['testtaker_id' => $tt_id])->one();

        if (!isset($assessment->id)) {
            return "Assessment not found";
        }
        //Invited candidates
        $url = 'https://app.testgorilla.com/api/assessments/results/?candidature__assessment=' . $assessment_id . '&candidature__test_taker=' . $tt_id;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        curl_close($ch);

        $conn = \Yii::$app->db;

        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Get assessment candidate test results','" . str_replace("'", " ", $response) . "')";
        $conn->CreateCommand($query)->execute();

        //Request the detailed resuls
        $return_response_data = array();
        if (count($response_data['results']) > 0) {

            foreach ($response_data['results'] as $result_data) {
                $skills_data = array();
                $skills_data["id"] = $result_data["id"];
                $skills_data["name"] = $result_data["name"];
                $skills_data["score"] = $result_data["score"];
                $skills_data["status"] = $result_data["status"];
                $skills_data["completed"] = $result_data["completed"];
                $skills_data["content_type_name"] = $result_data["content_type_name"];
                $skills_data["test_id"] = $result_data["test_id"];
                $skills_data["custom_questions"] = json_encode($result_data["custom_questions"]);
                $skills_data["algorithm"] = $result_data["algorithm"];
                $skills_data["is_code_test"] = $result_data["is_code_test"];
                $skills_data["score_display"] = $result_data["score_display"];
                $skills_data["review"] = $result_data["review"];
                $skills_data["score_description"] = $result_data["score_description"];
                $skills_data["number_questions_completed"] = $result_data["number_questions_completed"];

                //Make request
                //Invited candidates
                $url = 'https://app.testgorilla.com/api/assessments/results/' . $result_data['id'];

                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

                $response = curl_exec($ch);
                $response_details_data = json_decode($response, true);
                curl_close($ch);

                $conn = \Yii::$app->db;

                $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Get results details','" . str_replace("'", " ", $response) . "')";
                $conn->CreateCommand($query)->execute();
                $skills_data["skill_areas_score"] = array();
                if (isset($response_details_data['skill_areas_score'])) {
                    foreach ($response_details_data['skill_areas_score'] as $score) {
                        $score_data = array();
                        $score_data['description'] = $score['description'];
                        $score_data['score'] = $score['score'];
                        $score_data['answered_questions'] = $score['answered_questions'];
                        $score_data['total_questions'] = $score['total_questions'];
                        array_push($skills_data["skill_areas_score"], $score_data);
                    }
                }
                $skills_data["duration"] = $response_details_data['duration'];
                $skills_data["response_time"] = $response_details_data['response_time'];
                array_push($return_response_data, $skills_data);
            }
        }
        return array("results" => $return_response_data);
    }

    public function actionAssessmentCandidateDetails() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $testtaker_id = $request->get('testtaker_id');
        $candidate_id = $request->get('candidate_id');
        $assessment = ApiAssessmentCandidate::find()->where(['testtaker_id' => $testtaker_id])->andWhere(['candidate_id' => $candidate_id])->one();

        if (!isset($assessment->id)) {
            return "Candidate not found";
        }
        //Invited candidates
        $url = 'https://app.testgorilla.com/api/assessments/candidates/' . $testtaker_id . '/?candidature=' . $candidate_id;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        curl_close($ch);

        $conn = \Yii::$app->db;

        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Get assessment candidate details','" . str_replace("'", " ", $response) . "')";
        $conn->CreateCommand($query)->execute();

        return array("data" => $response_data);
    }

    public function actionSyncAssessmentCandidateDetails() {

        $request = Yii::$app->request;
        $testtaker_id = $request->get('tt_id');
        $assessment = ApiAssessmentCandidate::find()->where(['testtaker_id' => $testtaker_id])->one();

        if (!isset($assessment->id)) {
            return "Candidate not found";
        }
        //Invited candidates
        $url = 'https://app.testgorilla.com/api/assessments/candidates/' . $testtaker_id;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        curl_close($ch);

        $conn = \Yii::$app->db;

        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Sync assessment candidate details','" . str_replace("'", " ", $response) . "')";
        $conn->CreateCommand($query)->execute();
        $candidate_sync = true;

        if (isset($response_data['assessments_detail'])) {

            if (count($response_data['assessments_detail']) > 0) {

                foreach ($response_data['assessments_detail'] as $candidate_data) {
                    $test_result = ApiAssessmentCandidateDetails::find()->where(['candidate_id' => $candidate_data['id']])->one();
                    if (isset($test_result->candidate_id)) {
                        //Update existing
                        $test_result->assessment_id = isset($candidate_data['assessment_id']) ? $candidate_data['assessment_id'] : null;
                        $test_result->testtaker_id = $testtaker_id;
                        $test_result->assessment_name = isset($candidate_data['assessment_name']) ? $candidate_data['assessment_name'] : null;
                        $test_result->invited = isset($candidate_data['invited']) ? $candidate_data['invited'] : null;
                        $test_result->status = isset($candidate_data['status']) ? $candidate_data['status'] : null;
                        $test_result->has_consumed_credit = isset($candidate_data['has_consumed_credit']) ? $candidate_data['has_consumed_credit'] : null;
                        $test_result->content_type_name = isset($candidate_data['content_type_name']) ? $candidate_data['content_type_name'] : null;
                        $test_result->average = isset($candidate_data['average']) ? $candidate_data['average'] : null;
                        $test_result->test_taker_photos = isset($candidate_data['test_taker_photos']) ? json_encode($candidate_data['test_taker_photos']) : null;
                        $test_result->is_exited_full_screen = isset($candidate_data['is_exited_full_screen']) ? $candidate_data['is_exited_full_screen'] : null;
                        $test_result->is_left_screen = isset($candidate_data['is_left_screen']) ? $candidate_data['is_left_screen'] : null;
                        $test_result->modified = isset($candidate_data['modified']) ? $candidate_data['modified'] : null;
                        $test_result->last_activity = isset($candidate_data['last_activity']) ? $candidate_data['last_activity'] : null;
                        $test_result->highlight = isset($candidate_data['highlight']) ? $candidate_data['highlight'] : null;
                        $test_result->ip = isset($candidate_data['ip']) ? $candidate_data['ip'] : null;
                        $test_result->repeated_ip = isset($candidate_data['repeated_ip']) ? $candidate_data['repeated_ip'] : null;
                        $test_result->geoip = isset($candidate_data['geoip']) ? json_encode($candidate_data['geoip']) : null;
                        $test_result->role = isset($candidate_data['role']) ? $candidate_data['role'] : null;
                        $test_result->user_agent = isset($candidate_data['user_agent']) ? json_encode($candidate_data['user_agent']) : null;
                        $test_result->review = isset($candidate_data['review']) ? $candidate_data['review'] : null;
                        $test_result->stage = isset($candidate_data['stage']) ? $candidate_data['stage'] : null;
                        $test_result->reminder_sent = isset($candidate_data['reminder_sent']) ? $candidate_data['reminder_sent'] : null;
                        $test_result->public_link = isset($candidate_data['public_link']) ? $candidate_data['public_link'] : null;
                        $test_result->assessment_benchmark = isset($candidate_data['assessment_benchmark']) ? json_encode($candidate_data['assessment_benchmark']) : null;
                        $test_result->tests_detail = isset($candidate_data['tests_detail']) ? json_encode($candidate_data['tests_detail']) : null;
                        $test_result->anti_cheating_photos_removed = isset($candidate_data['anti_cheating_photos_removed']) ? $candidate_data['anti_cheating_photos_removed'] : null;
                        $test_result->is_camera_enabled = isset($candidate_data['is_camera_enabled']) ? $candidate_data['is_camera_enabled'] : null;
                        $test_result->is_english_native_language = isset($candidate_data['is_english_native_language']) ? $candidate_data['is_english_native_language'] : null;
                        $test_result->accessibility_condition_description = isset($candidate_data['accessibility_condition_description']) ? $candidate_data['accessibility_condition_description'] : null;
                        $test_result->accessibility_condition_disclose = isset($candidate_data['accessibility_condition_disclose']) ? $candidate_data['accessibility_condition_disclose'] : null;
                        $test_result->accessibility_condition_extra_time = isset($candidate_data['accessibility_condition_extra_time']) ? $candidate_data['accessibility_condition_extra_time'] : null;
                        $test_result->total_extra_time = isset($candidate_data['total_extra_time']) ? $candidate_data['total_extra_time'] : null;
                        $test_result->assessment_extra_time = isset($candidate_data['assessment_extra_time']) ? $candidate_data['assessment_extra_time'] : null;

                        if (!$test_result->save()) {
                            $candidate_sync = false;
                        }
                    } else {
                        $test_result = new ApiAssessmentCandidateDetails();
                        $test_result->candidate_id = isset($candidate_data['id']) ? $candidate_data['id'] : null;
                        $test_result->assessment_id = isset($candidate_data['assessment_id']) ? $candidate_data['assessment_id'] : null;
                        $test_result->testtaker_id = $testtaker_id;
                        $test_result->assessment_name = isset($candidate_data['assessment_name']) ? $candidate_data['assessment_name'] : null;
                        $test_result->invited = isset($candidate_data['invited']) ? $candidate_data['invited'] : null;
                        $test_result->status = isset($candidate_data['status']) ? $candidate_data['status'] : null;
                        $test_result->has_consumed_credit = isset($candidate_data['has_consumed_credit']) ? $candidate_data['has_consumed_credit'] : null;
                        $test_result->content_type_name = isset($candidate_data['content_type_name']) ? $candidate_data['content_type_name'] : null;
                        $test_result->average = isset($candidate_data['average']) ? $candidate_data['average'] : null;
                        $test_result->test_taker_photos = isset($candidate_data['test_taker_photos']) ? json_encode($candidate_data['test_taker_photos']) : null;
                        $test_result->is_exited_full_screen = isset($candidate_data['is_exited_full_screen']) ? $candidate_data['is_exited_full_screen'] : null;
                        $test_result->is_left_screen = isset($candidate_data['is_left_screen']) ? $candidate_data['is_left_screen'] : null;
                        $test_result->modified = isset($candidate_data['modified']) ? $candidate_data['modified'] : null;
                        $test_result->last_activity = isset($candidate_data['last_activity']) ? $candidate_data['last_activity'] : null;
                        $test_result->highlight = isset($candidate_data['highlight']) ? $candidate_data['highlight'] : null;
                        $test_result->ip = isset($candidate_data['ip']) ? $candidate_data['ip'] : null;
                        $test_result->repeated_ip = isset($candidate_data['repeated_ip']) ? $candidate_data['repeated_ip'] : null;
                        $test_result->geoip = isset($candidate_data['geoip']) ? json_encode($candidate_data['geoip']) : null;
                        $test_result->role = isset($candidate_data['role']) ? $candidate_data['role'] : null;
                        $test_result->user_agent = isset($candidate_data['user_agent']) ? json_encode($candidate_data['user_agent']) : null;
                        $test_result->review = isset($candidate_data['review']) ? $candidate_data['review'] : null;
                        $test_result->stage = isset($candidate_data['stage']) ? $candidate_data['stage'] : null;
                        $test_result->reminder_sent = isset($candidate_data['reminder_sent']) ? $candidate_data['reminder_sent'] : null;
                        $test_result->public_link = isset($candidate_data['public_link']) ? $candidate_data['public_link'] : null;
                        $test_result->assessment_benchmark = isset($candidate_data['assessment_benchmark']) ? json_encode($candidate_data['assessment_benchmark']) : null;
                        $test_result->tests_detail = isset($candidate_data['tests_detail']) ? json_encode($candidate_data['tests_detail']) : null;
                        $test_result->anti_cheating_photos_removed = isset($candidate_data['anti_cheating_photos_removed']) ? $candidate_data['anti_cheating_photos_removed'] : null;
                        $test_result->is_camera_enabled = isset($candidate_data['is_camera_enabled']) ? $candidate_data['is_camera_enabled'] : null;
                        $test_result->is_english_native_language = isset($candidate_data['is_english_native_language']) ? $candidate_data['is_english_native_language'] : null;
                        $test_result->accessibility_condition_description = isset($candidate_data['accessibility_condition_description']) ? $candidate_data['accessibility_condition_description'] : null;
                        $test_result->accessibility_condition_disclose = isset($candidate_data['accessibility_condition_disclose']) ? $candidate_data['accessibility_condition_disclose'] : null;
                        $test_result->accessibility_condition_extra_time = isset($candidate_data['accessibility_condition_extra_time']) ? $candidate_data['accessibility_condition_extra_time'] : null;
                        $test_result->total_extra_time = isset($candidate_data['total_extra_time']) ? $candidate_data['total_extra_time'] : null;
                        $test_result->assessment_extra_time = isset($candidate_data['assessment_extra_time']) ? $candidate_data['assessment_extra_time'] : null;

                        if (!$test_result->save()) {
                            $candidate_sync = false;
                        }
                    }
                }
            }
        }

        if ($candidate_sync) {
            return "Candidate details synced";
        } else {
            return "Error ----- Candidate details not synced";
        }
    }

    public function actionCandidateResultPdf($tt_id, $c_id) {

        $url = 'https://app.testgorilla.com/api/assessments/candidates/' . $tt_id . '/render_pdf/?candidature=' . $c_id . '&timezone=Africa/Cairo';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $result = curl_exec($ch);

        curl_close($ch);
        header('Expires: 0'); // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        header('Cache-Control: private', false);
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="Result-' . time() . '.pdf"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($result)); // provide file size
        header('Connection: close');
        echo $result;
    }

    public function actionCandidateSendPdfResult($tt_id, $c_id) {

        $url = 'https://app.testgorilla.com/api/assessments/candidates/' . $tt_id . '/send-pdf/?candidature=' . $c_id;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token 612b49503d83735a7aaebf907bc44df32f854d12'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $result = curl_exec($ch);
        $response_data = json_decode($result, true);
        if (isset($response_data['ok']) && $response_data['ok'] == true) {
            Yii::$app->session->setFlash('success', "Results successfully sent to candidate");
        } else {
            Yii::$app->session->setFlash('error', "An error occured while sending results");
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Lists all ApiAssessments models.
     *
     * @return string
     */
    public function actionJobSeeker() {
        if (!Yii::$app->user->can('mediator')) {

            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchResidence(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;

        return $this->render('jobseekerlist', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex($title = null, $status = 'active') {

        $url = 'https://app.testgorilla.com/api/profiles/login/';

        $data = array(
            'username' => 'jeanpaul.turikumwe01+API@gmail.com',
            'password' => 'KoraRwa@123!'
        );

        $body = json_encode($data);
        echo $body;
        exit();
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'origin:https://app.testgorilla.com'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        print_r($result);
        exit();
        Yii::$app->db->schema->refresh();
        $this->layout = 'dashboard';
        $searchModel = new ApiAssessmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (isset($title)) {
            $dataProvider->query->andWhere(['like', 'name', '%' . htmlspecialchars($title) . '%', false]);
        }
        if (isset($status)) {
            $dataProvider->query->andWhere(['status' => $status]);
        }
        return $this->render('index', [
                    'assessement_synchronization' => ApiSyncing::find()->where(['object_name' => ApiSyncing::OBJECT_NAME_ASSESSMENT])->one(),
                    'status' => $status,
                    'searchModel' => $searchModel,
                    'assessments' => $dataProvider->getModels(),
                    'assessment_count' => $dataProvider->getTotalCount(),
                    'pagination' => $dataProvider->pagination,
        ]);
    }

    /**
     * Displays a single ApiAssessments model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        Yii::$app->db->schema->refresh();
        $searchModel = new ApiAssessmentCandidateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['assessment_id' => $id]);

        $JobSeekersearchModel = new UserProfileSearch();
        $JobSeekerdataProvider = $JobSeekersearchModel->searchResidence(Yii::$app->request->queryParams);
        $JobSeekerdataProvider->pagination->pageSize = 10;

        $all_jobseeker_ids = '';
        $all_jobseekers = $JobSeekerdataProvider->query->all();
        if (count($all_jobseekers)) {
            $counter = 1;
            foreach ($all_jobseekers as $seeker) {
                if ($counter == 1) {
                    $all_jobseeker_ids .= $seeker->user_id;
                } else {
                    $all_jobseeker_ids .= ',' . $seeker->user_id;
                }
                $counter++;
            }
        }
        $this->layout = 'dashboard';
        return $this->render('view', [
                    'assessment' => $this->findModel($id),
                    'total_records' => count($all_jobseekers),
                    'all_jobseeker_ids' => $all_jobseeker_ids,
                    'candidatesSearchModel' => $searchModel,
                    'current_assessment_id' => $id,
                    'assessement_details_synchronization' => ApiSyncing::find()->where(['object_name' => ApiSyncing::OBJECT_NAME_ASSESSMENT])->where(['assessment_id' => $id])->one(),
                    'assessment_candidates' => $dataProvider->getModels(),
                    'assessment_candidates_count' => $dataProvider->getTotalCount(),
                    'assessment_candidates_pagination' => $dataProvider->pagination,
                    'searchModel' => $JobSeekersearchModel,
                    'dataProvider' => $JobSeekerdataProvider,
        ]);
    }

    /**
     * Creates a new ApiAssessments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate() {
        $model = new ApiAssessments();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ApiAssessments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ApiAssessments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ApiAssessments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ApiAssessments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ApiAssessments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
