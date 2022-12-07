<?php

/**
 * Created by PhpStorm.
 * User: Ntabana coco.
 * Date: 02/09/18
 * Time: 9:00 PM
 */

namespace common\components\popup;

use Yii;
use yii\bootstrap\Modal;
use yii\base\BaseObject;
use yii\helpers\Html;

class JobPortalModal {
    /*
     * $view should be a view like _form , create,update, view , index,... any page
     *
     *
     */

    public function popup($model, $label, $color, $icon, $_form, $url = null, $icon_name = null, $params = []) {

        Modal::begin([
            "size" => "modal-lg",
            'options' => [
                'tabindex' => false // important for Select2 to work properly
            ],
            'header' => $label,
            "class" => "vd_bg-green",
            'toggleButton' => [
                'label' => $icon_name . ' <i class="fa ' . $icon . '" aria-hidden="true"></i>',
                'class' => 'action-button'
            ],
            'footer' => '', //Html::button('Close',['class'=>'btn btn-default pull-right','data-dismiss'=>"modal"])
                //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        ]);
        echo Yii::$app->controller->renderPartial($_form, [
            'model' => $model,
            'url' => Yii::$app->link->frontendUrl($url),
            'id' => $icon . '_' . $model->id,
            'params' => $params
        ]);
        Modal::end();
    }

}
