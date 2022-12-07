<?php

namespace frontend\modules\abroad\controllers;

use Yii;
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
            ],
            'cv-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'cv-delete',
            ],
            'cv-delete' => [
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
                ],
            ],
        ];
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex($idOtherProfile = null) {
        $accountForm = new AccountForm();

        if (is_null($idOtherProfile)) {

            $accountForm->setUser(Yii::$app->user->identity);
        } else {

            $accountForm->setUser(User::findOne($idOtherProfile));

            Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                        'category' => 'profile',
                        'event' => 'profile-view',
                        'data' => [
                            'user_id' => $idOtherProfile,
                            'created_at' => time(),
                        ]
            ]));
        }

        $user_id = is_null($idOtherProfile) ? Yii::$app->user->id : $idOtherProfile;

        if ($accountForm->load(Yii::$app->request->post()) && $accountForm->save()) {

            return $this->refresh();
        }

        return $this->render('index', [
                    'jobseeker' => User::findOne($user_id),
                    'account' => $accountForm,
                    'idOtherProfile' => $user_id
        ]);
    }

    public function actionAdmin() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchAbroad(Yii::$app->request->queryParams);

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
        $user = User::find()->where(['id' => $id])->one();
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

        if (Yii::$app->user->can('abroad')) {

            $model = Yii::$app->user->identity->userProfile;
            $url = Yii::$app->link->frontendUrl('/abroad/user-profile');
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
        // $this->layout = 'subpage';
        // $this->view->params['bgimage'] = "bg-image-1";

        return $this->render('dashboard');
    }

}
