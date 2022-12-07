<?php

namespace frontend\modules\service\controllers;

// use common\commands\AddToTimelineCommand;


use backend\models\JobSkills;
use backend\models\SDistrict;
use backend\models\SEducationLevel;
use backend\models\SSkill;
use common\commands\AddToTimelineCommand;
use common\models\JsAddress;
use common\models\JsJobApplication;
use common\models\JsSummary;
use common\models\ServiceJob;
use common\models\MediatorJobseekerService;
use common\models\MediatorJobseekerServiceSearch;
use common\models\MediatorServiceClient;
use common\models\PrivateMediatorReport;
use common\models\ServiceJobSharing;
use common\models\SOpportunity;
use common\models\User;
use common\models\EmplEmployer;
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
use yii\web\Response;
use frontend\modules\jobseeker\models\search\UserProfileSearch;
use common\models\UserProfile;
use frontend\modules\user\models\LoginForm;

/**
 * ServiceJobController implements the CRUD actions for ServiceJob model.
 */
class MediatorServiceController extends Controller {

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
    public function actionPostService() {
       
        $this->layout = 'dashboard';
        $MediatorService = new MediatorJobseekerService();
        $user = User::findOne(Yii::$app->user->id);
        $mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;

        //Yii::$app->db->schema->refresh();
        return $this->render('post/index', [
                    'model' => $MediatorService,
                    'users' => \common\models\UserProfile::getUsersByMediator($mediator->id),
                    'mediator' => $mediator,
                    'is_placement_service' => 0,
                    'services' => \common\models\SServices::find()->where(['service_type' => 1])->asArray()->all(),
                    'selected_employer' => null,
                    'url' => '/service/mediator-service/create',
                    'profile' => User::findOne(Yii::$app->user->id),
                    'selected_users' => array(),
                    'opportinities' => SOpportunity::find()->firstType()->all()
        ]);
    }

    public function actionPostServicePrivate() {
        $this->layout = 'dashboard';
        $PrivateMediatorService = new PrivateMediatorReport();
        $user = User::findOne(Yii::$app->user->id);
        $mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;
        //Yii::$app->db->schema->refresh();
        $quarters = \common\models\ReportQuarter::find()->asArray()->all();
        $quarter_friendly_array = array();
        foreach ($quarters as $quarter) {
            $current_quarter = array();
            $current_quarter['id'] = $quarter['id'];
            $current_quarter['full_quarter_name'] = $quarter['quarter_name'] . ' - ' . $quarter['quarter_year'];
            array_push($quarter_friendly_array, $current_quarter);
        }
        return $this->render('post/private', [
                    'model' => $PrivateMediatorService,
                    'quarters' => $quarter_friendly_array,
                    'mediator' => $mediator,
                    'services' => \common\models\SServices::find()->where(['service_type' => 2])->asArray()->all(),
                    'url' => '/service/mediator-service/create-private',
                    'profile' => User::findOne(Yii::$app->user->id)
        ]);
    }

    public function actionCreate() {

        $request = Yii::$app->request;
        //$notifier = new Notifier(new NewOpportunityNotification($model));
        //$notifier->sendEmails('pkarinda@gmail.com');
        //Save skills
        $model = new MediatorJobseekerService();

        $user_ids = $request->post('user_ids');

        if (isset($user_ids) && count($user_ids) > 0) {
            $current_mediator_service = $request->post('MediatorJobseekerService');

            $service = \common\models\SServices::findOne($current_mediator_service['service_id']);

            if ($service->is_placement == 1 && (is_null($current_mediator_service['institution']) | strlen($current_mediator_service['institution']) < 2)) {
                Yii::$app->session->setFlash('error', 'Placement institution is mandatory');
                return $this->redirect(Yii::$app->request->referrer);
            }
            if ($model->load($request->post())) {
                if (!$model->save()) {
                    var_dump($model->errors);
                    die;
                } else {
                    foreach ($user_ids as $user_id) {

                        $mediator_service_client = new MediatorServiceClient();
                        $mediator_service_client->user_id = $user_id;
                        $mediator_service_client->mediator_jobseeker_service_id = $model->id;

                        if (!$mediator_service_client->save(false)) {
                            var_dump($model->errors);
                            die;
                        }
                    }
                }
            }
        } else {
            echo 'You have to select job seekers';
            die;
        }
        return $this->redirect(['/service/mediator-service/serviced']);
        //return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionCreatePrivate() {

        $request = Yii::$app->request;
        $model = new PrivateMediatorReport();

        if ($model->load($request->post())) {
            if (!$model->save()) {
                var_dump($model->errors);
                die;
            }
        }
        return $this->redirect(['/service/mediator-service/private-serviced']);
    }

