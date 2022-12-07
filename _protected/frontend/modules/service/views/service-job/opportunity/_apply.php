<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsJobApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-job-application-form">

    <?php $form = ActiveForm::begin(
        [ 
            'action' => Yii::$app->link->frontendUrl('/jobseeker/js-job-application/create')
        ]); 
    ?>

    <p>
        <div class="alert alert-success">
            <b>Please check if the profile information and CV are updated and responding to the requirement of the job.</b>
        </div>
    </p>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 's_opportunity_id')->hiddenInput(['value' => $opportunity])->label(false) ?>

    <?= $form->field($model, 'job_id')->hiddenInput(['value' => $job->id])->label(false); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'motivation')
             ->textarea(
                [
                    'value'=> (isset($summary->cover_letter)) ? $summary->cover_letter : '',
                    'rows' => 12,
                    'maxlength' => 3700
                ]) 
    ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Apply') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
