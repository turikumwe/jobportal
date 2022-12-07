<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SDistrictMediatorr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sdistrict-mediatorr-form">

   <?php $form = ActiveForm::begin(); ?>

   <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'district_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->orderBy('id')->asArray()->all(), 'id', 'district'),
        'options' => ['placeholder' => Yii::t('app', 'Choose District')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'mediator_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\MdMediator::find()->orderBy('id')->asArray()->all(), 'id', 'madiator_name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Mediator')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