    public function actionUpdateService($id) {
        $this->layout = 'dashboard';

        $user = User::findOne(Yii::$app->user->id);

        $service = MediatorJobseekerService::findOne($id);
        $service_clients = MediatorServiceClient::findByService($service->id);
        $selected_clients = array();
        if (count($service_clients) > 0) {
            foreach ($service_clients as $client) {
                array_push($selected_clients, $client['user_id']);
            }
        }
        $mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;

        $selected_service = \common\models\SServices::findOne($service['service_id']);

        return $this->render('post/index', [
                    'model' => $service,
                    'is_placement_service' => $selected_service->is_placement,
                    'users' => \common\models\UserProfile::getUsersByMediator($mediator->id),
                    'mediator' => !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator,
                    'services' => \common\models\SServices::find()->where(['service_type' => 1])->asArray()->all(),
                    'url' => '/service/mediator-service/update?id=' . $id,
                    'profile' => User::findOne(Yii::$app->user->id),
                    'selected_users' => $selected_clients
        ]);
    }

    public function actionUpdateServicePrivate($id) {
        $this->layout = 'dashboard';

        $user = User::findOne(Yii::$app->user->id);

        $service = PrivateMediatorReport::findOne($id);
        $quarters = \common\models\ReportQuarter::find()->asArray()->all();
        $quarter_friendly_array = array();
        foreach ($quarters as $quarter) {
            $current_quarter = array();
            $current_quarter['id'] = $quarter['id'];
            $current_quarter['full_quarter_name'] = $quarter['quarter_name'] . ' - ' . $quarter['quarter_year'];
            array_push($quarter_friendly_array, $current_quarter);
        }

        return $this->render('post/private', [
                    'model' => $service,
                    'quarters' => $quarter_friendly_array,
                    'services' => \common\models\SServices::find()->where(['service_type' => 2])->asArray()->all(),
                    'mediator' => !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator,
                    'url' => '/service/mediator-service/update-private?id=' . $id,
                    'profile' => User::findOne(Yii::$app->user->id)
        ]);
    }

    /**
     * Displays a serviced jobseekers.
     * @param integer $name job seeker names
     * @param integer $s as service id
     * @param integer $g Gender
     * @param integer $fo From date
     * @param integer $to to date
     * @return mixed
     */
    public function actionServicedDetails($s = null, $g = null, $fo = null, $to = null, $name = null) {
        $this->layout = 'dashboard';

//Get the 
        $usersDataProvider = UserProfileSearch::findServicedByGender($g, $s, $fo, $to, $name);

        $usersDataProvider->query->orderBy(['lastname' => SORT_ASC]);
        $selected_service = \common\models\SServices::findOne($s);

        return $this->render('serviced_details', [
                    'applicants' => $usersDataProvider->getModels(),
                    'applicant_count' => $usersDataProvider->getTotalCount(),
                    'pagination' => $usersDataProvider->pagination,
                    'selected_service' => $selected_service,
                    'gender' => $g,
                    'from' => $fo,
                    'to' => $to,
        ]);
    }

    public function actionServicedDetailsD($s = null, $fo = null, $to = null, $name = null) {
        $this->layout = 'dashboard';

//Get the 
        $usersDataProvider = UserProfileSearch::findServicedByDisability($s, $fo, $to, $name);

        $usersDataProvider->pagination->pageSize = 10;

        $usersDataProvider->query->orderBy(['lastname' => SORT_ASC]);
        $selected_service = \common\models\SServices::findOne($s);

        return $this->render('serviced_details_disabled', [
                    'applicants' => $usersDataProvider->getModels(),
                    'applicant_count' => $usersDataProvider->getTotalCount(),
                    'pagination' => $usersDataProvider->pagination,
                    'selected_service' => $selected_service,
                    'from' => $fo,
                    'to' => $to,
        ]);
    }

    public function actionUpdate($id) {
        //Yii::$app->db->schema->refresh();
        $request = Yii::$app->request;
        $model = MediatorJobseekerService::findOne($id);
        $user_ids = $request->post('user_ids');

        /*
         *   Process for non-ajax request
         */
        if (isset($user_ids) && count($user_ids) > 0) {
            $current_mediator_service = $request->post('MediatorJobseekerService');

            $service = \common\models\SServices::findOne($current_mediator_service['service_id']);
            if ($service->is_placement == 1 && (is_null($current_mediator_service['institution']) | strlen($current_mediator_service['institution']) < 2)) {
                Yii::$app->session->setFlash('error', 'Placement institution is mandatory');
                return $this->redirect(Yii::$app->request->referrer);
            }
            if ($model->load($request->post())) {
                if (!$model->save()) {
                    var_dump($model->errors);
                    die;
                } else {

                    $service_clients = MediatorServiceClient::findByService($model->id);

                    if (count($service_clients) > 0) {
                        foreach ($service_clients as $client) {

                            $service_client = MediatorServiceClient::Find()->where(['id' => $client['id']])->one();
                            $service_client->delete();
                        }
                    }

                    foreach ($user_ids as $user_id) {

                        $mediator_service_client = new MediatorServiceClient();
                        $mediator_service_client->user_id = $user_id;
                        $mediator_service_client->mediator_jobseeker_service_id = $model->id;

                        if (!$mediator_service_client->save(false)) {
                            var_dump($model->errors);
                            die;
                        }
                    }
                    return $this->redirect(['/service/mediator-service/serviced']);
                }
            }
        } else {
            echo 'You have to select job seekers';
            die;
        }
    }

