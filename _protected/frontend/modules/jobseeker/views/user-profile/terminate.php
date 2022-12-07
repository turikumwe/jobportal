<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;
        
Modal::begin([
      'header' => 'Deactivate Account',
      "class" => "vd_bg-red", 
      'toggleButton' => [
        'class' => 'btn btn-danger',
        'label' => '<i title="Deactivate your account" class="fa fa-remove" aria-hidden="true"></i>'
      ],
      'footer'=> Html::button('close',['data-dismiss'=>"modal"])
  ]);
     $request = \Yii::$app->request;
     echo $this->render('terminateForm', [
            'model' => $jobseeker->userProfile
        ]);  
Modal::end(); 
?>
