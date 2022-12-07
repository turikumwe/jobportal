<?php

namespace frontend\modules\employer;

use Yii;

/**
 * employer module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\employer\controllers';

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
