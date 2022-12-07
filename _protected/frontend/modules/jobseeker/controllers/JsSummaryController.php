<?php

namespace frontend\modules\jobseeker\controllers;

use frontend\modules\jobseeker\models\search\JsSummarySearch;
use common\traits\FormAjaxValidationTrait;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use yii\web\NotFoundHttpException;
use common\models\JsSummary;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;

/**
 * JsSummaryController implements the CRUD actions for JsSummary model.
 */
class JsSummaryController extends Controller
{
    use FormAjaxValidationTrait;
    /**
     * @return array
     */
    public function actions()
    {
         return [
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
    public function behaviors()
    {
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
     * Lists all JsSummary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JsSummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single JsSummary model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "JsSummary #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit', ['update','id'=>$id], ['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new JsSummary model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JsSummary();
        $request = Yii::$app->request;
        
        $this->performAjaxValidation($model);
        
        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title'=> "Create new Summary",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save', ['class'=>'btn btn-primary','type'=>"submit"])
        
                ];
            } elseif ($model->load($request->post())) {
                $model->cv_path =  str_replace(" ","",Yii::$app->myfield->myupload($model,'cvFile'));
                $model->cvFile = NUll;
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Summary",
                    'content'=>'<span class="text-success">Create Summary success</span>',
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More', ['create'], ['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            } else {
                return [
                    'title'=> "Create new Summary",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save', ['class'=>'btn btn-primary','type'=>"submit"])
        
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post())) {
                $model->cv_path = str_replace(" ","",Yii::$app->myfield->myupload($model,'cvFile'));
                $model->cvFile = NUll;
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                //return $this->redirect(['/jobseeker/js-summary/view', 'id' => $model->id]);
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                return $this->render('_form', [
                    'model' => $model,
                    'url'   => Yii::$app->link->frontendUrl('/jobseeker/js-summary/create')
                ]);
            }
        }
    }

    /**
     * Updates an existing JsSummary model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title'=> "Update JsSummary #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save', ['class'=>'btn btn-primary','type'=>"submit"])
                ];
            } elseif ($model->load($request->post())) {
                 $model->cv_path = str_replace(" ","",Yii::$app->myfield->myupload($model,'cvFile'));
                $model->cvFile = NUll;
                if (!$model->save()) {
                    var_dump($model->errors);
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "JsSummary #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit', ['update','id'=>$id], ['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            } else {
                return [
                    'title'=> "Update JsSummary #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save', ['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post())) {
                 $model->cv_path = str_replace(" ","",Yii::$app->myfield->myupload($model,'cvFile'));
                $model->cvFile = NUll;
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
     * Delete an existing JsSummary model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->deleteWithRelated();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
    * Delete multiple existing JsSummary model.
    * For ajax request will return json object
    * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
    public function actionBulkDelete()
    {
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the JsSummary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JsSummary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JsSummary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return $this
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    // public function actionAttachmentDownload($id)
    // {
    //     $model = ArticleAttachment::findOne($id);
    //     if (!$model) {
    //         throw new NotFoundHttpException;
    //     }

    //     return Yii::$app->response->sendStreamAsFile(
    //         Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
    //         $model->name
    //     );
    // }
}
