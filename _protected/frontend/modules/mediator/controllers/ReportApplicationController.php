<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\jobseeker\models\search\JsEventApplicationSearch;
use frontend\modules\jobseeker\models\search\JsJobApplicationSearch;
use frontend\modules\employer\models\search\EmplEmployerSearch;
use frontend\modules\jobseeker\models\search\UserProfileSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use common\models\UserProfile;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;
/**
 * Default controller for the `mediator Report` module
 */
class ReportApplicationController extends Controller
{

    public function actionIndex()
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $opportunity = 1;//TODO WHY 1 ???? find best way to get service job
        $searchModel = new JsJobApplicationSearch();
        $dataProvider = $searchModel->searchReport($opportunity,Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportJob', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }

    public function actionJobApplied($opportunity)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));}

        $searchModel = new JsJobApplicationSearch();
        $dataProvider = $searchModel->searchReport($opportunity,Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportJob', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEventApplied($opportunity)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));}  

        $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReport($opportunity,Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportEvent', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEventBreakdown($eventtitle,$opportunity)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReportBreakdown($eventtitle,$opportunity,Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportEventBreakdown', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }

    public function actionJobBreakdown($job,$opportunity)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));}     
            
        $searchModel = new JsJobApplicationSearch();
        $dataProvider = $searchModel->searchReportBreakdown($job, $opportunity,Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportJobBreakdown', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
}
