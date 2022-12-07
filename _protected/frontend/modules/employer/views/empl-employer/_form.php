<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\EmplEmployer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-employer-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl('/employer/empl-employer/update')]); ?>
        <div class='row'>
            <div class="col-sm-6">
                <?php
                    // echo $form->field($model, 'picture')->widget(
                    //     Upload::class,
                    //     [
                    //         'url' => ['avatar-upload'],
                    //         'maxFileSize' => 2 * 1024 * 1024, //5M
                    //         'maxNumberOfFiles' => 1,
                    //         'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(png)$/i'),
                    //     ]
                    // )
                    echo $form->field($model, 'picture')->fileInput();
                ?>
                <span style="font-size: 12px;font-style: italic">Only PNG image is accepted</span> |
                <span style="font-size: 12px;font-style: italic">Maximum file size is 2MB</span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($model, 'company_name_abbraviatio')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($model, 'tin')->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'employer_type_id')->widget(\kartik\widgets\Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\SEmployerType::find()->orderBy('type')->asArray()->all(), 'id', 'type'),
                    'options' => ['placeholder' => Yii::t('app', 'Choose S employer type')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, 'opening_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                    'saveFormat' => 'php:Y-m-d',
                    'ajaxConversion' => false,
                    'options' => [
                        'pluginOptions' => [
                            'placeholder' => Yii::t('app', 'Choose Opening Date'),
                            'autoclose' => true
                        ]
                    ],
                ]); ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'ownership_id')->widget(\kartik\widgets\Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\SOwnership::find()->orderBy('ownership')->asArray()->all(), 'id', 'ownership'),
                    'options' => ['placeholder' => Yii::t('app', 'Choose S ownership')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'registration_authority_id')->widget(\kartik\widgets\Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\SRegistrationauthority::find()->orderBy('registrationauthority')->asArray()->all(), 'id', 'registrationauthority'),
                    'options' => ['placeholder' => Yii::t('app', 'Choose S registrationauthority')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
        </div>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
</div>