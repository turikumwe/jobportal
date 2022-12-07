<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceJobSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel widget light-widget panel-bd-top" >
<div class="panel-heading"><?= Yii::t("frontend","Other Search") ?></div>
    <div class="panel-body">
        <div class="form-service-job-search">
            <div class="form-service-job-search">

                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

                <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
                <!-- <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'employer')->textInput(['maxlength' => true, 'placeholder' => 'Employer']) ?>
                    </div>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'jobtitle')->textInput(['maxlength' => true, 'placeholder' => 'Jobtitle']) ?>
                    </div>
                </div> -->

                <div class="row">
                    <!-- <div class="col-sm-12">
                        <?php echo $form->field($model, 'job_remuneration')->textInput(['placeholder' => 'Job Remuneration']) ?>
                    </div> -->
                    <div class="col-sm-12">
                        <?= $form->field($model,'economic_sector_id')->widget(\kartik\widgets\Select2::classname(), [
                            'data' => \yii\helpers\ArrayHelper::map(\backend\models\SIsicr4Level4::find()->orderBy('ecosector')->asArray()->all(), 'id', 'ecosector'),
                            'options' => ['placeholder' => Yii::t('frontend', 'Economic sector')],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'education_level_id')->widget(\kartik\widgets\Select2::classname(), [
                            'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
                            'options' => ['placeholder' => Yii::t('frontend', 'Qualification')],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'education_field_id')->widget(\kartik\widgets\Select2::classname(), [
                            'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('field')->asArray()->all(), 'id', 'field'),
                            'options' => ['placeholder' => Yii::t('frontend', 'Education field')],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                
            <?php /* echo $form->field($model, 'posting_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                    'saveFormat' => 'php:Y-m-d',
                    'ajaxConversion' => true,
                    'options' => [
                        'pluginOptions' => [
                            'placeholder' => Yii::t('app', 'Choose Posting Date'),
                            'autoclose' => true
                        ]
                    ],
                ]); */ ?>

                <?php /* echo $form->field($model, 'closure_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                    'saveFormat' => 'php:Y-m-d',
                    'ajaxConversion' => true,
                    'options' => [
                        'pluginOptions' => [
                            'placeholder' => Yii::t('app', 'Choose Closure Date'),
                            'autoclose' => true
                        ]
                    ],
                ]); */ ?>

                <?php /* echo $form->field($model, 'district_id')->textInput(['placeholder' => 'District']) */ ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('frontend', 'Search'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton(Yii::t('frontend', 'Reset'), ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
</div>