    public function actionUpdatePrivate($id) {
        //Yii::$app->db->schema->refresh();
        $request = Yii::$app->request;
        $model = PrivateMediatorReport::findOne($id);

        /*
         *   Process for non-ajax request
         */
        if ($model->load($request->post())) {
            if (!$model->save()) {
                var_dump($model->errors);
                die;
            } else {
                return $this->redirect(['/service/mediator-service/private-serviced']);
            }
        }
    }

    public function actionServiced($js = null, $from = null, $to = null) {
        $this->layout = 'dashboard';
        $searchModel = new MediatorJobseekerServiceSearch();
        $services = $searchModel->search(Yii::$app->request->queryParams);
        $user = User::findOne(Yii::$app->user->id);
        $services->query->andWhere(['mediator_jobseeker_service.deleted_by' => 0])->asArray()->all();

        if (isset($js)) {

            $services->query->leftJoin('mediator_service_client', 'mediator_jobseeker_service.id = mediator_service_client.mediator_jobseeker_service_id');
            $services->query->leftJoin('user_profile', 'mediator_service_client.user_id = user_profile.user_id');
            $services->query->andWhere(['like', 'concat(user_profile.firstname,user_profile.lastname)', '%' . htmlspecialchars($js) . '%', false]);
        }
        if (isset($from) && isset($to)) {

            $services->query->andWhere(['between', 'mediator_jobseeker_service.service_date', $from, $to]);
        }

        $user_mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;
        $services->query->andWhere(['mediator_jobseeker_service.mediator_id' => $user_mediator->id]);

        $services->query->orderBy(['mediator_jobseeker_service.service_date' => SORT_DESC]);

        return $this->render('serviced', [
                    'from' => $from,
                    'to' => $to,
                    'all_services' => $services->getModels(),
                    'mediator' => !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator,
                    'all_services_count' => $services->getTotalCount(),
                    'pagination' => $services->pagination,
        ]);
    }

    public function actionPrivateServiced($quarter = null) {
        $this->layout = 'dashboard';
        $searchModel = new PrivateMediatorReport();
        $user = User::findOne(Yii::$app->user->id);
        $mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;
        $services = $searchModel->search(Yii::$app->request->queryParams);
        $services->query->andWhere(['mediator_id' => $mediator->id])->asArray()->all();

        return $this->render('private_serviced', [
                    'all_services' => $services->getModels(),
                    'mediator' => !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator,
                    'all_services_count' => $services->getTotalCount(),
                    'pagination' => $services->pagination,
        ]);
    }

    public function actionServicedSummary($from = null, $to = null) {
        $this->layout = 'dashboard';
        $user = User::findOne(Yii::$app->user->id);
        $user_mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;

        $conn = \Yii::$app->db;
        $query = 'SELECT
	v_mediator_service.service_name,
	v_mediator_service.service_id,
	v_mediator_service.gender_id,
	v_mediator_service.disability_id,
	sum( CASE WHEN gender = "Male" THEN 1 ELSE NULL END ) AS "Male",
	sum( CASE WHEN gender = "Female" THEN 1 ELSE NULL END ) AS "Female",
	sum( CASE WHEN disability_id <> 0 THEN 1 ELSE NULL END ) AS "Disabled"
        FROM
	v_mediator_service ';

        $query .= ' where mediator_id = ' . $user_mediator->id;

        if (isset($from) && isset($to)) {

            $query .= ' and service_date between "' . $from . '" and "' . $to . '"';
        }

        $query .= ' GROUP BY v_mediator_service.service_name';
        $service_summary = $conn->createCommand($query)->queryAll();

        return $this->render('serviced_summary', [
                    'from' => $from,
                    'to' => $to,
                    'service_summary' => $service_summary
        ]);
    }

