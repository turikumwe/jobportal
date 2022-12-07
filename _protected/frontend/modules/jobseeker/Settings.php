<?php

namespace frontend\modules\jobseeker;

use Yii;

/**
 * jobseeker module definition class
 */
class Settings extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\jobseeker\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if(isset(Yii::$app->request->cookies['language']->value))//If there is language defined in cookie, use it
			Yii::$app->language = Yii::$app->request->cookies['language']->value;

        // custom initialization code goes here
    }
}
