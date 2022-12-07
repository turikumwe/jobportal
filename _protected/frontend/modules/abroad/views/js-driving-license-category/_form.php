<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsDrivingLicenseCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-driving-license-category-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'driving_license_id')->textInput() ?>
        </div>
        <div class="col-sm-4">
          <?= $form->field($model, 'license_category_id')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SPermitCategory::find()->orderBy('category')->asArray()->all(), 'id', 'category'),
                'options' => ['id' => 'jsdrivinglicensecategory-license_type_id', 'placeholder' => 'Choose the category'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>  
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'issued_date')->widget(\kartik\datecontrol\DateControl::class, [
                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                    'saveFormat' => 'php:Y-m-d',
                    'ajaxConversion' => true,
                    'options' => [
                        'id' => 'jsdrivinglicensecategory-issued_date',
                        'pluginOptions' => [
                            'placeholder' => 'Choose date',
                            'autoclose' => true
                        ]
                    ],
                ]); ?>
        </div>
    </div>  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
