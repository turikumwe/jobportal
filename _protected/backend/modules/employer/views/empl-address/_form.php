<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\SProvince;
use backend\models\SDistrict;

/* @var $this yii\web\View */
/* @var $model common\models\EmplAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-address-form">

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'employer_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\EmplEmployer::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'),
        'options' => ['placeholder' => Yii::t('app', 'Employer')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'geo_sector_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGeosector::find()->orderBy('sector')->asArray()->all(), 'id', 'sector'),
        'options' => ['placeholder' => Yii::t('app', 'Sector')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true, 'placeholder' => 'Email address']) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone number']) ?>

    <?= $form->field($model, 'pobox')->textInput(['maxlength' => true, 'placeholder' => 'P.o.Box']) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'Website']) ?>

    <?= $form->field($model, 'physical_address')->textInput(['maxlength' => true, 'placeholder' => 'Physical address']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>



