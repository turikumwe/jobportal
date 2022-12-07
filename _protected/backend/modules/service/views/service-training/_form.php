<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceTraining */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-training-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'training_category_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\STrainingCategory::find()->orderBy('trainingcategory')->asArray()->all(), 'id', 'trainingcategory'),
        'options' => ['placeholder' => Yii::t('app', 'Training category')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'training_name')->textInput(['maxlength' => true, 'placeholder' => 'Training title']) ?>

    <?= $form->field($model, 'training_details')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'training_duration')->textInput(['placeholder' => 'Training duration']) ?>

    <?= $form->field($model, 'application_deadline')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Application deadline'),
                'autoclose' => true
            ]
        ],
    ]); ?>

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

    <?= $form->field($model, 'training_center')->textInput(['maxlength' => true, 'placeholder' => 'Training center']) ?>

    <?= $form->field($model, 'training_provider')->textInput(['maxlength' => true, 'placeholder' => 'Training provider']) ?>

    <?php /*echo $form->field($model, 'posted')->textInput(['placeholder' => 'Posted']) */?>

    <?= $form->field($model, 'district_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
        'options' => ['placeholder' => Yii::t('app', 'District')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


 