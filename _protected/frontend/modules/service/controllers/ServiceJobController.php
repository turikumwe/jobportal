<?php

namespace frontend\modules\service\controllers;

// use common\commands\AddToTimelineCommand;


use backend\models\JobSkills;
use common\models\JobEducationField;
use backend\models\SDistrict;
use backend\models\SEducationLevel;
use backend\models\SSkill;
use common\commands\AddToTimelineCommand;
use common\models\JsAddress;
use common\models\JsJobApplication;
use common\models\JsSummary;
use common\models\ServiceJob;
use common\models\ServiceJobSharing;
use common\models\SOpportunity;
use common\models\User;
use common\models\EmplEmployer;
use common\models\JobApplicationStatus;
use backend\models\SStatus;
use frontend\modules\service\models\search\ServiceJobSearch;
use frontend\notifier\NewOpportunityNotification;
use frontend\notifier\Notifier;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use common\commands\SendEmailCommand;
use common\models\UserProfile;
use DateTime;
use yii\web\UploadedFile;

/**
 * ServiceJobController implements the CRUD actions for ServiceJob model.
 */
class ServiceJobController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                    'bulk-delete' => ['post'],
                    'update-status' => ['post'],
                    'change-status' => ['post'],
                    'bulk-change-application-status' => ['post'],
                ],
            ],
