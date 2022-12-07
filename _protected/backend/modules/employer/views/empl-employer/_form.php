<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmplEmployer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-employer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'placeholder' => 'Company name']) ?>

    <?= $form->field($model, 'company_name_abbraviatio')->textInput(['maxlength' => true, 'placeholder' => 'Company name abbraviation']) ?>    

    <?= $form->field($model, 'employer_type_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\SEmployerType::find()->orderBy('type')->asArray()->all(), 'id', 'type'),
        'options' => ['placeholder' => Yii::t('app', 'Employer type')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'opening_date')->widget(\kartik\datecontrol\DateControl::classname(), [
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

    <?= $form->field($model, 'registration_authority_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\SRegistrationauthority::find()->orderBy('registrationauthority')->asArray()->all(), 'id', 'registrationauthority'),
        'options' => ['placeholder' => Yii::t('app', 'Registration authority')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'tin')->textInput(['maxlength' => true, 'placeholder' => 'Tin']) ?>

    <?= $form->field($model, 'ownership_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\SOwnership::find()->orderBy('ownership')->asArray()->all(), 'id', 'ownership'),
        'options' => ['placeholder' => Yii::t('app', 'Ownership')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'show_address')->checkbox() ?>

    <?= $form->field($model, 'show_economic_sector')->checkbox() ?>

    <?= $form->field($model, 'show_employer_status')->checkbox() ?>

    <?= $form->field($model, 'show_reference')->checkbox() ?>

    <?= $form->field($model, 'show_employer_summary')->checkbox() ?>

    <?= $form->field($model, 'show_manager')->checkbox() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


