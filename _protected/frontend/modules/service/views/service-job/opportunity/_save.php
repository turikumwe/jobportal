<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsJobApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-job-application-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl('/service/service-job-sharing/create')]);?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'job_id')->hiddenInput(['value' => $job->id])->label(false); ?>

    <?= $form->field($model, 's_opportunity_id')->hiddenInput(['value' => $opportunity])->label(false) ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'job_seeker_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'message')->hiddenInput(['value' => ''])->label(false) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group" style="text-align: center">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Click here if you want to save this job: '.$job->jobtitle) : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
