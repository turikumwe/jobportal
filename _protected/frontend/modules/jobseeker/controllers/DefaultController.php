<?php

namespace frontend\modules\jobseeker\controllers;

use yii\web\Controller;

/**
 * Default controller for the `jobseeker` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('/jobseeker/user-profile/');
    }
}
