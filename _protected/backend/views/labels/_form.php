<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Labels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="labels-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'attribute')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'definition')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
