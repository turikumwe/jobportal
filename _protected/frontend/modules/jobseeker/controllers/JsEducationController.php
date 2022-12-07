<?php

namespace frontend\modules\jobseeker\controllers;

use frontend\modules\jobseeker\models\search\JsEducationSearch;
use common\traits\FormAjaxValidationTrait;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use yii\web\NotFoundHttpException;
use common\models\JsEducation;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;
use yii\web\UploadedFile;

/**
 * JsEducationController implements the CRUD actions for JsEducation model.
 */
class JsEducationController extends Controller {

    use FormAjaxValidationTrait;

    /**
     * @return array
     */
    public function actions() {
        return [
            'certificate-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'certificate-delete',
            ],
            'certificate-delete' => [
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
     * Lists all JsEducation models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new JsEducationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JsEducation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "JsEducation #" . $id,
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
     * Creates a new JsEducation model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new JsEducation();

        $request = Yii::$app->request;

        $this->performAjaxValidation($model);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new JsEducation",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $model->certificate_path = UploadedFile::getInstance($model, 'certificateFile');
                $filename = str_replace(" ", "", $model->certificate_path);
                if (!empty($filename)) {
                    $model->certificate_path->saveAs('storage/source/1/' . $filename);

                    $model->certificate_path = $filename;
                }
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new JsEducation",
                    'content' => '<span class="text-success">Create JsEducation success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new JsEducation",
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
                $model->certificate_path = UploadedFile::getInstance($model, 'certificateFile');
                $filename = str_replace(" ", "", $model->certificate_path);
                if (!empty($filename)) {
                    $model->certificate_path->saveAs('storage/source/1/' . $filename);

                    $model->certificate_path = $filename;
                }
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                //return $this->redirect(['/jobseeker/js-education/view', 'id' => $model->id]);
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                return $this->render('_form', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing JsEducation model.
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
                    'title' => "Update JsEducation #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $model->certificate_path = UploadedFile::getInstance($model, 'certificateFile');
                $filename = str_replace(" ", "", $model->certificate_path);
                if (!empty($filename)) {
                    $model->certificate_path->saveAs('storage/source/1/' . $filename);

                    $model->certificate_path = $filename;
                }
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "JsEducation #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update JsEducation #" . $id,
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
                $model->certificate_path = UploadedFile::getInstance($model, 'certificateFile');
                $filename = str_replace(" ", "", $model->certificate_path);
                if (!empty($filename)) {
                    $model->certificate_path->saveAs('storage/source/1/' . $filename);

                    $model->certificate_path = $filename;
                }
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                return $this->redirect(['user-profile/index']);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing JsEducation model.
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
     * Delete multiple existing JsEducation model.
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
     * Finds the JsEducation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JsEducation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = JsEducation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
