<?php

namespace frontend\modules\jobseeker\controllers;

use frontend\modules\jobseeker\models\search\JsCaseManagement as JsCaseManagementSearch;
use common\traits\FormAjaxValidationTrait;
use common\models\JsEventApplication;
use common\models\JsCaseManagement;
use common\models\JsJobApplication;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;

/**
 * JsCaseManagementController implements the CRUD actions for JsCaseManagement model.
 */
class JsCaseManagementController extends Controller
{
    use FormAjaxValidationTrait;
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
     * Lists all JsCaseManagement models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new JsCaseManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single JsCaseManagement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "JsCaseManagement #".$id,
                    'content'=>$this->renderAjax('_view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];    
        }else{
            return $this->render('_view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionViewAfterSave($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "JsCaseManagement #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new JsCaseManagement model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    { 
        $request = Yii::$app->request;
        $model = new JsCaseManagement();    
        $this->performAjaxValidation($model);
       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new JsCaseManagement",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post())){
                $model->deleted_by = 0;
                $model->save(false);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new JsCaseManagement",
                    'content'=>'<span class="text-success">Create JsCaseManagement success</span>',
                    
        
                ];         
            }else{           
                return [
                    'title'=> "Create new JsCaseManagement",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post())) {
                $model->deleted_by = 0;
                $model->save(false);
                return $this->redirect(['/jobseeker/js-case-management/view-after-save', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

     public function actionCreatePlacement()
    { 
        $request = Yii::$app->request;
        $model = new JsCaseManagement();    
        //$this->performAjaxValidation($model);
       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new JsCaseManagement",
                    'content'=>$this->renderAjax('createService', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post())){
      
                $application = (new JsJobApplication)->findOne($model->application_id); 
         
                if($application->status_id == 2) {
                    $model->deleted_by = 0;
                    if($model->save(false) ) {
                       (new JsJobApplication)->placed($application);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Create new Case Management",
                        'content'=>'<span class="text-success">Create JsCaseManagement success</span>',
                        
                    ];   }
                        
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Case Management",
                    'content'=>'<span class="text-danger">The appliacation is not accepted yet</span>',
                    
        
                ];  
            }else{           
                return [
                    'title'=> "Create new JsCaseManagement",
                    'content'=>$this->renderAjax('createService', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post())) {
                $model->deleted_by = 0;
                $model->save(false);
                return $this->redirect(['/jobseeker/js-case-management/view-after-save', 'id' => $model->id]);
            } else {
                return $this->render('createService', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing JsCaseManagement model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update JsCaseManagement #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "JsCaseManagement #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update JsCaseManagement #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
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
     * Delete an existing JsCaseManagement model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing JsCaseManagement model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    public function actionPlacement($jobseeker_id, $applicationid,$type)
    {
        $request = Yii::$app->request;
        $model = new JsCaseManagement();       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Placement",
                    'content'=>$this->renderAjax('placement', [
                        'model' => $model,
                        'user_id' => $jobseeker_id,
                        'application_id' => $applicationid,
                        'get'   => User::findOne($jobseeker_id),
                        'applicationjob' =>  ($type == 'job') ? JsJobApplication::findOne(['id' => $applicationid]) : null,
                        'applicationevent' => ($type == 'event') ? JsEventApplication::findOne(['id' => $applicationid]) : null,
                        'url' => Yii::$app->link->frontendUrl('/jobseeker/js-case-management/create-placement')
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Case Management #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                ];
            }else{
                 return [
                    'title'=> "Placement",
                    'content'=>$this->renderAjax('placement', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('placement', [
                    'model' => $model,
                    'user_id' => $jobseeker_id,
                    'application_id' => $applicationid,
                    'get'   => User::findOne($jobseeker_id),
                    'applicationjob' =>  ($type == 'job') ? JsJobApplication::findOne(['id' => $applicationid]) : null,
                    'applicationevent' => ($type == 'event') ? JsEventApplication::findOne(['id' => $applicationid]) : null,
                    'url' => Yii::$app->link->frontendUrl('/jobseeker/js-case-management/create-placement')
                ]);
            }
        }
    }
    /**
     * Finds the JsCaseManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JsCaseManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JsCaseManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
