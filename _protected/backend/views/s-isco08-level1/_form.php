<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsco08Level1 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sisco08-level1-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat1_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cat1_description')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
