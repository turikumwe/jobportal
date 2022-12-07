<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;

  Modal::begin([
        'header' => 'Activate Account',
        "class" => "vd_bg-red", 
        'toggleButton' => [
          'class' => 'btn vd_btn btn-xs vd_bg-red',
          'label' => 'Activate <i class="glyphicon glyphicon-arrow-down" aria-hidden="true"></i>'
        ],
        'footer'=> Html::button('close',['data-dismiss'=>"modal"])
    ]);
       $request = \Yii::$app->request;
       echo $this->render('activateForm', [
              'model' => $jobseeker->userProfile
          ]);  
  Modal::end(); 
  ?>  


