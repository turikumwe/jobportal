<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\jobseeker\models\search\JsCaseManagement as JsCaseManagementSearch;
use frontend\modules\jobseeker\models\search\JsEventApplicationSearch;
use frontend\modules\jobseeker\models\search\JsJobApplicationSearch;
use frontend\modules\employer\models\search\EmplEmployerSearch;
use frontend\modules\jobseeker\models\search\UserProfileSearch;
use yii\web\ForbiddenHttpException;
use common\models\JsCaseManagement;
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
class ReportCaseManagementController extends Controller
{

    public function actionIndex()
    {
    	if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 
    	
        $searchModel = new JsCaseManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('case-management/reportList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

  
}
