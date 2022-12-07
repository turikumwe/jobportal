<?php

namespace frontend\modules\mediator\controllers;
use frontend\modules\service\models\search\ServiceJobSearch;
use frontend\modules\service\models\search\ServiceEventSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;

/**
 * Default controller for the `mediator Report` module
 */
class ReportServiceController extends Controller
{
	
	public function actionIndex()
    {
             $this->layout='dashboard';
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 
        return $this->render('index');
    }

    public function actionEvent($opportunity=null, $action_id=null)
    {
         $this->layout='dashboard';
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel = new ServiceEventSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams, $opportunity, $action_id);

        return $this->render('reportList', [
        	'type' => 'event',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJob($opportunity=null, $action_id=null)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel =  new ServiceJobSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams, $opportunity, $action_id);

        return $this->render('reportList', [
        	'type' => 'job',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionArchiveJob($opportunity = null, $action_id = null)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel =  new ServiceJobSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams, $opportunity, $action_id);

        return $this->render('reportList', [
        	'type' => 'job',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionArchiveEvent($opportunity = null, $action_id = null)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 
        
        $searchModel =  new ServiceEventSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams, $opportunity, $action_id);

        return $this->render('reportList', [
        	'type' => 'event',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
