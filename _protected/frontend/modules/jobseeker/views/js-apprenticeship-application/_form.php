<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsApprenticeshipApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-apprenticeship-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'apprenticeship_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\ServiceApprenticeship::find()->orderBy('apprenticeship_name')->asArray()->all(), 'id', 'apprenticeship_name'),
        'options' => ['placeholder' => Yii::t('app', 'Apprenticeship')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'motivation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'application_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Application date'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?php /*echo $form->field($model, 'status_id')->checkbox() */?>

    <?php /*echo $form->field($model, 'reason_rejection')->textInput(['maxlength' => true, 'placeholder' => 'Rejection reason'])*/ ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


