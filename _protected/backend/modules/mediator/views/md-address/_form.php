<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MdAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="md-address-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'mediator_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\MdMediator::find()->orderBy('id')->asArray()->all(), 'id', 'madiator_name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Mediator')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'geo_sector_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGeosector::find()->orderBy('id')->asArray()->all(), 'id', 'sector'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Sector')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true, 'placeholder' => 'Email address']) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone number']) ?>

    <?= $form->field($model, 'pobox')->textInput(['maxlength' => true, 'placeholder' => 'Po.Box']) ?>

    <?= $form->field($model, 'physical_address')->textInput(['maxlength' => true, 'placeholder' => 'Physical address']) ?>

    <?= $form->field($model, 'current_address')->checkbox() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>





