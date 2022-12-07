<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsJobApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-job-application-form">

    <?php $form = ActiveForm::begin([ 'action' => Yii::$app->link->frontendUrl('/service/service-job-sharing/share'),]) ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'job_id')->hiddenInput(['value' => $job->id])->label(false); ?>

    <?= $form->field($model, 's_opportunity_id')->hiddenInput(['value' => $opportunity])->label(false) ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Eg:email1@gmail.com,email2@gmail.com,email3@gmail.com,...']); ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
