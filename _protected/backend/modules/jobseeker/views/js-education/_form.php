<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsEducation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-education-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\UserProfile::jobSeekers()->asArray()->all(), 'user_id', 'fullName'),
        'options' => ['placeholder' => 'Choose User'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'school')->textInput(['maxlength' => true, 'placeholder' => 'School']) ?>

    <?= $form->field($model, 'country_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('cc_description')->asArray()->all(), 'id', 'cc_description'),
        'options' => ['placeholder' => 'Choose S countrycode iso3166'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'education_level_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
        'options' => ['placeholder' => 'Choose S education level'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'education_field_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('field')->asArray()->all(), 'id', 'field'),
        'options' => ['placeholder' => 'Choose S education field'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'exact_quali')->textInput(['maxlength' => true, 'placeholder' => 'Exact Quali']) ?>

    <?= $form->field($model, 'start_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Start Date',
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'end_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose End Date',
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'grade_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGrade::find()->orderBy('grade')->asArray()->all(), 'id', 'grade'),
        'options' => ['placeholder' => 'Choose S grade'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'certificate_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCertificate::find()->orderBy('certificate')->asArray()->all(), 'id', 'certificate'),
        'options' => ['placeholder' => 'Choose S certificate'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'certificate_path')->textInput(['maxlength' => true, 'placeholder' => 'Certificate Path']) ?>

    <?= $form->field($model, 'certificate_base_url')->textInput(['maxlength' => true, 'placeholder' => 'Certificate Base Url']) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>





