<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsSummary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-summary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\UserProfile::jobSeekers()->asArray()->all(), 'user_id', 'fullName'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Jobseekers')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    
    <?= $form->field($model, 'professional_profile')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'specialty')->textarea(['rows' => 6,'maxlength' => 3700]) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
