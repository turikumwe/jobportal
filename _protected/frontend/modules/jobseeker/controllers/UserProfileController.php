<?php

namespace frontend\modules\jobseeker\controllers;

use Yii;
use backend\models\SDistrict;
use yii\helpers\ArrayHelper;
use backend\models\SEducationLevel;
use yii\data\Pagination;
use frontend\modules\jobseeker\models\search\UserProfileSearch;
use frontend\modules\user\models\AccountForm;
use frontend\modules\user\models\SignupForm;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use kartik\password\StrengthValidator;
use yii\web\NotFoundHttpException;
use common\models\UserProfile;
use common\models\JsEducation;
use common\models\JsAddress;
use yii\filters\VerbFilter;
use \common\models\User;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use frontend\modules\news\models\NewsNewsSearch;
use common\models\JsSummary;
use common\models\JsExperience;
use common\models\JsLanguage;
use common\models\JsSkill;
use common\models\JsTraining;
use common\models\ServiceJob;
use yii\web\UploadedFile;

$conn = \Yii::$app->db;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller {

    /**
     * @return array
     */
    public function actions() {
        return [
            'avatar-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::class
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                    'confirmation' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionRemoveitem() {
        if (Yii::$app->request->get('jobid')) {

            \common\models\JsJobApplication::deleteAll(['user_id' => Yii::$app->user->id, 'id' => Yii::$app->request->get('jobid')]);
            \Yii::$app->session->setFlash('flashMessage', 'Summary Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('favid')) {

            \common\models\FavoriteJobs::deleteAll(['user_id' => Yii::$app->user->id, 'job_id' => Yii::$app->request->get('favid')]);
            \Yii::$app->session->setFlash('flashMessage', 'Summary Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('summaryid')) {

            JsSummary::find()->where(['id' => Yii::$app->request->get('summaryid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Summary Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('skillid')) {
            JsSkill::find()->where(['id' => Yii::$app->request->get('skillid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Skill Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('experienceid')) {
            JsExperience::find()->where(['id' => Yii::$app->request->get('experienceid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Experience Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('languageid')) {
            JsLanguage::find()->where(['id' => Yii::$app->request->get('languageid')])->one()->delete();

            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('addresseid')) {
            JsAddress::find()->where(['id' => Yii::$app->request->get('addresseid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Address Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('trainingid')) {
            JsTraining::find()->where(['id' => Yii::$app->request->get('trainingid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Address Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('educationid')) {
            JsEducation::find()->where(['id' => Yii::$app->request->get('educationid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Education Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('endorsementid')) {
            \common\models\JsEndorse::find()->where(['id' => Yii::$app->request->get('endorsementid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Endorsement Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('recommendationid')) {
            \common\models\JsRecommendation::find()->where(['id' => Yii::$app->request->get('recommendationid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Skill Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->get('licenseid')) {
            \common\models\JsDrivingLicenseCategory::find()->where(['driving_license_id' => Yii::$app->request->get('licenseid')])->one()->delete();
            \common\models\JsDrivingLicense::find()->where(['id' => Yii::$app->request->get('licenseid')])->one()->delete();
            \Yii::$app->session->setFlash('flashMessage', 'Skill Deleted');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionFavjobs() {
        //update service job to 1 as fav 

        $conn = \Yii::$app->db;
        $userid = Yii::$app->user->id;
        $jobid = Yii::$app->request->get('jobid');

        $favjo = 'insert into favoritejobs(job_id,user_id) value("' . $jobid . '","' . $userid . '")';
        $res = $conn->CreateCommand($favjo)->execute();
        \Yii::$app->session->setFlash('flashMessage', 'Job added to favorites jobs');

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionFavourites() {

        $this->layout = 'dashboard';
        $userid = $user_id = Yii::$app->user->id;
        $conn = \Yii::$app->db;
        $notification = 'select o.id,s.created_at,o.name,o.type from s_opportunity as o,s_notifications as s where s.user_id="' . Yii::$app->user->id . '" and s.opportunity_id=o.id';
        $notiresult = $conn->createCommand($notification)->queryAll();
        $alljobs = 'select s.posting_date,s.job_type_id,s.closure_date,s.id,s.jobtitle,s.occupation_grouping_id,s.employer from service_job as s,favoritejobs as f where s.id=f.job_id and f.user_id="' . Yii::$app->user->id . '"';
        $jobresult = $conn->createCommand($alljobs)->queryAll();

        return $this->render('favjobs', [
                    'userid' => $userid,
                    'jobresult' => $jobresult,
                    'notiresult' => $notiresult,
                    'account' => $accountForm = new AccountForm(),
                    'jobseeker' => User::findOne($userid),
        ]);
    }

    public function actionJobs() {
        $this->layout = 'dashboard';
        $user_id = Yii::$app->user->id;

        return $this->render('jobs', ['userid' => $user_id, 'jobseeker' => User::findOne($user_id),]);
    }

    public function actionApplications($title = null) {
        $this->layout = 'dashboard';
        $totalCount = 0;
        //$page = Yii::$app->request->get('page', 1);
        $connection = Yii::$app->db;
        //$limit = Yii::$app->request->get('per-page', 1);
        $limit = 10;
        // $from = ($page-1)*$limit; 
        $from = (isset($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        $user_id = Yii::$app->user->id;
        //if title is set
        if (isset($title)) {
            $sql = 'select j.id,j.job_id,j.job_application_status_id from js_job_application as j,service_job as s where j.user_id="' . $user_id . '" and j.job_id=s.id and s.jobtitle LIKE "' . $title . '%"';
            $command = $connection->createCommand($sql);
            $result = $command->queryAll();
            return $this->render('applications', [
                        'userid' => $user_id,
                        'title' => $title,
                        'account' => $accountForm = new AccountForm(),
                        'jobseeker' => User::findOne($user_id),
                        'allapp' => $result,
                        'totalapplied' => \common\models\JsJobApplication::find()->where(['user_id' => $user_id])->count(),
            ]);
        } else {
            $sql = 'select j.id,j.job_id,j.job_application_status_id from js_job_application as j,service_job as s where user_id="' . $user_id . '" and j.job_id=s.id';
            $command = $connection->createCommand($sql . ' LIMIT ' . $from . ',' . $limit);
            $count = $connection->createCommand('SELECT COUNT(*) as total FROM (' . $sql . ') a')->queryAll();
            $totalCount = $count[0]['total'];
            $pages = new Pagination(['totalCount' => $totalCount, 'pageSize' => $limit]);
            $result = $command->queryAll();
            return $this->render('applications', [
                        'userid' => $user_id,
                        'pagination' => $pages,
                        'account' => $accountForm = new AccountForm(),
                        'jobseeker' => User::findOne($user_id),
                        'allapp' => $result,
                        'totalapplied' => \common\models\JsJobApplication::find()->where(['user_id' => $user_id])->limit(1)->count(),
            ]);
        }
    }

    public function actionIndex($js = null) {
        //Yii::$app->db->schema->refresh();
        $this->layout = 'dashboard';
        $accountForm = new AccountForm();

        if (is_null($js)) {

            $accountForm->setUser(Yii::$app->user->identity);
        } else {

            $accountForm->setUser(User::findOne($js));
            Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                        'category' => 'profile',
                        'event' => 'profile-view',
                        'data' => [
                            'user_id' => $js,
                            'created_at' => time(),
                        ]
            ]));
        }

        $user_id = is_null($js) ? Yii::$app->user->id : $js;

        if ($accountForm->load(Yii::$app->request->post()) && $accountForm->save()) {

            return $this->refresh();
        }
        //jobseekersummary
        $conn = \Yii::$app->db;
        $summary = 'select * from js_summary where user_id="' . $user_id . '"';
        $summ = $conn->createCommand($summary)->queryAll();
        //jobseeker skills
        $skill = 'select j.id,s.skill,l.level  from s_skill as s ,js_skill as j,s_skill_level as l where j.skill_id=s.id and j.skill_level_id=l.id and j.user_id="' . $user_id . '"';
        $skillresult = $conn->createCommand($skill)->queryAll();
        //jobseeker experience
        $exp = 'select j.id,c.occupation,j.start_date,j.end_date,j.company,i.experience_interval   from s_isco08_level4 as c,js_experience as j,s_experience_interval as i where j.occupation_id=c.id and j.experience_in_this_occupation=i.id and j.user_id="' . $user_id . '" ';
        $experience = $conn->createCommand($exp)->queryAll();
        //education
        $education = 'select j.start_date,j.end_date,j.id,j.school,j.country_id,l.level,e.field,j.certificate_id from js_education as j,s_education_field as e,s_education_level as l where j.education_level_id=l.id and j.education_field_id=e.id and j.user_id="' . $user_id . '"';
        $edu = $conn->createCommand($education)->queryAll();
        //training
        $trainingz = 'select * from js_training where user_id="' . $user_id . '"';
        $trainresult = $conn->createCommand($trainingz)->queryAll();

        return $this->render('index', [
                    'jobseeker' => User::findOne($user_id),
                    'account' => $accountForm,
                    'idOtherProfile' => $user_id,
                    'summary' => $summ,
                    'skills' => $skillresult,
                    'experience' => $experience,
                    'education' => $edu,
                    'trainings' => $trainresult
        ]);
    }

    public function actionAdmin() {
        // $this->layout='@frontend/modules/service/views/layouts/subpage';
        // $this->view->params['bgimage'] = "howtoapply.png";

        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'employer' => User::findOne(Yii::$app->user->id),
        ]);
    }

    public function actionAdminEmployer() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('adminemployer', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'employer' => User::findOne(Yii::$app->user->id),
        ]);
    }

    public function actionRegister() {
        $model = new SignupForm();
        $identification = new UserProfile();
        $education = new JsEducation();
        $address = new JsAddress();
        $trans = Yii::$app->db->beginTransaction();
        try {

            if ($model->load(Yii::$app->request->post())) {

                $address->load(Yii::$app->request->post());
                $education->load(Yii::$app->request->post());
                $identification->load(Yii::$app->request->post());

                if (!$identification->ageRestriction()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t('frontend', 'Your age should be above 15 or under 60 years old.'
                        ),
                        'options' => ['class' => 'alert-danger']
                    ]);

                    return $this->render('../register/register', [
                                'model' => $model,
                                'identification' => $identification,
                                'education' => $education,
                                'address' => $address
                    ]);
                }

                $user = $model->signup(User::ROLE_USER);

                if (is_null($user)) {
                    return $this->render('../register/register', [
                                'identification' => $identification,
                                'education' => $education,
                                'address' => $address,
                                'model' => $model
                    ]);
                }
                $identification->locale = Yii::$app->language;
                $identification->user_id = $user->id;
                $identification->created_by = $user->id;
                $identification->updated_by = $user->id;
                $identification->save();

                $education->user_id = $user->id;
                $education->created_by = $user->id;
                $education->updated_by = $user->id;
                $education->save();

                $address->user_id = $user->id;
                $address->created_by = $user->id;
                $address->updated_by = $user->id;
                $address->emailAddress = $model->email;
                $address->phoneNumber = $model->phone;
                $address->save();

                $trans->commit();

                if ($user) {
                    if ($model->shouldBeActivated()) {
                        Yii::$app->getSession()->setFlash('alert', [
                            'body' => Yii::t(
                                    'frontend',
                                    'Your account has been successfully created. Check your email for further instructions.'
                            ),
                            'options' => ['class' => 'alert-success']
                        ]);
                    } else {
                        Yii::$app->getUser()->login($user);
                    }

                    $model = new SignupForm();
                    $identification = new UserProfile();
                    $education = new JsEducation();
                    $address = new JsAddress();

                    return $this->render('../register/register', [
                                'identification' => $identification,
                                'education' => $education,
                                'address' => $address,
                                'model' => $model
                    ]);
                }
            }
        } catch (Exception $exc) {
            $trans->rollBack();
        }

        return $this->render('../register/register', [
                    'identification' => $identification,
                    'education' => $education,
                    'address' => $address,
                    'model' => $model,
        ]);
    }

    /**
     *
     * Deactivate account
     *
     */
    public function actionTerminate() {
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        if ($user) {
            $user->status = User::STATUS_DELETED;
            if ($user->save(false)) {
                $user->userProfile->terminate = 0;
                if ($user->userProfile->save(false)) {
                    Yii::$app->user->logout();
                }
            }
            return $this->goHome();
        }
        return null;
    }

    public function actionActivate($id) {
        $user = User::find()->where(['id' => (int) $id])->one();
        $user->status = User::STATUS_ACTIVE;
        $user->save(false);
        return true;
    }

    public function actionHideAndShow($variable, $column) {
        $model = Yii::$app->user->identity->userProfile;
        $model->$column = $variable;
        if ($model->save()) {
            return true;
        }
    }

    /**
     * Displays a single UserProfile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "UserProfile #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new UserProfile model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpload() {
        $model = new UserProfile();
        $request = Yii::$app->request;
        $user = Yii::$app->user->id;

        if ($model->load($request->post())) {
            //$model->profile = Yii::$app->myfield->myupload($model, 'profile');
            $model->profile = UploadedFile::getInstance($model, 'profile');
            $filename = str_replace(" ", "", $model->profile);
            $path = Yii::getAlias('@frontend') . '/images';
            $model->profile->saveAs(Yii::getAlias('static/profiles/' . $filename));
            $uplogo = 'update user_profile set profile="' . $model->profile . '" where user_id="' . Yii::$app->user->id . '"';
            $logo = Yii::$app->db->createCommand($uplogo)->execute();

            return $this->redirect(Yii::$app->request->referrer);
        } else {

            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new UserProfile();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new UserProfile",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new UserProfile",
                    'content' => '<span class="text-success">Create UserProfile success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new UserProfile",
                    'content' => $this->renderAjax('create', [
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->user_id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing UserProfile model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($idOtherProfile = null) {
        $request = Yii::$app->request;

        if (Yii::$app->user->can('user')) {

            $model = Yii::$app->user->identity->userProfile;
            $url = Yii::$app->link->frontendUrl('/jobseeker/user-profile');
        } else {

            $model = $this->findModel($_GET['idOtherProfile']);
            $url = Yii::$app->link->frontendUrl('/jobseeker/user-profile/index?idOtherProfile=' . $idOtherProfile);
        }

        if ($model->load($request->post()) && $model->save()) {

            $locale = 'us-EN';
            Yii::$app->session->setFlash('forceUpdateLocale');
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('frontend', 'Your account has been successfully saved', [], $locale)
            ]);

            return $this->redirect($url);
        } else {
            //jobseekersummary


            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Delete an existing UserProfile model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

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
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     *  
     * Export UserProfile information into PDF format. 
     * @param integer $id
     * @return mixed 
     */
    public function actionPdf($id, $html = null) {
        $model = $this->findModel($id);

        if (!is_null($html)) {
            return $this->render('_pdf', [
                        'model' => $model,
            ]);
        }

        $content = $this->renderPartial('_pdf', [
            'model' => $model,
        ]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssInline' => '.thcolor{background-color::#F1F5F8}',
            //'cssFile' => 'bundle/kv-mpdf-bootstrap.min.css', 
            'options' => ['title' => 'Curriculum Vitae'],
            'methods' => [
                'SetHeader' => ['Curriculum Vitae||Generated On: ' . date("r")],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // a quick fix
        Yii::$app->response->headers->add('Content-Type', 'application/pdf');

        return $pdf->render();
    }

    public function actionMoreOptions() {
        $searchModel = new UserProfileSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('moreoptionsearch', ['searchModel' => $searchModel,]);
    }

    public function actionDashboard() {
        $this->layout = 'dashboard';
        //related job application
        $userin = \Yii::$app->user->identity->id;
        $conn = \Yii::$app->db;
        //$relatedskills='select COUNT(DISTINCT(j.job_id)) as total from service_job as s,jobskills as j,js_skill as l where s.id=j.job_id and j.skill_id=l.skill_id and l.user_id="'.$userin.'"';
        $relatedskills = 'select count(*) as total from js_job_application where user_id="' . $userin . '"';
        $skillresult = $conn->createCommand($relatedskills)->queryAll();
        $searchModel = new NewsNewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $addresses = NULL;

        // $summary = New JsSummary();
        $summary = JsSummary::find()->where(['user_id' => Yii::$app->user->identity->id])->count();
        $experience = JsExperience::find()->where(['user_id' => Yii::$app->user->identity->id])->count();
        $education = JsEducation::find()->where(['user_id' => Yii::$app->user->identity->id])->count();
        $training = JsTraining::find()->where(['user_id' => Yii::$app->user->identity->id])->count();
        $language = JsLanguage::find()->where(['user_id' => Yii::$app->user->identity->id])->count();
        $skill = JsSkill::find()->where(['user_id' => Yii::$app->user->identity->id])->count();
        $address = JsAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->count();

        $oppforabroad = ServiceJob::find()
                ->where(['competency_level_id' => 2])
                ->andWhere(['action_id' => 1])
                ->andWhere(['>=', 'closure_date', date('Y-m-d')])
                ->count();

        $completed = array();
        if ($summary >= 1)
            $completed[] = "Summary <span class='glyphicon glyphicon-ok'></span>";
        if ($experience >= 1)
            $completed[] = "Professional experience ($experience) <span class='glyphicon glyphicon-ok'></span>";
        if ($education >= 1)
            $completed[] = "Education ($education) <span class='glyphicon glyphicon-ok'></span>";
        if ($training >= 1)
            $completed[] = "Training ($training) <span class='glyphicon glyphicon-ok'></span>";
        if ($language >= 1)
            $completed[] = "Language ($language) <span class='glyphicon glyphicon-ok'></span>";
        if ($skill >= 1)
            $completed[] = "Skill ($skill) <span class='glyphicon glyphicon-ok'></span>";

        if ($address >= 1) {
            $completed[] = "Address <span class='glyphicon glyphicon-ok'></span>";
            $addresses = JsAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        }

        $profile = count($completed);

        $missing = array();
        if ($summary == 0)
            $missing[] = 'CV';
        if ($experience == 0)
            $missing[] = 'Professional experience';
        if ($education == 0)
            $missing[] = 'Education';
        if ($training == 0)
            $missing[] = 'Training';
        if ($language == 0)
            $missing[] = 'Language';
        if ($skill == 0)
            $missing[] = 'Skill';
        if ($address == 0)
            $missing[] = 'Address';
        $user_id = is_null($userin) ? Yii::$app->user->id : $userin;

        //jobs related to what he/she has studied
        $study = 'select DISTINCT(j.job_id) as jobid,s.jobtitle,s.employer,s.job_type_id,s.occupation_grouping_id from service_job as s,js_job_application as j where s.id=j.job_id and j.user_id="' . $userin . '"';
        $resstudy = $conn->createCommand($study)->queryAll();
        //notification
        $notes = 'select count(*) as total from s_notifications where user_id="' . $user_id . '"';
        $noteresult = $conn->createCommand($notes)->queryAll();

        return $this->render('dashboard', [
                    'searchModel' => $searchModel,
                    'jobseeker' => User::findOne($user_id),
                    'dataProvider' => $dataProvider,
                    'profile' => $profile * 100 / 7,
                    'completed' => $completed,
                    'missing' => $missing,
                    'account' => $accountForm = new AccountForm(),
                    'oppforabroad' => $oppforabroad,
                    'addresses' => $addresses,
                    'notifications' => $noteresult,
                    'relatedskills' => $skillresult,
                    'relatedjob' => $resstudy,
        ]);
    }

}
