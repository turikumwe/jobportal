<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\dropDownList\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\JsEducation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-education-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
              //'enableClientValidation' => false,
             //'enableAjaxValidation' => false,
        ],
             ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>

    <?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jseducation-id_' . $id, 'style' => 'display:none']); ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['id' => 'jseducation-user_id_' . $id, 'value' => \Yii::$app->user->id])->label(false) ?>

    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'school')->textInput(['id' => 'jseducation-school_' . $id, 'maxlength' => true, 'placeholder' => 'Enter School Name']) ?>
        </div>

        <div class="input__fld">
            <?= $form->field($model, 'country_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('cc_description')->asArray()->all(), 'id', 'cc_description'),
                ['id' => 'jseducation-country_id_' . $id, 'prompt' => 'Select Country']); 
            ?>
        </div>

        <div class="input__fld">
            <?= $form->field($model, 'education_level_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
                ['id' => 'jseducation-education_level_id_' . $id, 'prompt' => 'Select Education Level']); 
            ?>
        </div>
    </div>
    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'education_field_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('field')->asArray()->all(), 'id', 'field'),
                ['id' => 'jseducation-education_field_id_' . $id, 'prompt' => 'Select Education Field']); 
            ?>
        </div>

        <div class="input__fld">
            <?= $form->field($model, 'exact_quali')->textInput(
                ['id' => 'jseducation-exact_quali_' . $id, 'maxlength' => true, 'placeholder' => 'Exact Qualification on your Certificate']
            )
            ?>
        </div>

        <div class="input__fld">
             
            <?= $form->field($model, 'start_date')->dateInput(['maxlength' => true]) ?>
     
        </div>
    </div>
    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'end_date')->dateInput(['maxlength' => true]) ?>
     
        </div>

        <div class="input__fld">
            <?= $form->field($model, 'certificate_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\SCertificate::find()->orderBy('certificate')->asArray()->all(), 'id', 'certificate'),
                ['id' => 'jseducation-certificate_id_' . $id, 'prompt' => 'Select Qualification'])->label('Qualification') 
            ?>
        </div>

        <div class="input__fld">
            <?php
            // echo $form->field($model, 'certificateFile')->dropDownList(
            //     Upload::class,
            //     [
            //         'url' => ['/jobseeker/js-education/certificate-upload'],
            //         'options' => ['id' => 'jseducation-certificateFile_' . $id],
            //         'maxFileSize' => 2 * 1024 * 1024, //5M
            //         'maxNumberOfFiles' => 1,
            //         'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(pdf)$/i'),
            //     ]
            // ) 
            echo $form->field($model, 'certificateFile')->fileInput();
            ?>
            <span style="font-size: 12px;font-style: italic">Only PDF file is accepted</span> |
            <span style="font-size: 12px;font-style: italic">Maximum file size is 2MB</span>
        </div>
    </div>
    <div class="inline__flds">
        <div class="input__fld">
            <?php if (!Yii::$app->request->isAjax) { ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>