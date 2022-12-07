<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsCaseManagement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kora-container js-case-management-form">

    <?php $form = ActiveForm::begin([
        'action' => $url,
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'mediator_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <div class="row">
        <div class="col col-md-4">
            <b>Reference Number:</b>
        </div>
        <div class="col col-md-8">
            <?= $get->userProfile->reference_number ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-4">
            <b>Name:</b>
        </div>
        <div class="col col-md-8">
            <?= $get->userProfile->fullName ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-4">
            <b>District:</b>
        </div>
        <div class="col col-md-8">
            <?= isset($get->jsAddress->district->district) ? $get->jsAddress->district->district : '' ?>
        </div>
    </div>
    <div class="row">
        <!-- <div class="col col-md-2">
            <b>Experience:</b><?php //$get->userProfile->fullName 
                                ?>
        </div> -->
        <div class="col col-md-4">
            <b>Education Level:</b>
        </div>
        <div class="col col-md-8">
            <?= isset($get->jsEducation->educationLevel->level) ? $get->jsEducation->educationLevel->level : "-" ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-4">
            <b>Education Field:</b>
        </div>
        <div class="col col-md-8">
            <?= isset($get->jsEducation->educationField->field) ? $get->jsEducation->educationField->field : "-" ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'type_of_job')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\SJobType::find()->orderBy('job_type')->asArray()->all(), 'id', 'job_type'),
                ['placeholder' => Yii::t('app', 'Select Job Type')]); 
            ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'given_service')->dropDownList(
                \yii\helpers\ArrayHelper::map(\common\models\SServices::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                ['placeholder' => Yii::t('app', 'Services')]); 
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'availability')->dropDownList(['Yes' => 'Yes', 'No' => 'No'], ['prompt' => 'Select Availability']); ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'willingness')->dropDownList(['Yes' => 'Yes', 'No' => 'No'], ['prompt' => 'Select willingness to move']); ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'license_permit')->dropDownList(['N' => 'None', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'], ['prompt' => 'License Permit Category']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'geven_service_description')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'cooperative')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'mediotor_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
            <?= $form->field($model, 'jobseeker_id')->hiddenInput(['value' => $user_id])->label(false) ?>
        </div>
    </div>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>