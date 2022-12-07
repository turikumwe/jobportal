<?php

use yii\helpers\Html; 
use yii\widgets\ActiveForm; 

/* @var $this yii\web\View */ 
/* @var $model common\models\UserProfile */ 
/* @var $form yii\widgets\ActiveForm */ 
?> 

<div class="user-profile-form"> 

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($account); ?> 

    <h2><?php echo Yii::t('frontend', 'Account Settings') ?></h2>

    <?php echo $form->field($account, 'username')->textInput(['readonly'=> true])?> 

    <?php echo $form->field($account, 'email') ?>

    <?php echo $form->field($account, 'phone') ?>

    <?php echo $form->field($account, 'password')->passwordInput() ?>

    <?php echo $form->field($account, 'password_confirm')->passwordInput() ?>
  

    <div class="form-group"> 
       <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?> 
    </div> 

    <?php ActiveForm::end(); ?> 

</div> 