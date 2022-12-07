<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;
		   	
Modal::begin([
    'header' => 'Edit Profile',
    "class" => "vd_bg-green", 
    'toggleButton' => [
    	'class' => 'btn btn-warning',
    	'label' => '<i title="Update your Profile" class="fa fa-pencil" aria-hidden="true"></i>'
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
