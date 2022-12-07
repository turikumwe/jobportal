<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\JsTraining */
/* @var $form yii\widgets\ActiveForm */
if(isset($_GET['id']))
    $id = $_GET['id'];
else
    $id=null;
?>

<div class="js-training-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
            // 'enableClientValidation' => false,
            // 'enableAjaxValidation' => true,
        ]
    ); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jstraining-id_' . $id, 'style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['id' => 'jstraining-user_id_' . $id, 'value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'training_center')->textInput(
        [
            'id' => 'jstraining-training_center_' . $id, 'maxlength' => true, 'placeholder' => 'Training Center'
        ]
    )
    ?>

    <?= $form->field($model, 'training_title')->textInput(
        [
            'id' => 'jstraining-training_title_' . $id, 'maxlength' => true, 'placeholder' => 'Training Title'
        ]
    )
    ?>

    <?= $form->field($model, 'start_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'id' => 'jstraining-start_date_' . $id,
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Start date'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'end_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'id' => 'jstraining-end_date_' . $id,
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'End date'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?php 
        // echo $form->field($model, 'certificateFile')->widget(
        //     Upload::class,
        //     [
        //         'url' => ['/jobseeker/js-training/certificate-upload'],
        //         'options' => ['id' => 'jstraining-certificateFile_' . $id,],
        //         'maxFileSize' => 2 * 1024 * 1024, //5M
        //         'maxNumberOfFiles' => 1,
        //         'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(pdf)$/i'),
        //     ]
        // )
        echo $form->field($model, 'certificateFile')->fileInput();
    ?>
    <span style="font-size: 12px;font-style: italic">Only PDF file is accepted</span> |
    <span style="font-size: 12px;font-style: italic">Maximum file size is 2MB</span>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>