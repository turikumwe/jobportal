<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use common\models\SNotifications;
use backend\models\SOpportunity;
/**
 * SNotificationsController implements the CRUD actions for SNotifications model.
 */
class SNotificationsController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {       
        // $this->layout = '@frontend/views/layouts/subpage';
        // $this->view->params['bgimage'] = "howtoapply.png";

        $model = new SNotifications();

        return $this->render('index', [
            'opportunities' => SOpportunity::find()->all(),
        ]);
    }

    public function actionSettings($opportunity_id)
    {   
        $model        = new SNotifications();
        $notification = SNotifications::check($opportunity_id);

        if ( !is_object($notification) ) {

            $model->opportunity_id  = $opportunity_id;
            $model->user_id         = Yii::$app->user->id;
            $model->deleted_by      = 0;
            if($model->save(false)) return true;  

        }else{     

           ($notification->deleted_by == 0) ? $notification->deleted_by = 1 : $notification->deleted_by = 0; 
            if($notification->save(false)) return true;

        }
        
    }
}
