<?php
use common\models\JsMessage;
use yii\bootstrap\Modal;

$messageModel = new JsMessage();
	Modal::begin([
		'options' => [
    'tabindex' => false // important for Select2 to work properly
],
  'header' => 'Add Message',
  "class" => "vd_bg-green", 
  "id"    => "requesr_recommandation",
  'toggleButton' => [
  	'class' => 'btn vd_btn btn-xs vd_bg-red',
  	'label' => 'Request Recommandation'
  ],
  'footer'=> ''
]);	                   
 echo $this->render('/js-message/_form', [
        'model' => $messageModel,
        'url'   => Yii::$app->link->frontendUrl('/jobseeker/js-message/submit-recommendation'),
        'id'    => 'request_recommandation'
    ]);  
Modal::end();