<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmplEmployerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-empl-employer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'placeholder' => 'Company Name']) ?>

    <?= $form->field($model, 'company_name_abbraviatio')->textInput(['maxlength' => true, 'placeholder' => 'Company Name Abbraviatio']) ?>

    <?= $form->field($model, 'avatar_path')->textInput(['maxlength' => true, 'placeholder' => 'Avatar Path']) ?>

    <?= $form->field($model, 'avatar_base_url')->textInput(['maxlength' => true, 'placeholder' => 'Avatar Base Url']) ?>

    <?php /* echo $form->field($model, 'parent')->textInput(['placeholder' => 'Parent']) */ ?>

    <?php /* echo $form->field($model, 'child')->textInput(['placeholder' => 'Child']) */ ?>

    <?php /* echo $form->field($model, 'employer_type_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\SEmployerType::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
        'options' => ['placeholder' => Yii::t('app', 'Choose S employer type')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'opening_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Opening Date'),
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'registration_authority_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\SRegistrationauthority::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
        'options' => ['placeholder' => Yii::t('app', 'Choose S registrationauthority')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'tin')->textInput(['maxlength' => true, 'placeholder' => 'Tin']) */ ?>

    <?php /* echo $form->field($model, 'ownership_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\SOwnership::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
        'options' => ['placeholder' => Yii::t('app', 'Choose S ownership')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'show_address')->checkbox() */ ?>

    <?php /* echo $form->field($model, 'show_economic_sector')->checkbox() */ ?>

    <?php /* echo $form->field($model, 'show_employer_status')->checkbox() */ ?>

    <?php /* echo $form->field($model, 'show_reference')->checkbox() */ ?>

    <?php /* echo $form->field($model, 'show_employer_summary')->checkbox() */ ?>

    <?php /* echo $form->field($model, 'show_manager')->checkbox() */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
