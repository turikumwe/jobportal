<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceJob */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-job-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'employer')->textInput(['maxlength' => true, 'placeholder' => 'Employer']) ?>

    <?= $form->field($model, 'jobtitle')->textInput(['maxlength' => true, 'placeholder' => 'Job title']) ?>

    <?= $form->field($model, 'job_summary')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'job_responsability')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'job_skill_requirement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'job_remuneration')->textInput(['maxlength' => true, 'placeholder' => 'Remuneration']) ?>

    <?= $form->field($model, 'positions_number')->textInput(['placeholder' => 'Positions number']) ?>

    <?= $form->field($model, 'economic_sector_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SIsicr4Level4::find()->orderBy('ecosector')->asArray()->all(), 'id', 'ecosector'),
        'options' => ['placeholder' => Yii::t('app', 'Economic sector')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'education_level_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
        'options' => ['placeholder' => Yii::t('app', 'Qualification')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'education_field_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('field')->asArray()->all(), 'id', 'field'),
        'options' => ['placeholder' => Yii::t('app', 'Education field')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'posting_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Posting date'),
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

    <?php /*echo $form->field($model, 'action_id')->textInput(['placeholder' => 'Action']) */?>

    <?= $form->field($model, 'district_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
        'options' => ['placeholder' => Yii::t('app', 'District')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php /*echo $form->field($model, 'posted')->textInput(['placeholder' => 'Posted']) */?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>