    public function actionIndex($type = null, $title = null, $category = null, $emp_type = null, $location = null, $sort = 'R') {

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
        $this->view->params['bgimage'] = "opportunities.png";
        $this->view->params['alt'] = "A man and two women, one has disability sitting in front of computer, searching for opportunities";

        $currentdate = date("Y-m-d");

        $searchModel = new ServiceJobSearch();

        if (isset($_GET['id'])) {
            $searchModel->occupation_grouping_id = $_GET['id'];
        }


        $published = $searchModel->searchAll(Yii::$app->request->queryParams, null, null, 0);
        $jobs_count = $searchModel->countAll();
        if (intval($type) > 0) {
            $published->query->andWhere(['s_opportunity_id' => $type]);
        }
        if (isset($title)) {
            $published->query->andWhere(['like', 'jobtitle', htmlspecialchars($title) . '%', false]);
        }
        $published->query->orderBy(['created_at' => SORT_DESC]);

        $districts = isset($_GET['displayAll']) ? SDistrict::find()->orderBy('district')->all() : SDistrict::find()->orderBy('district')->limit(5)->all();

        return $this->render('my_job', [
                    'data' => ArrayHelper::map(SEducationLevel::find()->all(), 'id', 'level'),
                    'summary' => JsSummary::find()->myProfile()->one(),
                    'profile' => User::findOne(Yii::$app->user->id),
                    'districts' => ArrayHelper::map($districts, 'id', 'district'),
                    'apply' => new JsJobApplication(),
                    'share' => new ServiceJobSharing(),
                    'selected_type' => $type,
                    'searchModel' => $searchModel,
                    'jobs' => $published->getModels(),
                    'jobs_count' => $published->getTotalCount(),
                    'pagination' => $published->pagination,
                    'opportinities' => SOpportunity::find()->firstType()->all(),
                    'jobgroups' => ServiceJob::find()->select('occupation_grouping_id,count(*) AS id')->where(['>=', 'closure_date', $currentdate])->andWhere(['action_id' => 1])->groupBy('occupation_grouping_id')->orderBy('occupation_grouping_id')->all(),
        ]);
    }

    public function actionJobApplicant($job = null, $name = null) {
        $this->layout = 'dashboard';
        $applicantModel = new JsJobApplication();
        $applicantProvider = $applicantModel->search(Yii::$app->request->queryParams);

        if (isset($job)) {
            $applicantProvider->query->andWhere(['job_id' => $job]);
        }
        if (isset($name)) {
            $applicantProvider->query->leftJoin('user_profile', 'user_profile.user_id = js_job_application.user_id')->where(['like', 'CONCAT(user_profile.lastname,user_profile.firstname)', '%' . htmlspecialchars($name) . '%', false]);
        }

        return $this->render('job_applicant', [
                    'selected_type' => null,
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

    public function actionPostOpportunityFromOtherSource() {
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
                $model->action_id = intval($selected_status);
                if (!$model->save(false)) {
                    var_dump($model->errors);
                    die;
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
        $model->status_id = 1;
        $model->user_id = $user_id;
        $model->s_opportunity_id = $selected_job->s_opportunity_id;

        if (!$model->save(false)) {
            var_dump($model->errors);
            die;
        }

        return $this->redirect(['/jobseeker/user-profile/applications']);
    }

    function actionChangeStatus() {
        $request = Yii::$app->request;
        $selected_application = $request->post('selected_application');
        $selected_status = $request->post('selected_status');

        $model = JsJobApplication::findOne(intval($selected_application));
        $model->status_id = intval($selected_status);
        if (!$model->save(false)) {
            var_dump($model->errors);
            die;
        }
        return $this->redirect(Yii::$app->request->referrer);
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
    public function actionJobFromOtherSource() {
        $request = Yii::$app->request;
        $model = new ServiceJob();

        if ($model->load($request->post())) {
            var_dump($request->post());
            exit();
            $model->employerlogo_path = Yii::$app->myfield->myupload($model, 'employer_logo');
            $model->employer_logo = 'logo';
            $model->link = trim($model->link);

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
     * Delete an existing ServiceJob model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        $request = Yii::$app->request;
        MediatorJobseekerService::findOne($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeletePrivate($id) {

        $request = Yii::$app->request;
        PrivateMediatorReport::findOne($id)->delete();

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
        $pks = explode(',', $request->post('selected_service')); // Array or selected records primary keys

        foreach ($pks as $pk) {
            MediatorJobseekerService::findOne($pk)->delete();
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
            return $this->redirect(Yii::$app->request->referrer);
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

    public function actionExportData() {
        $users = User::find()->asArray()->all();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;

        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Names');

        if (count($users) > 0) {
            $counter = 2;
            foreach ($users as $user) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $user['username']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $user['email']);
                $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter, $user['phone']);
                $counter++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "CustomFile.xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
        $objWriter->save('php://output');
        die();
    }

}
