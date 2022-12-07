<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;

use backend\models\SIsco08Level1;
use backend\models\SIsco08Level2;
use backend\models\SIsco08Level3;
use backend\models\SIsco08Level4;

/* @var $this yii\web\View */
/* @var $model common\models\JsExperience */
/* @var $form yii\widgets\ActiveForm */

$model->iscolevel3_id = SIsco08Level4::findOne($model->occupation_id)['level3_id'];
$model->iscolevel2_id = SIsco08Level3::findOne($model->iscolevel3_id)['level2_id'];
$model->iscolevel1_id = SIsco08Level2::findOne($model->iscolevel2_id)['level1_id'];
?>


<?php $form = ActiveForm::begin(
    [
        'action' => $url,
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
    ]
); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jsexperience-id_' . $id, 'style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['id' => 'jsexperience-user_id_' . $id, 'value' => \Yii::$app->user->id])->label(false) ?>

    <div class='inline__flds'>
        <div class="input__fld">
            <?= $form->field($model, 'company')->textInput(['id' => 'jsexperience-company_' . $id, 'maxlength' => true, 'placeholder' => 'Enter Employer Name']) ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'iscolevel1_id')->dropDownList(
                ArrayHelper::map(SIsco08Level1::find()->all(), 'id', 'cat1_description'),
                [
                    'id' => 'jsexperience-iscolevel1_id_' . $id,
                    'prompt' => 'Select Occupation Level 1',
                    'onchange' => '
                                
                                $.post("' . Url::to(['../s-isco08-level2/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                        $("select#jsexperience-iscolevel2_id_' . $id . '" ).html(data);
                                });'
                ]);
            ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'iscolevel2_id')->dropDownList(
                ArrayHelper::map(SIsco08Level2::find()->all(), 'id', 'cat2_description'),
                [
                    'id' => 'jsexperience-iscolevel2_id_' . $id,
                    'prompt' => 'Select Occupation Level 2',
                    'onchange' => '
                                
                                $.post("' . Url::to(['../s-isco08-level3/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                        $("select#jsexperience-iscolevel3_id_' . $id . '").html(data);
                                });'
                ]);
            ?>
        </div>
    </div>

    <div class='inline__flds'>
        <div class="input__fld">
            <?= $form->field($model, 'iscolevel3_id')->dropDownList(
                ArrayHelper::map(SIsco08Level3::find()->all(), 'id', 'cat3_description'),
                [
                    'id' => 'jsexperience-iscolevel3_id_' . $id,
                    'prompt' => 'Select Occupation Level 3',
                    'onchange' => '
                                
                                $.post("' . Url::to(['../s-isco08-level4/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                        $("select#jsexperience-occupation_id_' . $id . '").html(data);
                                });'
                ]);
            ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'occupation_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(SIsco08Level4::find()->orderBy('occupation')->asArray()->all(), 'id', 'occupation'),
                ['id' => 'jsexperience-occupation_id_' . $id, 'prompt' => Yii::t('app', 'Select Occupation Level 4')]); 
            ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'exact_position')->textInput(
                [
                    'id' => 'jsexperience-exact_position_' . $id, 'maxlength' => true, 'placeholder' => 'Enter Exact Position Name'
                ]
            ) ?>
        </div>
    </div>

    <div class='inline__flds'>
        <div class="input__fld">
            <?= $form->field($model, 'experience_in_this_occupation')->dropDownList(
                \yii\helpers\ArrayHelper::map(\common\models\SExperienceInterval::find()->orderBy('id')->asArray()->all(), 'id', 'experience_interval'),
                ['id' => 'jsexperience-experience_in_this_occupation_' . $id, 'prompt' => Yii::t('app', 'Select Experience in this Occupation')]); 
            ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'start_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => false,
                'options' => [
                    'id' => 'jsexperience-start_date_' . $id,
                    'pluginOptions' => [
                        'placeholder' => Yii::t('app', 'Enter Start Date'),
                        'autoclose' => true
                    ]
                ],
            ]); ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'end_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => false,
                'options' => [
                    'id' => 'jsexperience-end_date_' . $id,
                    'pluginOptions' => [
                        'placeholder' => Yii::t('app', 'Enter End Date'),
                        'autoclose' => true
                    ]
                ],
            ]); ?>
        </div>
    </div>

    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>