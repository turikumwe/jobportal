<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use backend\models\SDistrict;
use backend\models\SProvince;
use backend\models\SGeosector;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-event-form">

    <br>
    <b>Form to post summary of served job seekers</b>
    <hr>

    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl($url)]); ?>
    <?= $form->field($model, 'mediator_id')->hiddenInput(['value' => $mediator->id, 'id' => 'mediator_id' . $model->id])->label(false); ?>
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    
    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 'service_id')->dropDownList(
                ArrayHelper::map($services, 'id', 'name'),
                [
                    'prompt' => 'Select Service',
                ]
        );
        ?>
    </div>
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'female_count')->numberInput(['min' => 0, 'max'=>10000]) ?>
    </div>
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'male_count')->numberInput(['min' => 0, 'max'=>10000]) ?>
    </div>
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'disabled_count')->numberInput(['min' => 0, 'max'=>10000]) ?>
    </div>
    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 'quarter_id')->dropDownList(
                ArrayHelper::map($quarters, 'id', 'full_quarter_name'),
                [
                    'prompt' => 'Select Quarter',
                ]
        );
        ?>
    </div>

    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'additional_comment')->textInput(['maxlength' => true, 'placeholder' => 'Enter any additional comment']) ?>
    </div>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>