<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-address-form"> 

    <?php $form = ActiveForm::begin(); ?> 

    <?= $form->errorSummary($model); ?> 

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\UserProfile::jobSeekers()->asArray()->all(), 'user_id', 'fullName'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Jobseekers')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'sector_id')->widget(\kartik\widgets\Select2::class, [ 
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGeosector::find()->orderBy('id')->asArray()->all(), 'id', 'village'), 
        'options' => ['placeholder' => Yii::t('app', 'Choose S village')], 
        'pluginOptions' => [ 
            'allowClear' => true 
        ], 
    ]); ?>

    <?= $form->field($model, 'emailAddress')->textInput(['maxlength' => true, 'placeholder' => 'EmailAddress']) ?>

    <?= $form->field($model, 'phoneNumber')->textInput(['maxlength' => true, 'placeholder' => 'PhoneNumber']) ?>

    <?= $form->field($model, 'pobox')->textInput(['maxlength' => true, 'placeholder' => 'Pobox']) ?>

    <?= $form->field($model, 'physicalAddress')->textInput(['maxlength' => true, 'placeholder' => 'PhysicalAddress']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
