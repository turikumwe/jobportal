<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use Common\models\UserProfile;
use backend\models\SIsco08Level1;
use backend\models\SIsco08Level2;
use backend\models\SIsco08Level3;
/* @var $this yii\web\View */
/* @var $model AssessmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-user-profile-search">

    <?php $form = ActiveForm::begin([
        'action' => [''],
        'method' => 'get',
    ]); ?>
<div class="input-text">
    
    <div class="input-div">   
        <?= $form->field($model, 'registration_start')->dateInput(['maxlength' => true, 'placeholder' => 'To',
                        'autoclose' => true,'saveFormat' => 'php:Y-m-d']) ?>
    </div>

    <div class="input-div">
        <?= $form->field($model, 'registration_end')->dateInput(['maxlength' => true, 'placeholder' => 'To',
                        'autoclose' => true,'saveFormat' => 'php:Y-m-d']) ?>
     
        
    </div>
     
</div><br>

<div class="row">
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) */?>
        <!-- <span class="pull-right btn btn-info"><a href='/jobseeker/user-profile/more-options'  style="color:white"><b>More options</b></a></span> -->
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
