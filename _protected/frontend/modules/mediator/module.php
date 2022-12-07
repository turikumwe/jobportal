<?php

namespace frontend\modules\mediator;

use Yii;

/**
 * mediator module definition class
 */
class module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\mediator\controllers';

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
