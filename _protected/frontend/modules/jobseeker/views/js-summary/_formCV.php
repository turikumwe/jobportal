<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\JsSummary */
/* @var $form yii\widgets\ActiveForm */

if (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = null;
?>
<div class="js-summary-form">

    <?php $form = ActiveForm::begin(
        [
            //'action' => $url,
            // 'enableClientValidation' => true,
            // 'enableAjaxValidation' => true,
        ]
    ); ?>
    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jstraining-id_' . $id, 'style' => 'display:none']); ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>
    <div class="row">
        <div class="col col-md-12">
            <?= $form->field($model, 'professional_profile')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-6">
            <?php
            // echo $form->field($model, 'cvFile')->widget(
            //     Upload::class,
            //     [
            //         'url' => ['/jobseeker/js-summary/cv-upload'],
            //         'sortable' => true,
            //         'maxFileSize' => 2 * 1024 * 1024, //5M
            //         'maxNumberOfFiles' => 1,
            //         'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(pdf)$/i'),
            //     ]
            // );
            echo $form->field($model, 'cvFile')->fileInput();
            ?>
            <span style="font-size: 12px;font-style: italic">Only PDF file is accepted</span> |
            <span style="font-size: 12px;font-style: italic">Maximum file size is 2MB</span>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>