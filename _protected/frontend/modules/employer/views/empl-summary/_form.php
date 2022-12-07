<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmplSummary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-summary-form">

    <?php $form = ActiveForm::begin(['action' => $url]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'employer_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'professional_profile')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'specialty')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
