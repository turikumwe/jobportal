<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;
		   	
Modal::begin([
      'header' => 'Settings',
      "class" => "vd_bg-green", 
      'toggleButton' => [
      	'class' => 'btn btn-success',
      	'label' => '<i title="Change settings" class="fa fa-cog" aria-hidden="true"></i>'
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

