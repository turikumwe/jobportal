<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;
		   	
Modal::begin([
    'header' => 'Edit Profile',
    "class" => "vd_bg-green", 
    'toggleButton' => [
    	'class' => 'btn vd_btn btn-xs vd_bg-yellow',
    	'label' => 'Edit <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>'
    ],
    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
          //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
]);
   $request = \Yii::$app->request;
   echo $this->render('update', [
          'model' => $jobseeker->userProfile
      ]);  
Modal::end(); 
?>
