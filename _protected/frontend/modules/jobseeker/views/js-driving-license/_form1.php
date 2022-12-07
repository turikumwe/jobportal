<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsDrivingLicense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-driving-license-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'having_license')->textInput() ?>

    <?= $form->field($model, 'license_type_id')->textInput() ?>

    <?= $form->field($model, 'country_id')->textInput() ?>

    <?= $form->field($model, 'expering_date')->textInput() ?>

    <?php /* $form->field($model, 'created_by')->textInput() */?>

    <?php /* echo $form->field($model, 'created_at')->textInput() */?>

    <?php /* echo $form->field($model, 'deleted_by')->textInput() */?>

    <?php /* echo $form->field($model, 'deleted_at')->textInput() */?>

    <?php /* echo $form->field($model, 'updated_by')->textInput() */?>

    <?php /* echo $form->field($model, 'updated_at')->textInput() */?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
