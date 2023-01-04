<?php

namespace frontend\modules\hr\controllers;

use frontend\modules\hr\models\ApiAssessments;
use frontend\modules\hr\models\search\ApiAssessmentsSearch;
use frontend\modules\hr\models\search\ApiAssessmentCandidateSearch;
use frontend\modules\hr\models\ApiAssessmentCandidate;
use frontend\modules\hr\models\ApiSyncing;
use frontend\modules\hr\models\ApiAssessmentCandidateDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;

/**
 * AssessmentsController implements the CRUD actions for ApiAssessments model.
 */
class AssessmentsController extends Controller {

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
                    'access' => [
                        'class' => \yii\filters\AccessControl::class,
                        'only' => ['job-seeker', 'list', 'candidates', 'assessment-candidates', 'view', 'assessment-candidate', 'delete-candidate', 'sync-asssessments', 'sync-assessment-details', 'create', 'update', 'invite-candidate', 'delete'],
                        'rules' => [
                            [
                                'allow' => true,
                                'actions' => ['index-tocken'],
                                'roles' => ['?'],
                            ],
                            [
                                'allow' => true,
                                'actions' => ['job-seeker', 'list', 'candidates', 'assessment-candidates', 'view', 'assessment-candidate', 'delete-candidate', 'sync-asssessments', 'sync-assessment-details', 'create', 'update', 'invite-candidate', 'delete'],
                                'roles' => ['@'],
                                'matchCallback' => function ($rule, $action) {
                                    return Yii::$app->user->can('RDB');
                                }
                            ],
                        ],
                    ],
                ]
        );
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
        $searchModel = new \frontend\modules\jobseeker\models\search\UserProfileSearch();
        $dataProvider = $searchModel->searchResidence(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;

        return $this->render('jobseekerlist', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList($title = null, $status = "active") {

        
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

    public function actionCandidates($ass_id = null, $candidate = null) {


        Yii::$app->db->schema->refresh();
        $this->layout = 'dashboard';
        $searchModel = new ApiAssessmentCandidateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (isset($candidate)) {
            $dataProvider->query->leftJoin('user_profile', 'user_profile.user_id = api_assessment_candidate.user_id')->where(['like', 'CONCAT(user_profile.lastname,user_profile.firstname)', '%' . htmlspecialchars($candidate) . '%', false]);
        }
        if (isset($ass_id) && intval($ass_id) > 0) {
            $dataProvider->query->andWhere(['assessment_id' => $ass_id]);
        }
        $dataProvider->query->groupBy(['api_assessment_candidate.user_id']);
        return $this->render('candidates', [
                    'selected_assessment' => (isset($ass_id) && intval($ass_id) > 0) ? $ass_id : null,
                    'assessments' => ApiAssessments::find()->all(),
                    'searchModel' => $searchModel,
                    'candidates' => $dataProvider->getModels(),
                    'assessment_count' => $dataProvider->getTotalCount(),
                    'pagination' => $dataProvider->pagination,
        ]);
    }

    public function actionIndexTocken($title = null, $status = 'active') {

        $url = 'https://app.testgorilla.com/api/profiles/login/';

        $data = array(
            'username' => 'jeanpaul.turikumwe01+API@gmail.com',
            'password' => 'KoraRwa@123!'
        );

        $body = json_encode($data);

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

    public function actionAssessmentCandidates($id) {

        $url = 'https://app.testgorilla.com/api/profiles/login/';

        $data = array(
            'username' => 'jeanpaul.turikumwe01+API@gmail.com',
            'password' => 'KoraRwa@123!'
        );

        $body = json_encode($data);

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

        $JobSeekersearchModel = new \frontend\modules\jobseeker\models\search\UserProfileSearch();
        $JobSeekerdataProvider = $JobSeekersearchModel->searchResidence(Yii::$app->request->queryParams);

        $invited_candidates = ApiAssessmentCandidate::find()->where(['assessment_id' => $id])->all();
        $invited_ids = array();
        if (count($invited_candidates) > 0) {
            foreach ($invited_candidates as $candidate) {
                array_push($invited_ids, $candidate->user_id);
            }
        }
        $JobSeekerdataProvider->query->andWhere(['not in', 'user_profile.user_id', $invited_ids]);
        $JobSeekerdataProvider->query->andWhere(['user.status' => 2]); //Only users with verified email can be invited in bulk
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

    public function actionAssessmentCandidate($id, $tt_id) {
        Yii::$app->db->schema->refresh();

        $candidate = ApiAssessmentCandidate::find()->where(['testtaker_id' => $tt_id])->andWhere(['assessment_id' => $id])->one();
        if (!isset($candidate->id)) {
            throw new ForbiddenHttpException(Yii::t('yii', 'Invalid candidate.'));
        }
        $candidate_user_profile = \common\models\UserProfile::find()->where(['user_id' => $candidate->user_id])->one();
        if (!isset($candidate_user_profile->user_id)) {
            throw new ForbiddenHttpException(Yii::t('yii', 'User profile not found.'));
        }

        $this->layout = 'dashboard';
        return $this->render('view_candidate', [
                    'assessment' => $this->findModel($id),
                    'candidate' => $candidate,
                    'candidate_details' => ApiAssessmentCandidateDetails::find()->where(['testtaker_id' => $tt_id])->andWhere(['assessment_id' => $id])->one(),
                    'candidate_user_profile' => $candidate_user_profile
        ]);
    }

    /**
     * Creates a new ApiAssessments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionDeleteCandidate() {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $selected_candidate = ApiAssessmentCandidate::find()->where(['candidate_id' => $request->post('candidate_id')])->one();
            if (isset($selected_candidate->candidate_id)) {
                $selected_candidate->pending_deletion = 1;
                if ($selected_candidate->save(false)) {
                    //Launch the send invitation job
                    chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                    if (substr(php_uname(), 0, 7) == "Windows") {
                        //windows
                        pclose(popen("start /B php yii jobportal/delete-candidate " . $request->post('candidate_id') . " 1> log.txt 2>&1 &", "r"));
                    } else {
                        //linux
                        shell_exec("php yii jobportal/delete-candidate " . $request->post('candidate_id') . "  > /dev/null &");
                    }
                    Yii::$app->session->setFlash('success', " candidates scheduled for assessment deletion");
                } else {
                    Yii::$app->session->setFlash('error', "An error occured while requesting deletion.");
                }
            } else {
                echo 'Candidate not found' . $request->post('candidate_id');
            }
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'Invalid request.'));
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSendBulk() {
        Yii::$app->db->schema->refresh();
        $request = Yii::$app->request;
        $ids = $request->post('ids'); // Array of selected candidates
        $selected_action = $request->post('bulk_action');

        $bulked_candites = 0;
        $not_bulked_candites = 0;

        switch ($selected_action) {
            case "1": { // 1 is for reminders
                    foreach ($ids as $id) {
                        $current_candidate = \frontend\modules\hr\models\ApiAssessmentCandidate::find()->where(['id' => $id])->one();
                        echo $id . '<br />';
                        if (isset($current_candidate->user_id)) {

                            //Save the candidate on the queue
                            if ($current_candidate->status != 'completed') {
                                $reminder = new \frontend\modules\hr\models\ApiAssessmentCandidateBulkReminder();
                                $reminder->candidate_id = $current_candidate->candidate_id;
                                $reminder->test_taker_id = $current_candidate->testtaker_id;
                                $reminder->created_on = date('Y-m-d H:i:s');
                                if ($reminder->save()) {
                                    $bulked_candites++;
                                }
                            } else {
                                $not_bulked_candites++;
                            }
                        }
                        if ($bulked_candites > 0) {
                            //Launch the send invitation job
                            chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                            if (substr(php_uname(), 0, 7) == "Windows") {
                                //windows
                                pclose(popen("start /B php yii jobportal/sync-bulk-reminder 1> log.txt 2>&1 &", "r"));
                                //shell_exec('php yii jobportal/send-mail-notifications &');
                            } else {
                                //linux
                                shell_exec("php yii jobportal/sync-bulk-reminder  > /dev/null &");
                            }
                            $message = $bulked_candites . " candidates scheduled for assessment reminders.";
                            if ($not_bulked_candites > 0) {
                                $message .= ' ' . $not_bulked_candites . ' not reminded due to that, they already completed the assessment';
                            }
                            Yii::$app->session->setFlash('success', $message);
                        }
                        if ($bulked_candites == 0) {
                            Yii::$app->session->setFlash('error', "No candidate reminded");
                        }
                    }
                    return $this->redirect(Yii::$app->request->referrer);
                }
                break;
            case "2": { // 1 is for results sending
                    foreach ($ids as $id) {
                        $current_candidate = \frontend\modules\hr\models\ApiAssessmentCandidate::find()->where(['id' => $id])->one();
                        echo $id . '<br />';
                        if (isset($current_candidate->user_id)) {

                            //Save the candidate on the queue
                            if ($current_candidate->status != 'completed') {
                                $result = new \frontend\modules\hr\models\ApiAssessmentCandidateBulkResultSend();
                                $result->candidate_id = $current_candidate->candidate_id;
                                $result->test_taker_id = $current_candidate->testtaker_id;
                                $result->created_on = date('Y-m-d H:i:s');
                                if ($result->save()) {
                                    $bulked_candites++;
                                }
                            } else {
                                $not_bulked_candites++;
                            }
                        }
                        if ($bulked_candites > 0) {
                            //Launch the send invitation job
                            chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                            if (substr(php_uname(), 0, 7) == "Windows") {
                                //windows
                                pclose(popen("start /B php yii jobportal/sync-bulk-result-sending 1> log.txt 2>&1 &", "r"));
                                //shell_exec('php yii jobportal/send-mail-notifications &');
                            } else {
                                //linux
                                shell_exec("php yii jobportal/sync-bulk-result-sending  > /dev/null &");
                            }
                            $message = $bulked_candites . " candidates scheduled for assessment results sending.";
                            if ($not_bulked_candites > 0) {
                                $message .= ' ' . $not_bulked_candites . ' not sent due to that, they already received their results';
                            }
                            Yii::$app->session->setFlash('success', $message);
                        }
                        if ($bulked_candites == 0) {
                            Yii::$app->session->setFlash('error', "No result sent");
                        }
                    }
                    return $this->redirect(Yii::$app->request->referrer);
                }
                break;
            case "3": { // 1 is for remove from assessment
                    foreach ($ids as $id) {
                        $current_candidate = \frontend\modules\hr\models\ApiAssessmentCandidate::find()->where(['id' => $id])->one();
                        echo $id . '<br />';
                        if (isset($current_candidate->user_id)) {

                            //Save the candidate on the queue
                            if ($current_candidate->status != 'completed') {
                                $remove = new \frontend\modules\hr\models\ApiAssessmentCandidateBulkRemove();
                                $remove->candidate_id = $current_candidate->candidate_id;
                                $remove->test_taker_id = $current_candidate->testtaker_id;
                                $remove->created_on = date('Y-m-d H:i:s');
                                if ($remove->save()) {
                                    $bulked_candites++;
                                }
                            } else {
                                $not_bulked_candites++;
                            }
                        }
                        if ($bulked_candites > 0) {
                            //Launch the send invitation job
                            chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                            if (substr(php_uname(), 0, 7) == "Windows") {
                                //windows
                                pclose(popen("start /B php yii jobportal/sync-bulk-result-removal 1> log.txt 2>&1 &", "r"));
                                //shell_exec('php yii jobportal/send-mail-notifications &');
                            } else {
                                //linux
                                shell_exec("php yii jobportal/sync-bulk-result-removal  > /dev/null &");
                            }
                            $message = $bulked_candites . " candidates scheduled for assessment removal.";
                            if ($not_bulked_candites > 0) {
                                $message .= ' ' . $not_bulked_candites . ' not reminded due to that, they already removed from assessment';
                            }
                            Yii::$app->session->setFlash('success', $message);
                        }
                        if ($bulked_candites == 0) {
                            Yii::$app->session->setFlash('error', "No candidate removed");
                        }
                    }
                    return $this->redirect(Yii::$app->request->referrer);
                }
                break;
            default: {
                    return $this->redirect(Yii::$app->request->referrer);
                    Yii::$app->session->setFlash('error', "No action done");
                }
        }
    }

    public function actionSyncAsssessments() {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            //Launch the send invitation job
            chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
            if (substr(php_uname(), 0, 7) == "Windows") {
                //windows
                pclose(popen("start /B php yii jobportal/sync-asssessments 1> log.txt 2>&1 &", "r"));
            } else {
                //linux
                shell_exec("php yii jobportal/sync-asssessments  > /dev/null &");
            }
            return [
                'data' => 'Success'
            ];
        } else {
            return [
                'data' => 'failed'
            ];
        }
    }

    public function actionSyncAssessmentDetails() {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $assessment_id = $request->post('id');
        $assessment = ApiAssessments::find()->where(['id' => $assessment_id])->one();
        if (isset($assessment->id)) {
            if ($request->isPost) {
                //Launch the send invitation job
                chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                if (substr(php_uname(), 0, 7) == "Windows") {
                    //windows
                    pclose(popen("start /B php yii jobportal/sync-asssessment-details " . $assessment->id . " 1> log.txt 2>&1 &", "r"));
                } else {
                    //linux
                    shell_exec("php yii jobportal/sync-asssessment-details " . $assessment->id . "  > /dev/null &");
                }
                return [
                    'data' => 'Success'
                ];
            } else {
                return [
                    'data' => 'failed'
                ];
            }
        } else {
            return [
                'data' => 'failed'
            ];
        }
    }

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
     * @return string|\yii\web\Response
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

    public function actionInviteCandidate() {
        $request = Yii::$app->request;
        $user_ids = explode(',', $request->post('user_ids')); // Array or selected users
        $assessment_id = $request->post('assessment_id'); // Array or selected users

        $invited_candites = 0;
        foreach ($user_ids as $user_id) {
            $current_user = \common\models\UserProfile::find()->where(['user_id' => $user_id])->one();
            $current_user_account = \common\models\User::find()->where(['id' => $user_id])->one();
            if (isset($current_user->user_id)) {
                //Check if the user was not invited before on this assessment
                if (!isset(ApiAssessmentCandidate::find()->where(['user_id' => $user_id])->andWhere(['assessment_id' => $assessment_id])->one()->user_id)) {

                    //Save the potential candidate
                    $candidate = new ApiAssessmentCandidate();
                    $candidate->user_id = $current_user->user_id;
                    $candidate->assessment_id = $assessment_id;
                    $candidate->email = $current_user_account->email;
                    $candidate->full_name = $current_user->firstname . ' ' . $current_user->lastname;
                    if ($candidate->save(false)) {
                        $invited_candites++;
                    }
                }
            }
        }
        if ($invited_candites > 0) {
            //Launch the send invitation job
            chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
            if (substr(php_uname(), 0, 7) == "Windows") {
                //windows
                pclose(popen("start /B php yii jobportal/invite-candidates " . $assessment_id . " 1> log.txt 2>&1 &", "r"));
                //shell_exec('php yii jobportal/send-mail-notifications &');
            } else {
                //linux
                shell_exec("php yii jobportal/invite-candidates " . $assessment_id . "  > /dev/null &");
            }
            if ($invited_candites == count($user_ids)) {
                Yii::$app->session->setFlash('success', $invited_candites . " candidates scheduled for assessment invitation");
            } else {
                Yii::$app->session->setFlash('success', $invited_candites . " candidates scheduled for assessment invitation.");
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        if ($invited_candites == 0) {
            Yii::$app->session->setFlash('error', "No candidate invited");
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Deletes an existing ApiAssessments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
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

    public function actionContollerActions() {
        $actions = get_class_methods($this);
        if (count($actions) > 0) {
            foreach ($actions as $action) {
                if (substr($action, 0, 6) === "action") {
                    echo "'" . str_replace("action-", "", strtolower(preg_replace('/\B([A-Z])/', '-$1', $action))) . "',";
                }
            }
        }
        exit();
    }

}
