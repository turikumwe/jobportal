<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:01 PM
 */

namespace frontend\controllers;

use common\models\Page;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function init()
    {
		if(isset(Yii::$app->request->cookies['language']->value))//If there is language defined in cookie, use it
			Yii::$app->language = Yii::$app->request->cookies['language']->value;
		// else 
		// 	Yii::$app->language = 'en';
	
    }
    
    public function actionView($slug)
    {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "bg-image-6";

        $model = Page::find()->where(['slug' => $slug, 'status' => Page::STATUS_PUBLISHED])->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found'));
        }

        $viewFile = $model->view ?: 'view';
        return $this->render($viewFile, ['model' => $model]);
    }
}
