<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;
        
Modal::begin([
      'header' => 'Deactivate Account',
      "class" => "vd_bg-red", 
      'toggleButton' => [
        'class' => 'btn vd_btn btn-xs vd_bg-red',
        'label' => 'Deactivate  <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>'
      ],
      'footer'=> Html::button('close',['data-dismiss'=>"modal"])
  ]);
     $request = \Yii::$app->request;
     echo $this->render('terminateForm', [
            'model' => $jobseeker->userProfile
        ]);  
Modal::end(); 
?>
