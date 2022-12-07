<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsEventApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-event-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

     <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\UserProfile::jobSeekers()->asArray()->all(), 'user_id', 'fullName'),
        'options' => ['placeholder' => Yii::t('app', 'Event applicant')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'even_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\ServiceEvent::find()->orderBy('event_title')->asArray()->all(), 'id', 'event_title'),
        'options' => ['placeholder' => Yii::t('app', 'Event title')],
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

    <?= $form->field($model, 'area_of_expertise_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SAreaExpertise::find()->orderBy('expertise')->asArray()->all(), 'id', 'expertise'),
        'options' => ['placeholder' => Yii::t('app', 'Area of expertise')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'employment_status_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEmploymentStatus::find()->orderBy('status')->asArray()->all(), 'id', 'status'),
        'options' => ['placeholder' => Yii::t('app', 'Employment status')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'special_assistance_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SSpecialAssistance::find()->orderBy('assistance')->asArray()->all(), 'id', 'assistance'),
        'options' => ['placeholder' => Yii::t('app', 'Special assistance')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php /*echo $form->field($model, 'status_id')->checkbox() */?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>



