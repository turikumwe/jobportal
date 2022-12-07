<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'event_title')->textInput(['maxlength' => true, 'placeholder' => 'Event title']) ?>

    <?= $form->field($model, 'event_category_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEventCategory::find()->orderBy('category')->asArray()->all(), 'id', 'category'),
        'options' => ['placeholder' => Yii::t('app', 'Category')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'event_summary')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'event_requirement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'event_location')->textInput(['maxlength' => true, 'placeholder' => 'Location']) ?>

    <?= $form->field($model, 'start_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Start date'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'closure_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Closure date'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'how_to_apply')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true, 'placeholder' => 'Contact phone']) ?>

    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true, 'placeholder' => 'Contact email']) ?>

    <?php /*echo $form->field($model, 'posted')->textInput(['placeholder' => 'Posted']) */?>

    <?php /*echo $form->field($model, 'action_id')->checkbox()*/ ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


