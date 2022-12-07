<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;
		   	
Modal::begin([
      'header' => 'Settings',
      "class" => "vd_bg-green", 
      'toggleButton' => [
      	'class' => 'btn vd_btn btn-xs vd_bg-green',
      	'label' => 'Setting <i class="glyphicon glyphicon-cog" aria-hidden="true"></i>'
      ],
      'footer'=> Html::button('close',['data-dismiss'=>"modal"])
  ]);
     $request = \Yii::$app->request;
     echo $this->render('_formSettings', [
            'model' => $jobseeker->userProfile,
            'account' => $account
        ]);  
Modal::end(); 
?>
