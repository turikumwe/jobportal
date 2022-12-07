<?php

use \yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\JsDrivingLicense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-driving-license-form">

    <?php $form = ActiveForm::begin(
        [
            'id' => 'dynamic-form',
            'action' => $url,
            //'enableClientValidation' => false,
            //'enableAjaxValidation' => true,
        ]
    ); ?>
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jsdrivinglicense-id_' . $id, 'style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['id' => 'jsdrivinglicense-user_id_' . $id, 'value' => \Yii::$app->user->id])->label(false) ?>
    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'having_license')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\SNoyes::find()->orderBy('noyes')->asArray()->all(), 'id', 'noyes'),
                [
                    'id' => 'jsdrivinglicense-having_license_' . $id, 'placeholder' => 'Choose the answer',
                    'onchange' => '

                                        // To get dropdownlist for courses

                                        var id = document.getElementById("jsdrivinglicense-having_license_plus_").value;
                                        if(id == 2){
                                            $("#registration" ).show();
                                        }
                                            else{
                                            $("#registration" ).hide();
                                        };'

                ]
            );
            ?>
        </div>
    </div>
    <div id='registration' style='display:none'>
        <div class="inline__flds">
            <div class="input__fld">
                <?= $form->field($model, 'license_type_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SPermitType::find()->orderBy('type')->asArray()->all(), 'id', 'type'),
                    ['id' => 'jsdrivinglicense-license_type_id_' . $id, 'prompt' => 'Select Licence Type']); 
                ?>
            </div>
            <div class="input__fld">
                <?= $form->field($model, 'country_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('cc_description')->asArray()->all(), 'id', 'cc_description'),
                    ['id' => 'jsdrivinglicense-country_id_' . $id, 'prompt' => 'Select Country']); 
                ?>
            </div>
            <div class="input__fld">
                <?= $form->field($model, 'expering_date')->dateInput(['maxlength' => true]) ?>
     
            </div>
        </div>
        <div class='inline__flds'>
            <div class="input__fld">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 4, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $params['categories'][0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'license_category_id',
                        'issued_date',
                    ],
                ]); ?>

                        <div class="container-items">
                            <!-- widgetContainer -->
                            <?php foreach ($params['categories'] as $key => $category) : ?>
                                <div class="item panel panel-default">
                                    <!-- widgetBody -->
                                    <div class="panel-heading">
                                        <h2 class="panel-title">Driving License Category</h2>
                                         
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body" style='background-color: #ccc'>
                                        <?php
                                        // necessary for update action.
                                        if (!$category->isNewRecord) {
                                            echo Html::activeHiddenInput($category, "[{$key}]id");
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($category, "[{$key}]license_category_id")->dropDownList(
                                                    ArrayHelper::map(\backend\models\SPermitCategory::find()->orderBy('category')->all(), 'id', 'category'), 
                                                    [
                                                        'prompt' => 'Select Category',
                                                        'language' => 'en',
                                                    ]);
                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($category, "[{$key}]issued_date")->input('date'); ?>
                                            </div>
                                        </div>

                                    </div><!-- .row -->

                                </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
</div>