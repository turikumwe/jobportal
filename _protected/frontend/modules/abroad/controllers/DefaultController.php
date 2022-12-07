<?php

namespace frontend\modules\abroad\controllers;

use yii\web\Controller;

/**
 * Default controller for the `diaspora` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('../site/abroad');
    }
}
