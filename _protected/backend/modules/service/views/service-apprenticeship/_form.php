<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceApprenticeship */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-apprenticeship-form">

    <?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'apprenticeship_category_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\STrainingCategory::find()->orderBy('trainingcategory')->asArray()->all(), 'id', 'trainingcategory'),
        'options' => ['placeholder' => Yii::t('app', 'Category')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'apprenticeship_name')->textInput(['maxlength' => true, 'placeholder' => 'Apprenticeship title']) ?>

    <?= $form->field($model, 'apprenticeship_details')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'apprenticeship_duration')->textInput(['placeholder' => 'Apprenticeship duration']) ?>

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

    <?= $form->field($model, 'apprenticeship_center')->textInput(['maxlength' => true, 'placeholder' => 'Apprenticeship center']) ?>

    <?= $form->field($model, 'apprenticeship_provider')->textInput(['maxlength' => true, 'placeholder' => 'Apprenticeship provider']) ?>

    <?php /*echo $form->field($model, 'posted')->textInput(['placeholder' => 'Posted'])*/ ?>

    <?= $form->field($model, 'district_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
        'options' => ['placeholder' => Yii::t('app', 'District')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php /*echo $form->field($model, 'action_id')->checkbox()*/ ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


