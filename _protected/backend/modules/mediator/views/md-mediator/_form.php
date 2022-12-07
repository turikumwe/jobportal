<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MdMediator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="md-mediator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'registration_authority_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SRegistrationauthority::find()->orderBy('id')->asArray()->all(), 'id', 'registrationauthority'),
        'options' => ['placeholder' => Yii::t('app', 'Registration authority')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'registration_number')->textInput(['maxlength' => true, 'placeholder' => 'Registration number']) ?>

    <?= $form->field($model, 'madiator_name')->textInput(['maxlength' => true, 'placeholder' => 'Madiator name']) ?>

    <?= $form->field($model, 'mediator_type_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SMediatorType::find()->orderBy('id')->asArray()->all(), 'id', 'mediator_type'),
        'options' => ['placeholder' => Yii::t('app', 'Mediator type')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'opening_date')->widget(\kartik\datecontrol\DateControl::class, [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Opening date'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'ownership_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SOwnership::find()->orderBy('id')->asArray()->all(), 'id', 'ownership'),
        'options' => ['placeholder' => Yii::t('app', 'Ownership')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'show_address')->checkbox() ?>

    <?= $form->field($model, 'show_manager')->checkbox() ?>

    <?= $form->field($model, 'show_employee')->checkbox() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


