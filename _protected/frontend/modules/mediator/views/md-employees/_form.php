<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MdEmployees */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="md-employees-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]
    ); ?> 

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none','id' => 'mdmediator2-id'.$model->id]); ?>

    <?= $form->field($model, 'mediator_id')->hiddenInput(['value' => Yii::$app->user->id,'id' => 'mdmediator2-mediator_id'.$model->id])->label(false); ?>

    <?= $form->field($model, 'person_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\CommonPerson::employerManagers()->asArray()->all(), 'id', 'fullName'),
        'options' => ['id' => 'mdmediator2-person_id'.$model->id,'placeholder' => Yii::t('app', 'Choose Manager')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'start_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'id' => 'mdmediator2-start_date'.$model->id,
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Start Date'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'end_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'id' => 'mdmediator2-end_date'.$model->id,
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose End Date'),
                'autoclose' => true
            ]
        ],
    ]); ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>