//            'access' => [
//                'class' => \yii\filters\AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['index', 'agent'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['post-opportunity', 'my-jobs'], // add all actions to take guest to login page
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
        ];
    }

    public function actions() {
        return [
            'employerlogo-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'employerlogo-delete',
            ],
            'employerlogo-delete' => [
                'class' => DeleteAction::class
            ]
        ];
    }

    /**
     * Lists all ServiceJob models.
     * @return mixed
     * 
     *  $categoriesDataProvider = new ActiveDataProvider([
     *       'query' => ServiceJob::find()->top(10),
     *      'pagination' => false,
     *   ]); 
     * */
    public function actionAgent() {
        return $this->render('agent');
    }

    public function actionNotifyMatchingSkills($job_id) {

        //Get users with Matching skills
        $connection = Yii::$app->get("db");
        // Get current value if the primary key
        $result = $connection->createCommand("
        SELECT
	jobskills.job_id, 
	service_job.employer, 
	service_job.jobtitle, 
	service_job.publication_date,
	js_skill.user_id, 
	js_skill.skill_id, 
	s_skill.skill, 
	s_skill_level.`level`
        FROM
	service_job
	INNER JOIN
	jobskills
	ON 
		service_job.id = jobskills.job_id
	INNER JOIN
	js_skill
	ON 
		jobskills.skill_id = js_skill.skill_id
	INNER JOIN
	s_skill
	ON 
		js_skill.skill_id = s_skill.id
	INNER JOIN
	s_skill_level
	ON 
	js_skill.skill_level_id = s_skill_level.id 
        where jobskills.job_id=" . $job_id . "
        GROUP BY js_skill.user_id")->queryAll();
        if (count($result) > 0) {
            $service_job = ServiceJob::findOne($job_id);
            echo "Reached";
            exit();
            foreach ($result as $candidate) {
                $current_user = \common\models\UserProfile::findOne($candidate['user_id']);
                $current_user_login = \common\models\User::findOne($candidate['user_id']);
                $message = "Dear " . $current_user->firstname . ' ' . $current_user->lastname . ",<br /><br />"
                        . "This is notification serves to inform you that, There is a new Job which requires your skills posted."
                        . "<br /> <a href='" . Yii::$app->homeUrl . '/service/service-job?id=' . $job_id . "' target='_blank'>Click here</a> to check the posted Job"
                        . "<br /><br />Please don't reply to this email as it is a System Generated<br /><br />Kora Job Portal";
                $message_title = 'New Job matching your skills posted - Kora Job Portal';
                $notification = new \common\models\SNotifications();
                $notification->opportunity_id = $service_job->id;
                $notification->user_id = $current_user->user_id;
                $notification->message_body = $message;
                $notification->message_title = $message_title;
                if ($notification->save(false)) {
                    //Send email
                    $send_email = Yii::$app->commandBus->handle(new SendEmailCommand([
                                'subject' => $message_title,
                                'to' => $current_user_login->email,
                                'body' => $message
                    ]));

                    if ($send_email) {
                        //Update the notification in db
                        $notification->mail_sent = \common\models\SNotifications::MAIL_SENT;
                        $notification->save(false);
                        echo 'Notifications sent';
                    } else {
                        echo 'Failed to send notifications';
                    }
                } else {
                    var_dump($service_job->errors);
                    die;
                }
            }
        } else {
            echo 'No matching users';
        }
    }

    public function actionIndex($type = null, $title = null, $category = null, $emp_type = null, $location = null, $sort = 'R', $id = null, $jt = null, $ct = null) {

        $this->view->params['bgimage'] = "opportunities.png";
        $this->view->params['alt'] = "A man and two women, one has disability sitting in front of computer, searching for opportunities";

        $currentdate = date("Y-m-d");

        $searchModel = new ServiceJobSearch();

        $published = $searchModel->searchAll(Yii::$app->request->queryParams, null, null, 0);
        $published->query->andWhere(['service_job.action_id' => 1]);

        if (isset($category) && intval($category) > 0) {
            $published->query->andWhere(['service_job.occupation_grouping_id' => $category]);
        }
        if (isset($location) && intval($location) > 0) {
            $published->query->andWhere(['service_job.district_id' => $location]);
        }
        if (isset($id) && intval($id) > 0) {
            $published->query->andWhere(['service_job.id' => $id]);
        }
        if (isset($title)) {
            $published->query->andWhere(['like', 'service_job.jobtitle', '%' . htmlspecialchars($title) . '%', false]);
        }
        if (isset($sort) && $sort == 'R' && !Yii::$app->user->isGuest) {
            $published->query->leftJoin('jobskills', 'service_job.id = jobskills.job_id');
            $published->query->leftJoin('js_skill', 'jobskills.skill_id = js_skill.skill_id and js_skill.user_id = ' . Yii::$app->user->id . '');
            $published->query->select(['count(js_skill.skill_id) AS total_skills, service_job.*']);
            $published->query->groupBy(['service_job.id']);
            $published->query->orderBy(['count(js_skill.skill_id)' => SORT_DESC, 'service_job.created_at' => SORT_DESC]);
        }
        if (isset($sort) && $sort == 'O') {
            $published->query->orderBy(['service_job.created_at' => SORT_ASC]);
        }
        if ($sort == 'N') {
            $published->query->orderBy(['service_job.created_at' => SORT_DESC]);
        }
        if (isset($jt) && strlen($jt) > 0) {
            $published->query->andWhere(['in', 'service_job.s_opportunity_id', explode(',', $jt)]);
        }
        if (isset($ct) && strlen($ct) > 0) {
            $published->query->andWhere(['in', 'service_job.job_type_id', explode(',', $ct)]);
        }
        if (Yii::$app->user->isGuest) {
            $sorting = array(
                'N' => 'Newest',
                'O' => 'Oldest'
            );
        } else {
            $sorting = array(
                'R' => 'Relevant to my skills',
                'N' => 'Newest',
                'O' => 'Oldest'
            );
        }


        $districts = isset($_GET['displayAll']) ? SDistrict::find()->orderBy('district')->all() : SDistrict::find()->orderBy('district')->limit(5)->all();

        return $this->render('index', [
                    'data' => ArrayHelper::map(SEducationLevel::find()->all(), 'id', 'level'),
                    'summary' => JsSummary::find()->myProfile()->one(),
                    'profile' => User::findOne(Yii::$app->user->id),
                    'districts' => ArrayHelper::map($districts, 'id', 'district'),
                    'apply' => new JsJobApplication(),
                    'share' => new ServiceJobSharing(),
                    'job_categories' => \common\models\SOccupationGrouping::find()->asArray()->all(),
                    'sorting' => $sorting,
                    'selected_sorting' => $sort,
                    'type' => $type,
                    'title' => $title,
                    'selected_category' => $category,
                    'selected_location' => $location,
                    'emp_type' => $emp_type,
                    'selected_job_types' => explode(',', $jt),
                    'selected_contract_types' => explode(',', $ct),
                    'searchModel' => $searchModel,
                    'jobs' => $published->getModels(),
                    'jobs_count' => $published->getTotalCount(),
                    'pagination' => $published->pagination,
                    'opportinities' => SOpportunity::find()->firstType()->all(),
                    'jobgroups' => ServiceJob::find()->select('occupation_grouping_id,count(*) AS id')->where(['>=', 'closure_date', $currentdate])->andWhere(['action_id' => 1])->groupBy('occupation_grouping_id')->orderBy('occupation_grouping_id')->all(),
        ]);
    }

    public function actionMyJobs($type = 0, $title = null) {
        $this->layout = 'dashboard';

        $searchModel = new ServiceJobSearch();

        $published = $searchModel->searchAll(Yii::$app->request->queryParams, null, null, 0);

        if (intval($type) > 0) {
            $published->query->andWhere(['s_opportunity_id' => $type]);
        }
        if (isset($title)) {
            $published->query->andWhere(['like', 'jobtitle', '%' . htmlspecialchars($title) . '%', false]);
        }
        //User from Mediation center
        if (Yii::$app->user->can('mediator')) {
            $user_ids_from_same_mediator = User::getUserIdsFromSameMediator();
            $published->query->andWhere(['in', 'created_by', $user_ids_from_same_mediator]);
        }
        if (Yii::$app->user->can('employer')) {
            //An employer has this currently logged in user
            $published->query->andWhere(['in', 'created_by', Yii::$app->user->id]);
        }
        $published->query->orderBy(['created_at' => SORT_DESC]);

        return $this->render('my_job', [
                    'data' => ArrayHelper::map(SEducationLevel::find()->all(), 'id', 'level'),
                    'summary' => JsSummary::find()->myProfile()->one(),
                    'profile' => User::findOne(Yii::$app->user->id),
                    'apply' => new JsJobApplication(),
                    'share' => new ServiceJobSharing(),
                    'selected_type' => $type,
                    'searchModel' => $searchModel,
                    'jobs' => $published->getModels(),
                    'jobs_count' => $published->getTotalCount(),
                    'pagination' => $published->pagination,
                    'opportinities' => SOpportunity::find()->firstType()->all(),
        ]);
    }

    public function actionJobApplicant($job = null, $name = null) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/sign-in/login']);
        }
        $this->layout = 'dashboard';

        $searchModel = new ServiceJobSearch();
        $published = $searchModel->searchAll(Yii::$app->request->queryParams, null, null, 0);

        //User from Mediation center
        if (Yii::$app->user->can('mediator')) {
            $user_ids_from_same_mediator = User::getUserIdsFromSameMediator();
            $published->query->andWhere(['in', 'created_by', $user_ids_from_same_mediator]);
        } else if (Yii::$app->user->can('employer')) {
            //An employer has this currently logged in user
            $published->query->andWhere(['in', 'created_by', array(Yii::$app->user->id)]);
        } else { // No Applicants
            if (User::isAJobSeeker(Yii::$app->user->id)) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }
        $published->pagination->pageSize = 2000000;
        $job_ids = array();
        $user_ids = array();
        if (count($published->getModels()) > 0) {
            foreach ($published->getModels() as $current_job) {
                array_push($job_ids, $current_job->id);
            }
        }
        if (count($job_ids) > 0) {
            $job_applications = JsJobApplication::find()->where(['in', 'job_id', $job_ids])->all();

            if (count($job_applications) > 0) {
                foreach ($job_applications as $application) {
                    array_push($user_ids, $application->user_id);
                }
            }
        }
        $applicantModel = new JsJobApplication();
        $applicantProvider = $applicantModel->search(Yii::$app->request->queryParams);

        if (isset($job)) {
            $applicantProvider->query->andWhere(['job_id' => $job]);
        }
        if (isset($name)) {
            $applicantProvider->query->leftJoin('user_profile', 'user_profile.user_id = js_job_application.user_id')->where(['like', 'CONCAT(user_profile.lastname,user_profile.firstname)', '%' . htmlspecialchars($name) . '%', false]);
        }

        $applicantProvider->query->andWhere(['in', 'user_id', $user_ids]);

        return $this->render('job_applicant', [
                    'selected_type' => null,
                    'selected_job' => ServiceJobSearch::findOne($job),
                    'job_application_status_model' => new JobApplicationStatus(),
                    'applicants' => $applicantProvider->getModels(),
                    'applicant_count' => $applicantProvider->getTotalCount(),
                    'pagination' => $applicantProvider->pagination,
        ]);
    }

    public function actionPlacement($job = null, $name = null) {
        $this->layout = 'dashboard';

        $searchModel = new ServiceJobSearch();
        $published = $searchModel->searchAll(Yii::$app->request->queryParams, null, null, 0);

        //User from Mediation center
        if (Yii::$app->user->can('mediator')) {
            $user_ids_from_same_mediator = User::getUserIdsFromSameMediator();
            $published->query->andWhere(['in', 'created_by', $user_ids_from_same_mediator]);
        }
        if (Yii::$app->user->can('employer')) {
            //An employer has this currently logged in user
            $published->query->andWhere(['in', 'created_by', Yii::$app->user->id]);
        }
        $published->query->orderBy(['created_at' => SORT_DESC]);
        $published->query->orderBy(['jobtitle' => SORT_ASC]);

        $published->pagination->pageSize = 10000;
        $user_jobs = array();
        if (count($published->getModels())) {
            foreach ($published->getModels() as $user_job) {
                array_push($user_jobs, $user_job->id);
            }
        }
        $applicantModel = new JsJobApplication();

        $applicantProvider = $applicantModel->search(Yii::$app->request->queryParams);

        if (isset($job)) {
            $applicantProvider->query->andWhere(['job_id' => $job]);
        }
        if (isset($name)) {
            $applicantProvider->query->leftJoin('user_profile', 'user_profile.user_id = js_job_application.user_id')->where(['like', 'CONCAT(user_profile.lastname,user_profile.firstname)', '%' . htmlspecialchars($name) . '%', false]);
        }
//        $published->select('js_job_application.*, job_application_status.status_id, job_application_status.id');
        $applicantProvider->query->leftJoin('job_application_status', 'job_application_status.id = js_job_application.job_application_status_id');
        $applicantProvider->query->andWhere(['job_application_status.status_id' => JsJobApplication::JOB_APPLICATION_STATUS_ACCEPTED]);
        $applicantProvider->query->andWhere(['in', 'js_job_application.job_id', $user_jobs]);

        if (isset($job)) {
            $applicantProvider->pagination->pageSize = 10000;
        }

        return $this->render('placement', [
                    'jobs' => $published->getModels(),
                    'selected_job' => $job,
                    'job_application_status_model' => new JobApplicationStatus(),
                    'placement_statuses' => SStatus::find()->where(['status_level' => SStatus::JOB_STATUS_LEVEL_PLACEMENT])->all(),
                    'applicants' => $applicantProvider->getModels(),
                    'applicant_count' => $applicantProvider->getTotalCount(),
                    'pagination' => $applicantProvider->pagination,
        ]);
    }

    public function actionAbroad($opportunity = null, $type = null, $search = 0) {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "opportunities.png";

        $searchModel = new ServiceJobSearch();
        $opportunities = $searchModel->search(Yii::$app->request->queryParams, $opportunity, $type, $search);
        $opportunities->query->where(['competency_level_id' => 2])->andWhere(['action_id' => 1])->andWhere(['>=', 'closure_date', date('Y-m-d')]);

        $districts = isset($_GET['displayAll']) ? SDistrict::find()->orderBy('district')->all() : SDistrict::find()->orderBy('district')->limit(5)->all();

        $oppforabroad = ServiceJob::find()
                ->where(['competency_level_id' => 2])
                ->andWhere(['action_id' => 1])
                ->andWhere(['>=', 'closure_date', date('Y-m-d')])
                ->count();

        $address = JsAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->count();
        if ($address >= 1) {
            $addresses = JsAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        }

        return $this->render('index', [
                    'data' => ArrayHelper::map(SEducationLevel::find()->all(), 'id', 'level'),
                    'shared' => ServiceJobSharing::find()->shared()->type($opportunity)->freshFirst()->all(),
                    'saved' => ServiceJobSharing::find()->saved()->type($opportunity)->freshFirst()->all(),
                    'applied' => JsJobApplication::find()->applied()->type($opportunity)->freshFirst()->all(),
                    'summary' => JsSummary::find()->myProfile()->one(),
                    'profile' => User::findOne(Yii::$app->user->id),
                    'districts' => ArrayHelper::map($districts, 'id', 'district'),
                    'apply' => new JsJobApplication(),
                    'share' => new ServiceJobSharing(),
                    'searchModel' => $searchModel,
                    'jobs' => $opportunities->getModels(),
                    'pagination' => $opportunities->pagination,
                    'oppforabroad' => $oppforabroad,
                    'addresses' => $addresses,
        ]);
    }

    public function actionPostOpportunity() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/sign-in/login']);
        }
        if (\common\models\User::isFromEmployer(Yii::$app->user->identity->id)) {

            $employer = User::findOne(Yii::$app->user->identity->id);
            if ($employer->employerProfile->is_verified == 0) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }
        $this->layout = 'dashboard';
        $job = new ServiceJob();

        $employer = User::findOne(Yii::$app->user->id);

        $skills = SSkill::find()->orderBy('skill')->asArray()->all();
        $educationFields = \backend\models\SEducationField::find()->orderBy('field')->asArray()->all();
        if (Yii::$app->user->can('RDB') || Yii::$app->user->can('mediator')) {
            $user_companies = EmplEmployer::find()->asArray()->all();
        } else {
            $user_companies = EmplEmployer::find()->where(['id' => $employer->employerProfile->id])->asArray()->all();
        }

        return $this->render('post/index', [
                    'model' => $job,
                    'user_companies' => $user_companies,
                    'selected_employer' => null,
                    'url' => '/service/service-job/create',
                    'profile' => User::findOne(Yii::$app->user->id),
                    'skills' => $skills,
                    'educationfields' => $educationFields,
                    'selected_job_skills' => array(),
                    'selected_education_field' => array(),
                    'opportinities' => SOpportunity::find()->firstType()->all()
        ]);
    }

    public function actionPostJob() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/sign-in/login']);
        }
        $this->layout = 'dashboard';
        return $this->render('post/job', [
                    'job' => null,
                    'employer' => User::findOne(Yii::$app->user->id),
        ]);
    }

    public function actionUpdateOpportunity($id) {
        $this->layout = 'dashboard';

        $model = $this->findModel($id);
        $job_skills = JobSkills::findByJobId($model->id);
        $job_fields = JobEducationField::findByJobId($model->id);

        $educationFields = \backend\models\SEducationField::find()->orderBy('field')->asArray()->all();

        $selected_job_skills = array();
        if (count($job_skills) > 0) {
            foreach ($job_skills as $skill) {
                array_push($selected_job_skills, $skill['skill_id']);
            }
        }

        $selected_job_fields = array();
        if (count($job_fields) > 0) {
            foreach ($job_fields as $field) {
                array_push($selected_job_fields, $field['field_id']);
            }
        }
        $skills = SSkill::find()->orderBy('skill')->asArray()->all();
        $employer = User::findOne(Yii::$app->user->id);
        if (Yii::$app->user->can('RDB') || Yii::$app->user->can('mediator')) {
            $user_companies = EmplEmployer::find()->orderBy('company_name asc')->asArray()->all();
        } else {
            $user_companies = EmplEmployer::find()->where(['id' => $employer->employerProfile->id])->orderBy('company_name asc')->asArray()->all();
        }


        if ($model->other_source == 1) {
            return $this->render('post/index', [
                        'model' => $model,
                        'user_companies' => $user_companies,
                        'selected_employer' => null,
                        'skills' => $skills,
                        'educationfields' => $educationFields,
                        'selected_job_skills' => $selected_job_skills,
                        'selected_education_field' => $selected_job_fields,
                        'url' => '/service/service-job/update?id=' . $id,
                        'profile' => User::findOne(Yii::$app->user->id),
                        'opportinities' => SOpportunity::find()->firstType()->all()
            ]);
        } else {
            $model->link = substr($model->link, 7);
            return $this->render('post/othersource', [
                        'model' => $model,
                        'skills' => $skills,
                        'educationfields' => $educationFields,
                        'selected_job_skills' => $selected_job_skills,
                        'selected_education_field' => $selected_job_fields,
                        'url' => '/service/service-job/update?id=' . $id,
                        'profile' => User::findOne(Yii::$app->user->id),
                        'opportinities' => SOpportunity::find()->firstType()->all()
            ]);
        }
    }

    public function actionPostOpportunityFromOtherSource() {

        if (\common\models\User::isFromEmployer(Yii::$app->user->identity->id)) {

            $employer = User::findOne(Yii::$app->user->identity->id);
            if ($employer->employerProfile->is_verified == 0) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }
        $this->layout = 'dashboard';
        $job = new ServiceJob();

        $employer = User::findOne(Yii::$app->user->id);
        $skills = SSkill::find()->orderBy('skill')->asArray()->all();
        if (Yii::$app->user->can('RDB') || Yii::$app->user->can('mediator')) {
            $user_companies = EmplEmployer::find()->asArray()->all();
        } else {
            $user_companies = EmplEmployer::find()->where(['id' => $employer->employerProfile->id])->asArray()->all();
        }

        return $this->render('post/othersource', [
                    'model' => $job,
                    'user_companies' => $user_companies,
                    'selected_employer' => null,
                    'url' => '/service/service-job/job-from-other-source',
                    'profile' => User::findOne(Yii::$app->user->id),
                    'skills' => $skills,
                    'selected_job_skills' => array(),
                    'opportinities' => SOpportunity::find()->firstType()->all()
        ]);
    }

    /**
     * Displays a single ServiceJob model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
//required skills
        $reqconnection = \Yii::$app->db;
        $requiredskills = 'select s.skill from jobskills as j,s_skill as s where j.job_id="' . $id . '" and j.skill_id=s.id';
        $reqresult = $reqconnection->createCommand($requiredskills)->queryAll();
        //educationFields
        $edufield = 'select e.field from s_education_field as e,job_education_fields as j where j.job_id="' . $id . '" and j.field_id=e.id';
        $educationfield = $reqconnection->createCommand($edufield)->queryAll();
        // $provider = ProviderFactory::create();
        // $ip = $provider->getExternalIP();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "ServiceJob #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {

            //Track views
            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                        'category' => 'visitor',
                        'event' => 'opportunity-view',
                        'data' => [
                            'opportunity_id' => $id,
                            'created_at' => time(),
                        ]
            ]));

            return $this->render('view', [
                        'model' => $this->findModel($id),
                        'apply' => new JsJobApplication(),
                        'jobseeker' => User::findOne(Yii::$app->user->id),
                        'requiredskills' => $reqresult,
                        'educationfields' => $educationfield,
                        'mediator' => User::findOne(Yii::$app->user->id),
                        'employer' => User::findOne(Yii::$app->user->id),
                        'summary' => JsSummary::find()->myProfile()->one()
            ]);
        }
    }

    function actionUpdateStatus() {
        $request = Yii::$app->request;
        $pks = $request->post('selected_jobs'); // Array or selected records primary keys
        $selected_status = $request->post('selected_status');

        if (count($pks) > 0) {
            foreach ($pks as $pk) {
                $model = $this->findModel($pk);
                if ($model->recruitment_stage != \common\models\ServiceJob::JOB_RECRUITMENT_STAGE_CLOSED) {
                    $model->action_id = intval($selected_status);
                    if (!$model->save(false)) {
                        var_dump($model->errors);
                        die;
                    }
                }
            }
        }

        return $this->redirect(['my-jobs']);
    }

    function actionApply() {
        $request = Yii::$app->request;
        $selected_job_id = $request->post('job_id');
        $motivation = $request->post('motivation');
        $user_id = Yii::$app->user->id;
        $selected_job = ServiceJob::findOne($selected_job_id);

        $model = new JsJobApplication();
        $model->motivation = $motivation;
        $model->job_id = $selected_job_id;
        $model->job_application_status_id = 1;
        $model->user_id = $user_id;
        $model->s_opportunity_id = $selected_job->s_opportunity_id;

        if (!$model->save(false)) {
            var_dump($model->errors);
            die;
        }

        return $this->redirect(['/jobseeker/user-profile/applications']);
    }

    function actionBulkChangeApplicationStatus() {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('selected_application')); // Array or selected records primary keys
        $selected_status = $request->post('selected_status');

        foreach ($pks as $pk) {

            $model = JsJobApplication::findOne($pk);
            $model->status_id = intval($selected_status);
            if (!$model->save(false)) {
                var_dump($model->errors);
                die;
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    function actionChangeStatus() {
        $request = Yii::$app->request;
        $model = new JobApplicationStatus();

        if ($model->load($request->post())) {
            if (!$model->save()) {
                var_dump($model->errors);
                die;
            } else {
                //Update the application status
                $job_application = JsJobApplication::findOne($model->job_application_id);
                $job_application->job_application_status_id = $model->id;
                $job_application->save(false);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    function actionExtendDeadline() {
        $request = Yii::$app->request;
        $job_id = $request->post('job_id');
        $closure_date = $request->post('closure_date');

        //Update the application status
        $job = ServiceJob::findOne($job_id);

        if (new DateTime($closure_date) < new DateTime($job->closure_date)) {
            Yii::$app->session->setFlash('error', "Application deadline extention can't be smaller than the current deadline");
            return $this->redirect(Yii::$app->request->referrer);
        }
        $job->closure_date = $closure_date;
        if ($job->save(false)) {
            Yii::$app->session->setFlash('success', "Application deadline extended succesfully");
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            var_dump($job->errors);
            die;
        }
    }

    function actionCloseJob() {
        $request = Yii::$app->request;
        $service_job = ServiceJob::findOne($request->post('job_id'));
        $service_job->recruitment_stage = ServiceJob::JOB_RECRUITMENT_STAGE_CLOSED;
        $can_be_closed = true;
        $issues = array();
        //Before closure, We must ensure that all applicants has statuses and At least some are hired
        $job_applicants_status = JsJobApplication::find()->select('js_job_application.*, job_application_status.status_id, job_application_status.id as js_id')
                        ->leftJoin('job_application_status', 'job_application_status.id = js_job_application.job_application_status_id')
                        ->where(['js_job_application.job_id' => $service_job->id])->asArray()->all();

        $job_applicants_placement_status = JsJobApplication::find()->select('js_job_application.*, job_application_status.status_id, job_application_status.id as js_id')
                        ->leftJoin('job_application_status', 'job_application_status.id = js_job_application.placement_status_id')
                        ->where(['job_application_status.status_id' => JsJobApplication::JOB_APPLICATION_STATUS_ACCEPTED])
                        ->andWhere(['js_job_application.job_id' => $service_job->id])->asArray()->all();

        if (count($job_applicants_status) > 0) {
            foreach ($job_applicants_status as $applicant) {
                echo $applicant['status_id'] . '-' . $applicant['js_id'] . '<br />';
                if ($applicant['status_id'] == SStatus::JOB_STATUS_WAITING) {
                    $can_be_closed = false;
                    $issues['shortlisting'] = "Some applications not yet checked <a href='" . Yii::$app->link->frontendUrl('/service/service-job/job-applicant?job=' . $service_job->id) . "'>Click here</a> to review them";
                    Yii::$app->session->setFlash('shortlisting_error', "Some applications not yet checked <a href='" . Yii::$app->link->frontendUrl('/service/service-job/job-applicant?job=' . $service_job->id) . "'>Click here</a> to review them");
                }
            }
        }
        if (count($job_applicants_placement_status) > 0) {
            foreach ($job_applicants_placement_status as $applicant) {
                echo $applicant['status_id'] . '-' . $applicant['js_id'] . '<br />';
                if (intval($applicant['status_id']) == 0) {
                    $can_be_closed = false;
                    $issues['placement'] = "Please complete the placement status for all selected applicants";
                    Yii::$app->session->setFlash('placement_error', "Please complete the placement status for all selected applicants");
                }
            }
        }
        if ($can_be_closed) {
            if (!$service_job->save(false)) {
                var_dump($service_job->errors);
                die;
            }
            Yii::$app->session->setFlash('success', "Opportunty closed successfully");
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    function actionNotifyApplicant() {


        $request = Yii::$app->request;
        $service_job = ServiceJob::findOne($request->post('job_id'));
        $email_queued = true;
        $job_applicants = JsJobApplication::find()->where(['job_id' => $service_job->id])->all();
        if (count($job_applicants) > 0) {
            foreach ($job_applicants as $candidate) {
                $current_user = UserProfile::findOne($candidate->user_id);
                $current_user_login = User::findOne($candidate->user_id);
                $message = "Dear " . $current_user->firstname . ' ' . $current_user->lastname . ",<br /><br />"
                        . "This is notification serves to inform you that, there are changes on your Job Application in Kora Job Portal."
                        . "<br /> <a href='" . Yii::$app->homeUrl . '/jobseeker/user-profile/applications' . "' target='_blank'>Click here</a> to access your job applications"
                        . "<br /><br />Please don't reply to this email as it is a System Generated<br /><br />Kora Job Portal";
                $message_title = 'Job application status change - Kora Job Portal';
                $notification = new \common\models\SNotifications();
                $notification->opportunity_id = $service_job->id;
                $notification->user_id = $current_user->user_id;
                $notification->message_body = $message;
                $notification->message_title = $message_title;
                if ($notification->save(false)) {
                    //Send email
                    $send_email = Yii::$app->commandBus->handle(new SendEmailCommand([
                                'subject' => $message_title,
                                'to' => $current_user_login->email,
                                'body' => $message
                    ]));

                    if ($send_email) {
                        //Update the notification in db
                        $notification->mail_sent = \common\models\SNotifications::MAIL_SENT;
                        $notification->save(false);
                    } else {
                        $email_queued = false;
                        Yii::$app->session->setFlash('placement_error', "An error occured while sending notifications");
                    }
                } else {
                    var_dump($service_job->errors);
                    die;
                }
            }
        }
        if ($email_queued) {
            $service_job->results_notified = ServiceJob::RESULTS_NOTIFIED;
            $service_job->save(false);
            Yii::$app->session->setFlash('success', "Notifications successfuly sent");
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    function actionChangePlacementStatus() {
        $request = Yii::$app->request;
        $model = new JobApplicationStatus();

        if ($model->load($request->post())) {
            if (!$model->save(false)) {
                var_dump($model->errors);
                die;
            } else {
                //Update the application status
                $job_application = JsJobApplication::findOne($model->job_application_id);
                $job_application->placement_status_id = $model->id;
                $job_application->save(false);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionViewModal($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Job #" . $id,
                'content' => $this->renderAjax('_view', [
                    'model' => $this->findModel($id),
                ]),
            ];
        }
    }

    /**
     * Creates a new ServiceJob model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        Yii::$app->db->schema->refresh();
        $request = Yii::$app->request;

        $model = new ServiceJob();
        //$model->scenario = ServiceJob::SCENARIO_CREATE;

        if ($model->load($request->post())) {

            if (is_array($model->district)) {
                $transaction = Yii::$app->db->beginTransaction();

                for ($i = 0; $i < sizeof($model->district); $i++) {

                    $model1 = new ServiceJob();
                    $model1->district_id = (int) $model->district[$i];
                    $model1->positions_number = (int) $model->position[$i];
                    $model1->employer = $model->employer;
                    $model1->jobtitle = $model->jobtitle;
                    $model1->job_type_id = $model->job_type_id;
                    $model1->job_summary = $model->job_summary;
                    $model1->job_responsability = $model->job_responsability;
                    $model1->job_skill_requirement = $model->job_skill_requirement;
                    $model1->job_remuneration = $model->job_remuneration;
                    $model1->s_opportunity_id = $model->s_opportunity_id;
                    $model1->positions_number = $model->positions_number;
                    $model1->economic_sector_id = $model->economic_sector_id;
                    $model1->education_level_id = $model->education_level_id;
                    $model1->education_field_id = $model->education_field_id;
                    $model1->closure_date = $model->closure_date;
                    $model1->how_to_apply = $model->how_to_apply;
                    $model1->contact_phone = $model->contact_phone;
                    $model1->contact_email = $model->contact_email;
                    $model1->action_id = $model->action_id;
                    $model1->years_of_experience = $model->years_of_experience;
                    $model1->isco08level1_id = $model->isco08level1_id;
                    $model1->isco08level2_id = $model->isco08level2_id;
                    $model1->isco08level3_id = $model->isco08level3_id;
                    $model1->posting_date = $model->posting_date;
                    $model1->other_source = $model->other_source;
                    $model1->deleted_by = 0;

                    if ($model1->save()) {
                        $notifier = new Notifier(new NewOpportunityNotification($model));
                        //$notifier->sendEmails('pkarinda@gmail.com');
                        //Save Job Skills
                        $skills = $request->post('JobSkills');

                        $skill_save = true;
                        if (isset($skills) && count($skills) > 0) {
                            foreach ($skills as $skill) {
                                $jobskill = new JobSkills();
                                $jobskill->job_id = $model1->getPrimaryKey();
                                $jobskill->skill_id = $skill;

                                if (!$jobskill->save()) {
                                    $skill_save = false;
                                }
                            }
                        }

                        if (intval($model1->action_id) == 1) {
                            //Set the publication date
                            $model1->action_id = date('Y-m-d H:i:s');
                            $model1->save();
                        }
                        if (!$skill_save) {
                            $transaction->rollback();
                        }
                        return $this->render('create', ['model' => $model]);
                    } else {
                        var_dump($model1->errors);
                        die;
                    }
                }

                $transaction->commit();
            } else {
                //saving document to it's path
                $model->doc_path = UploadedFile::getInstance($model, 'docFile');

                $filename = str_replace(" ", "", $model->doc_path);
                if (strlen($filename) > 0) {
                    $model->doc_path->saveAs('storage/source/1/' . $filename);

                    $model->doc_path = $filename;
                }
                if (intval($model->action_id) == 1) {
                    $model->posting_date = date('Y-m-d H:i:s');
                }
                if (!$model->save()) {
                    var_dump($model->errors);
                    die;
                } else {
                    //$notifier = new Notifier(new NewOpportunityNotification($model));
                    //$notifier->sendEmails('pkarinda@gmail.com');

                    Yii::$app->commandBus->handle(new AddToTimelineCommand([
                                'category' => 'Opportunity',
                                'event' => 'Add',
                                'data' => [
                                    'opportunity_id' => $model->id,
                                    'user_id' => Yii::$app->user->identity->id,
                                    'created_at' => time(),
                                ]
                    ]));

                    //Save skills
                    $skills = $request->post('JobSkills');

                    $skill_save = true;
                    if (isset($skills) && count($skills) > 0) {
                        foreach ($skills as $skill) {
                            $jobskill = new JobSkills();
                            $jobskill->job_id = $model->id;
                            $jobskill->skill_id = $skill;
                            echo $skill . '<br />';
                            if (!$jobskill->save()) {
                                $skill_save = false;
                            }
                        }
                    }
                    //saving to  job_education_fields
                    $educafields = $request->post('EducationField');
//                        var_dump($educafields);
//                        exit;
                    $edufield_save = true;
                    if (isset($educafields) && count($educafields) > 0) {
                        foreach ($educafields as $educafield) {
                            $edufill = new JobEducationField();
                            $edufill->job_id = $model->id;
                            $edufill->field_id = $educafield;

                            if (!$edufill->save()) {
                                $edufield_save = false;
                            }
                        }
                    }
                    //end
                    //end
                    if (intval($model->action_id) == 1) {
                        //Set the publication date
                        $model->action_id = date('Y-m-d H:i:s');
                        $model->save();

                        chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                        if (substr(php_uname(), 0, 7) == "Windows") {
                            //windows
                            pclose(popen("start /B php yii jobportal/notify-matching-skills 1> log.txt 2>&1 &", "r"));
                            //shell_exec('php yii jobportal/send-mail-notifications &');
                        } else {
                            //linux
                            shell_exec("php yii jobportal/notify-matching-skills > log.txt 2>&1 &");
                        }
                    }
                    return $this->redirect(['/service/service-job/my-jobs']);
                    //return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionJobFromOtherSource() {
        $request = Yii::$app->request;
        $model = new ServiceJob();

        if ($model->load($request->post())) {

            $model->employerlogo_path = Yii::$app->myfield->myupload($model, 'employer_logo');
            $model->employer_logo = 'logo';
            $model->link = trim($model->link);
            //saving document to it's path

            $model->doc_path = UploadedFile::getInstance($model, 'docFile');
            $filename = str_replace(" ", "", $model->doc_path);
            if (strlen($filename) > 0) {
                $model->doc_path->saveAs('storage/source/1/' . $filename);

                $model->doc_path = $filename;
            }

            if (!$model->save()) {
                //var_dump($model->errors);
            } else {
                /* $notifier = new Notifier(new NewOpportunityNotification($model));
                  $notifier->sendEmails('pkarinda@gmail.com');
                 */
                Yii::$app->commandBus->handle(new AddToTimelineCommand([
                            'category' => 'Opportunity',
                            'event' => 'Add from other source',
                            'data' => [
                                'opportunity_id' => $model->id,
                                'user_id' => Yii::$app->user->identity->id,
                                'created_at' => time(),
                            ]
                ]));

                return $this->redirect(['/service/service-job/my-jobs']);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ServiceJob model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        //Yii::$app->db->schema->refresh();
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update ServiceJob #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $model->employerlogo_path = Yii::$app->myfield->myupload($model, 'employer_logo');
                $model->employer_logo = 'logo';
                $model->link = 'http://' . trim($model->link);
                if (!$model->save()) {
                    var_dump($model->errors);
                    die;
                }
                $existing_job_skills = JobSkills::findByJobId($model->id);

                if (count($existing_job_skills) > 0) {
                    foreach ($existing_job_skills as $exiting_skill) {
                        $job_skill = JobSkills::findOne($exiting_skill['id']);
                        $job_skill->delete();
                    }
                }
                $skills = $request->post('JobSkills');

                if (count($skills) > 0) {
                    foreach ($skills as $skill) {
                        $jobskill = new JobSkills();
                        $jobskill->job_id = $model->id;
                        $jobskill->skill_id = $skill;

                        $jobskill->save();
                    }
                }
                if (intval($model->action_id) == 1) {
                    //echo exit();
                    //Set the publication date
                    $model->publication_date = date('Y-m-d H:i:s');
                    $model->save(false);
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "ServiceJob #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update ServiceJob #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post())) {
                $model->employerlogo_path = Yii::$app->myfield->myupload($model, 'employer_logo');
                $model->employer_logo = 'logo';
                $model->link = 'http://' . trim($model->link);
                if (!$model->save()) {
                    var_dump($model->errors);
                    die;
                } else {

                    $existing_job_skills = JobSkills::findByJobId($model->id);

                    if (count($existing_job_skills) > 0) {
                        foreach ($existing_job_skills as $exiting_skill) {
                            $job_skill = JobSkills::findOne($exiting_skill['id']);
                            $job_skill->delete();
                        }
                    }
                    $skills = $request->post('JobSkills');

                    if (isset($skills) && count($skills) > 0) {
                        foreach ($skills as $skill) {
                            $jobskill = new JobSkills();
                            $jobskill->job_id = $model->id;
                            $jobskill->skill_id = $skill;

                            $jobskill->save();
                        }
                    }
                    if (intval($model->action_id) == 1) {
                        //Set the publication date
                        $model->publication_date = date('Y-m-d H:i:s');
                        $model->save(false);

                        //Check if there are already users
                        $job_applicants = JsJobApplication::find()->where(['job_id' => $model->id])->all();
                        if (count($job_applicants) > 0) {
                            foreach ($job_applicants as $candidate) {
                                $current_user = UserProfile::findOne($candidate->user_id);
                                $message = "Dear " . $current_user->firstname . ' ' . $current_user->lastname . ",<br /><br />"
                                        . "This is notification serves to inform you that, there are changes on the job you applied on in Kora Job Portal."
                                        . "<br /> <a href='" . Yii::$app->homeUrl . '/service/service-job/view?id=' . $model->id . "' target='_blank'>Click here</a> to access the Job details"
                                        . "<br /><br />Please don't reply to this email as it is a System Generated<br /><br />Kora Job Portal";
                                $message_title = 'Changes on the job you applied on- Kora Job Portal';
                                $notification = new \common\models\SNotifications();
                                $notification->opportunity_id = $model->id;
                                $notification->notification_type = \common\models\SNotifications::NOTIFICATION_TYPE_APPLIED_JOB_UPDATED;
                                $notification->user_id = $current_user->user_id;
                                $notification->message_body = $message;
                                $notification->message_title = $message_title;
                                if ($notification->save(false)) {
                                    //Lauch the send mail Job
                                    chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                                    if (substr(php_uname(), 0, 7) == "Windows") {
                                        //windows
                                        pclose(popen("start /B php yii jobportal/send-mail-notifications 1> log.txt 2>&1 &", "r"));
                                        //shell_exec('php yii jobportal/send-mail-notifications &');
                                    } else {
                                        //linux
                                        shell_exec("php yii jobportal/send-mail-notifications > log.txt 2>&1 &");
                                    }
                                    Yii::$app->session->setFlash('success', "Job details changed. Already applied users notified");
                                } else {
                                    var_dump($model->errors);
                                    die;
                                }
                            }
                        }
                    }
                    return $this->redirect(['/service/service-job/my-jobs']);
                }
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing ServiceJob model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        $this->findModel($id)->deleteWithRelated();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['my-jobs']);
        }
    }

    public function actionContactJobSeeker() {
        $model = new \common\models\SNotifications();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model->notification_type = \common\models\SNotifications::NOTIFICATION_TYPE_CUSTOM_USER_MESSAGE;
            if ($model->load($request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', "Message successfully sent");
                chdir('' . Yii::getAlias('@root') . DIRECTORY_SEPARATOR . '_protected' . DIRECTORY_SEPARATOR . 'console' . '');
                if (substr(php_uname(), 0, 7) == "Windows") {
                    //windows
                    pclose(popen("start /B php yii jobportal/send-mail-notifications $model->id 1> log.txt 2>&1 &", "r"));
                    //shell_exec('php yii jobportal/send-mail-notifications &');
                } else {
                    //linux
                    shell_exec("php yii jobportal/send-mail-notifications $model->id > log.txt 2>&1 &");
                }
            } else {
                var_dump($model->errors);
                die;
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Delete multiple existing ServiceJob model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete() {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the ServiceJob model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ServiceJob the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ServiceJob::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
