<?php
use \yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsDrivingLicense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-driving-license-form">

     <?php $form = ActiveForm::begin(
        [

            'action' => $url,
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]
    ); ?> 

    <?= $form->errorSummary($model); ?> 

     <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jsdrivinglicense-id_'.$id,'style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['id' => 'jsdrivinglicense-user_id_'.$id,'value' => \Yii::$app->user->id])->label(false) ?>
    <div class="row">
        <div class="col-sm-4">
          <?= $form->field($model, 'having_license')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SNoyes::find()->orderBy('noyes')->asArray()->all(), 'id', 'noyes'),
                'options' => ['id' => 'jsdrivinglicense-having_license_' .$id, 'placeholder' => 'Choose the answer',
                    'onchange'=>'

                                // To get dropdownlist for courses

                                   var id = document.getElementById("jsdrivinglicense-having_license_edit_").value;
                                   if(id == 2){
                                    $("#registration" ).show();
                                   }
                                    else{
                                    $("#registration" ).hide();
                                   };'
                    
            ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>
    <div id='registration' style='display:block'>
    <div class="row">
        <div class="col-sm-4">
           <?= $form->field($model, 'license_type_id')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SPermitType::find()->orderBy('type')->asArray()->all(), 'id', 'type'),
                'options' => ['id' => 'jsdrivinglicense-license_type_id_' . $id, 'placeholder' => 'Choose the type'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'country_id')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('cc_description')->asArray()->all(), 'id', 'cc_description'),
                'options' => ['id' => 'jsdrivinglicense-country_id_' . $id, 'placeholder' => 'Choose country'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    
       <div class="col-sm-4">
        <?= $form->field($model, 'expering_date')->widget(\kartik\datecontrol\DateControl::class, [
                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                    'saveFormat' => 'php:Y-m-d',
                    'ajaxConversion' => true,
                    'options' => [
                        'id' => 'jsdrivinglicense-expering_date_' . $id,
                        'pluginOptions' => [
                            'placeholder' => 'Choose expering date',
                            'autoclose' => true
                        ]
                    ],
                ]); ?>
        </div>
    </div>
    </div>

    

    <?php /* $form->field($model, 'created_by')->textInput() */?>

    <?php /* echo $form->field($model, 'created_at')->textInput() */?>

    <?php /* echo $form->field($model, 'deleted_by')->textInput() */?>

    <?php /* echo $form->field($model, 'deleted_at')->textInput() */?>

    <?php /* echo $form->field($model, 'updated_by')->textInput() */?>

    <?php /* echo $form->field($model, 'updated_at')->textInput() */?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
