<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CommonPerson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="common-person-form">

    <?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

    <?php //echo $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?php // echo 
        // $form->field($model, 'document_id')->widget(\kartik\widgets\Select2::classname(), [
        //     'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDocumenttype::find()->orderBy('documenttype')->asArray()->all(), 'id', 'documenttype'),
        //     'options' => ['placeholder' => Yii::t('app', 'Document ype')],
        //     'pluginOptions' => [
        //         'allowClear' => true
        //     ],
        // ]); 
    ?>

    <?php //echo $form->field($model, 'id_number')->textInput(['maxlength' => true, 'placeholder' => 'Id Number']) ?>

    <?php //echo $form->field($model, 'passport_number')->textInput(['maxlength' => true, 'placeholder' => 'Passport Number']) ?>

    <?php  
        // echo $form->field($model, 'country_id')->widget(\kartik\widgets\Select2::classname(), [
        //     'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('cc_description')->asArray()->all(), 'id', 'cc_description'),
        //     'options' => ['placeholder' => Yii::t('app', 'Country')],
        //     'pluginOptions' => [
        //         'allowClear' => true
        //     ],
        // ]); 
    ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name']) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) ?>

    <?= $form->field($model, 'date_of_birth')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Date of Birth'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'gender_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGender::find()->orderBy('gender')->asArray()->all(), 'id', 'gender'),
        'options' => ['placeholder' => Yii::t('app', 'Gender')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php 
        // echo $form->field($model, 'geo_sector_id')->widget(\kartik\widgets\Select2::classname(), [
        //     'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGeosector::find()->orderBy('sector')->asArray()->all(), 'id', 'sector'),
        //     'options' => ['placeholder' => Yii::t('app', 'Sector')],
        //     'pluginOptions' => [
        //         'allowClear' => true
        //     ],
        // ]); 
    ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Phone']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email']) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
