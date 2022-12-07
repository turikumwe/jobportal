<?php

namespace frontend\modules\employer\controllers;

use common\models\EmplAddress;
use common\models\EmplEmployer;
use common\models\MdAddress;
use common\models\User;
use frontend\modules\employer\models\search\EmplEmployerSearch;
use frontend\modules\user\models\AccountForm;
use Intervention\Image\ImageManagerStatic;
use League\Flysystem\File;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * EmplEmployerController implements the CRUD actions for EmplEmployer model.
 */
class EmplEmployerController extends Controller {

    /**
     * @return array
     */
    public function actions() {
        return [
            'avatar-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file File */
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
                ],
            ],
        ];
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex($idOtherProfile = null) {
        $this->layout = 'employer_dashboard';
        $accountForm = new AccountForm();
        $accountForm->setUser(Yii::$app->user->identity);

        $searchModel = new EmplEmployerSearch();
        $employers = $searchModel->search(Yii::$app->request->queryParams);

        $user_id = is_null($idOtherProfile) ? Yii::$app->user->id : $idOtherProfile;

        if ($accountForm->load(Yii::$app->request->post()) && $accountForm->save()) {
            Yii::$app->session->setFlash('forceUpdateLocale');
            return $this->refresh();
        }

        $geo_sector_id = (EmplAddress::find()->mine($user_id)->current()->one()) ? EmplAddress::find()->mine($user_id)->current()->one()->geo_sector_id : '';
        $mediator_contact = MdAddress::find()->contact($geo_sector_id); //->one();

        return $this->render('index', [
                    'employer' => User::findOne($user_id),
                    'model' => new EmplEmployer(),
                    'account' => $accountForm,
                    'idOtherProfile' => $user_id,
                    'employers' => $employers,
                    'searchModel' => $searchModel,
                    'mediator_contact' => ($mediator_contact->count() != 0) ? $mediator_contact : 0 //Don't remove 0
        ]);
    }

    public function actionProfile($idOtherProfile = null) {
        $this->layout = 'employer_dashboard';
        $accountForm = new AccountForm();
        $accountForm->setUser(Yii::$app->user->identity);

        $searchModel = new EmplEmployerSearch();
        $employers = $searchModel->search(Yii::$app->request->queryParams);

        $user_id = is_null($idOtherProfile) ? Yii::$app->user->id : $idOtherProfile;

        if ($accountForm->load(Yii::$app->request->post()) && $accountForm->save()) {
            Yii::$app->session->setFlash('forceUpdateLocale');
            return $this->refresh();
        }
        
        
        $geo_sector_id = (EmplAddress::find()->mine($user_id)->current()->one()) ? EmplAddress::find()->mine($user_id)->current()->one()->geo_sector_id : '';
        $mediator_contact = MdAddress::find()->contact($geo_sector_id); //->one();

        return $this->render('profile', [
                    'employer' => User::findOne($user_id),
                    'model' => new EmplEmployer(),
                    'account' => $accountForm,
                    'idOtherProfile' => $user_id,
                    'employers' => $employers,
                    'searchModel' => $searchModel,
                    'mediator_contact' => ($mediator_contact->count() != 0) ? $mediator_contact : 0 //Don't remove 0
        ]);
    }

    /**
     * Displays a single EmplEmployer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "EmplEmployer #" . $id,
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
     * Creates a new EmplEmployer model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new EmplEmployer();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new EmplEmployer",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $model->avatar_path = Yii::$app->myfield->myupload($model, 'picture');
                $model->picture = NUll;
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new EmplEmployer",
                    'content' => '<span class="text-success">Create EmplEmployer success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new EmplEmployer",
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
            if ($model->load($request->post())) {
                $model->avatar_path = Yii::$app->myfield->myupload($model, 'picture');
                $model->picture = NUll;
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                return $this->redirect(Yii::$app->link->frontendUrl('/employer/empl-employer'));
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing EmplEmployer model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate() {
        $request = Yii::$app->request;
        $model = Yii::$app->user->identity->employerProfile;

        if ($model->load($request->post())) {
            $model->avatar_path = Yii::$app->myfield->myupload($model, 'picture');
            $model->picture = NUll;
            if (!$model->save()) {
                var_dump($model->errors);
            }
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('frontend', 'Your account has been successfully saved', [], '')
            ]);
            return $this->redirect(Yii::$app->link->frontendUrl('/employer/empl-employer'));
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Delete an existing EmplEmployer model.
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
            return $this->redirect(['index']);
        }
    }

    public function actionAdmin() {
        $searchModel = new EmplEmployerSearch();
        $dataProvider = $searchModel->searchAdmin(Yii::$app->request->queryParams);

        return $this->render('admin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the EmplEmployer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmplEmployer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = EmplEmployer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionHideAndShow($variable, $column) {
        $model = Yii::$app->user->identity->employerProfile;
        $model->$column = $variable;
        if ($model->save()) {
            return true;
        }
    }

}
