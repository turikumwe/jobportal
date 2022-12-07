<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;
		   	
Modal::begin([
     'options' => [
        'tabindex' => false // important for Select2 to work properly
      ],
    'header' => 'Edit Profile',
    "class" => "vd_bg-green", 
    'toggleButton' => [
    	'class' => 'btn vd_btn btn-xs vd_bg-yellow',
    	'label' => 'Edit <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>'
    ],
    //'footer'=> Html::button('Close',['class'=>'btn btn-default pull-right','data-dismiss'=>"modal"])
          //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
]);
   $request = \Yii::$app->request;
   echo $this->render('update', [
          'model' => $employer->employerProfile
      ]);  
Modal::end(); 
?>
