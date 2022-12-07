<?php

use \yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\SDistrict;
use backend\models\SProvince;

/* @var $this yii\web\View */
/* @var $model common\models\MdAddress */
/* @var $form yii\widgets\ActiveForm */

$model->other_source = 0;
$model->province = SDistrict::findOne($model->district_id)['province_id'];
?>

<br>
<b>Form to Post Opportunity From Other Source</b>
<hr>

<?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl($url)]); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

<?= $form->field($model, 'other_source')->hiddenInput(['value' => 0])->label(false) ?>

<div class="row">
    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 's_opportunity_id')->dropDownList(
                ArrayHelper::map($opportinities, 'id', 'name'),
                [
                    'prompt' => 'Select Opportunity Type',
                ]
        );
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <?php //Yii::$app->label::helper($model,'employer_logo')
        ?>
        <?php
        echo '<b>Employer Logo<span class="red-star">*</span></b>';

        echo $form->field($model, 'employer_logo')->fileInput()->label(false);
        ?>
        <span style="font-size: 12px;font-style: italic">Only PNG file is accepted</span> |
        <span style="font-size: 12px;font-style: italic">Maximum file size is 2MB</span>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <?=
                $form->field($model, Html::encode('link'))
                ->textInput(
                        [
                            'maxlength' => true,
                            'onChange' => 'removeHttps("servicejob-link")',
                            'placeholder' => 'Enter Opportunity Link'
                        ]
                )
                ->label('Job Link <span class="red-star">*</span>');
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8 mb-3">
        <?= $form->field($model, 'employer')->textInput(['onChange' => 'removeHttps("servicejob-employer")', 'maxlength' => true, 'placeholder' => 'Enter Employer Name']) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'jobtitle')->textInput(['maxlength' => true, 'placeholder' => 'Enter Job Title']) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 'occupation_grouping_id')->dropDownList(
                ArrayHelper::map(\common\models\SOccupationGrouping::find()->all(), 'id', 'occupation_grouping'),
                [
                    'id' => 'occupation_grouping_id',
                    'prompt' => Yii::t('app', 'Select Occupation Group')
                ]
        );
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <?= $form->field($model, 'posting_date')->dateInput(['maxlength' => true,]) ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <?= $form->field($model, 'closure_date')->dateInput(['maxlength' => true,]) ?>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <?=
        $form->field($model, 'province')->dropDownList(
                ArrayHelper::map(SProvince::form(), 'id', 'province'),
                [
                    'id' => 'job_province',
                    'prompt' => Yii::t('app', 'Select Province'),
                    'onchange' => '
									$.post( "' . Url::to(['/s-district/lists', 'id' => '']) . '"+$(this).val(),function(data){
										$("#job_district").html(data);
									});'
                ]
        );
        ?>
    </div>
    <div class="col-md-6 mb-3">
        <?=
        $form->field($model, 'district_id')->dropDownList(
                ArrayHelper::map(SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
                [
                    'id' => 'job_district',
                    'prompt' => Yii::t('app', 'Select District')
                ]
        );
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 'competency_level_id')->dropDownList(
                ArrayHelper::map(\common\models\SCompetencyLevel::find()->all(), 'id', 'competency_level'),
                [
                    'id' => 'competency_level_id',
                    'prompt' => Yii::t('app', 'Select Competency Level')
                ]
        );
        ?>
    </div>
</div>
<div class="col-md-12">
        <div class="mb-3">
           <?=$form->field($model, 'docFile')->fileInput();?>
        </div>
    </div>
<div class="row">
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'apply_through_kora_flag')->checkbox(['value' => 1]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 'action_id')->dropDownList(
                ArrayHelper::map(\backend\models\SActions::find()->asArray()->all(), 'pk_action', 'action'),
                [
                    'id' => 'action',
                    'prompt' => Yii::t('app', 'Select Action')
                ]
        );
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">

        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Post') : Yii::t('app', 'Update'), ['id' => 'button', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php } ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script>
    function addLocation() {
        let province = $("#job_province").val();
        let district = $("#job_district").val();
        let position = $("#job_position").val();

        let province_text = $("#job_province option:selected").text();
        let district_text = $("#job_district option:selected").text();

        $('#location tr:last').after(`
                                        <tr id="myTableRow_` + district + `"> 
                                                <td width="30%"><input type="hidden" name ="ServiceJob[province][]" value="` + province + `">` + province_text + `</td>
                                                <td  width="30%"><input type="hidden" name ="ServiceJob[district][]" value="` + district + `">` + district_text + `</td>
                                                <td  width="30%"><input type="hidden" name ="ServiceJob[position][]" value="` + position + `">` + position + `</td>
                                                <td width="10%"><a onClick="removerow(` + district + `)"><span class="btn btn-danger">-</span></a><td>
                                        </tr>`);
    }

    function removerow(district) {
        $("#myTableRow_" + district).remove();
    }

    // function removeHttps(id) {
    // 	let n = $("#" + id).val().toLowerCase().match('http://');
    // 	if (n != null) {
    // 		let httplink = $("#" + id).val().toLowerCase().replace('http://', '');
    // 		$("#" + id).val(httplink);
    // 	} else {
    // 		let httplink = $("#" + id).val().toLowerCase().replace('https://', '');
    // 		$("#" + id).val(httplink);
    // 	}
    // }

    function removeHttps(id) {
        let n = $("#" + id).val().match('http://');
        if (n != null) {
            let httplink = $("#" + id).val().replace('http://', '');
            $("#" + id).val(httplink);
        } else {
            let httplink = $("#" + id).val().replace('https://', '');
            $("#" + id).val(httplink);
        }
    }
</script>