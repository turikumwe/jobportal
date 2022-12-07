<?php

namespace backend\modules\mediator\controllers;

use backend\modules\mediator\models\search\MdMediatorSearch;
use backend\modules\user\models\SignupForm;
use common\traits\FormAjaxValidationTrait;
use yii\web\NotFoundHttpException;
use common\models\MdMediator;
use common\models\MdAddress;
use yii\filters\VerbFilter;
use common\models\User;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;
use frontend\modules\mediator\models\search\MdEmployeesSearch;

/**
 * MdMediatorController implements the CRUD actions for MdMediator model.
 */
class MdMediatorController extends Controller {

    use FormAjaxValidationTrait;

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
     * Lists all MdMediator models.
     * @return mixed
     */
    public function actionIndex() {
        Yii::$app->db->schema->refresh();
        $searchModel = new MdMediatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all MdMediator models.
     * @return mixed
     */
    public function actionCreatePublicMediator() {
        $model = new SignupForm();
        $mediator = new MdMediator();
        $address = new MdAddress();

        $this->performAjaxValidation($model);

        $trans = Yii::$app->db->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post())) {

                $mediator->load(Yii::$app->request->post());
                $address->load(Yii::$app->request->post());

                $user = $model->signup(User::ROLE_MEDIATOR, User::VALIDATION);

                if (is_null($user)) {
                    return $this->render('register/register', [
                                'model' => $model,
                                'mediator' => $mediator,
                                'address' => $address,
                    ]);
                }

                $mediator->id = $user->id;
                $mediator->created_by = $user->id;
                $mediator->updated_by = $user->id;
                $mediator->deleted_by = 0;   //TODO use beheviour 
                $mediator->save(false);

                $address->mediator_id = $user->id;
                $address->email_address = $user->email;
                $address->phone_number = $user->phone;
                $address->created_by = $user->id;
                $address->updated_by = $user->id;
                $address->deleted_by = 0;   //TODO use beheviour           
                $address->save(false);

                $trans->commit();

                if ($user) {

                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t(
                                'frontend',
                                'Your account has been successfully created. Check your email for further instructions.'
                        ),
                        'options' => ['class' => 'alert-success']
                    ]);

                    $model = new SignupForm();
                    $mediator = new MdMediator();
                    $address = new MdAddress();

                    return $this->render('register/register', [
                                'model' => $model,
                                'mediator' => $mediator,
                                'address' => $address,
                    ]);
                    //return $this->goHome();
                }
            }
        } catch (Exception $exc) {
            $trans->rollBack();
        }

        return $this->render('register/register', [
                    'model' => $model,
                    'mediator' => $mediator,
                    'address' => $address,
        ]);
    }

    /**
     * Displays a single MdMediator model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "MdMediator #" . $id,
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
     * Creates a new MdMediator model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new MdMediator();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new MdMediator",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new MdMediator",
                    'content' => '<span class="text-success">Create MdMediator success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new MdMediator",
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing MdMediator model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update MdMediator #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "MdMediator #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update MdMediator #" . $id,
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing MdMediator model.
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

    /**
     * Delete multiple existing MdMediator model.
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

    public function actionStatus() {
        $request = Yii::$app->request;
        $mediator_id = $request->post('mediator_id');

        $status = $request->post('action');
        $mediator = MdMediator::findOne($mediator_id);

        //Activate the user who is directly linked with the institution
        $user = User::findOne($mediator->id);
        if (isset($mediator)) {
            $mediator->mediator_status = intval($status);
            if (!$mediator->save(false)) {
                var_dump($mediator->errors);
                die;
            } else {
                //Activate the user who is directly linked with the institution
                if ($status == 1) { //Case of activation
                    //Deactivate all users related to this company
                    $user = User::findOne($mediator->created_by);
                    
                    $user->status = 2; //Activate
                    $user->save(false);
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the MdMediator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MdMediator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MdMediator::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
