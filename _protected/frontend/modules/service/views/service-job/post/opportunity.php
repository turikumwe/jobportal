<?php

use dosamigos\tinymce\TinyMce;
use \yii\helpers\ArrayHelper;
use \kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\SDistrict;
use backend\models\SProvince;
use backend\models\SIsco08Level1;
use backend\models\SIsco08Level2;
use backend\models\SIsco08Level3;
use backend\models\SIsco08Level4;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\MdAddress */
/* @var $form yii\widgets\ActiveForm */

$model->other_source = 0;
$model->isco08level3_id = SIsco08Level4::findOne($model->economic_sector_id)['level3_id'];
$model->isco08level2_id = SIsco08Level3::findOne($model->isco08level3_id)['level2_id'];
$model->isco08level1_id = SIsco08Level2::findOne($model->isco08level2_id)['level1_id'];

$model->province = SDistrict::findOne($model->district_id)['province_id'];
?>
<div class="service-job-form">
    <br>
    <b>Form to Post Opportunity</b>
    <hr>
    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl($url), 'id' => 'Job_Opportunity_Form'], ['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'other_source')->hiddenInput(['value' => 1])->label(false) ?>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
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
        <div class="col-xxl-12">
            <div class="mb-3">
                <?= $form->field($model, 'jobtitle')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <?=
            $form->field($model, 'isco08level1_id')->dropDownList(
                    ArrayHelper::map(SIsco08Level1::find()->all(), 'id', 'cat1_description'),
                    [
                        'prompt' => 'Select Occupation Level 1',
                        'onchange' => '
									
									$.post("' . Url::to(['../s-isco08-level2/lists', 'id' => '']) . '"+$(this).val(),function(data){
											$("select#servicejob-isco08level2_id" ).html(data);
									});'
                    ]
            )->label('Occupation Level 1<span class="red-star">*</span>');
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <?=
            $form->field($model, 'isco08level2_id')->dropDownList(
                    ArrayHelper::map(SIsco08Level2::find()->all(), 'id', 'cat2_description'),
                    [
                        'prompt' => 'Select Occupation Level 2',
                        'onchange' => '
									
									$.post("' . Url::to(['../s-isco08-level3/lists', 'id' => '']) . '"+$(this).val(),function(data){
											$("select#servicejob-isco08level3_id" ).html(data);
									});'
                    ]
            )
            ;
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <?=
            $form->field($model, 'isco08level3_id')->dropDownList(
                    ArrayHelper::map(SIsco08Level3::find()->all(), 'id', 'cat3_description'),
                    [
                        'prompt' => 'Select Occupation Level 3',
                        'onchange' => '
									
									$.post("' . Url::to(['../s-isco08-level4/lists', 'id' => '']) . '"+$(this).val(),function(data){
											$("select#servicejob-economic_sector_id" ).html(data);
									});'
                    ]
            );
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <?=
            $form->field($model, 'economic_sector_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(SIsco08Level4::find()->orderBy('occupation')->asArray()->all(), 'id', 'occupation'),
                    ['prompt' => Yii::t('app', 'Select Occupation Level 4')]
            );
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <input type="hidden" id="saved_employer" value="<?= $model->employer ?>" />
            <?php
            $company_array = array();
            if (Yii::$app->user->can('mediator')) {
                $current_company['id'] = '0';
                $current_company['company_name'] = 'Not registered';
                array_push($company_array, $current_company);
            }
            if (count($user_companies) > 0) {
                foreach ($user_companies as $company) {
                    $current_company = array();
                    $current_company['id'] = $company['id'];
                    $current_company['company_name'] = $company['company_name'];
                    array_push($company_array, $current_company);
                }
            }
            if (intval($model->employer) == 0 && $model->id > 0) {
                $model->employer = 0;
            }

            echo $form->field($model, 'employer')->dropDownList(
                    \yii\helpers\ArrayHelper::map($company_array, 'id', 'company_name'),
                    ['prompt' => Yii::t('app', 'Select employer'), 'onchange' => 'check_slected(this.value)']
            )->label('Employer<span class="red-star">*</span>');
            ?>

        </div>
    </div>
</div>
<div class="row" id="other_institution" style="display: none;">
    <div class="col-md-12">
        <div class="mb-3">
            <?= $form->field($model, 'employer')->textInput(['maxlength' => true, 'placeholder' => '', 'id' => 'other_employer'])->label('Specify employer <span class="red-star">*</span>', ['class' => 'control-label']) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <?=
            $form->field($model, 'occupation_grouping_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SOccupationGrouping::find()->all(), 'id', 'occupation_grouping'),
                    ['prompt' => Yii::t('app', 'Select Occupation Group')]
            );
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <?=
            $form->field($model, 'job_type_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SJobType::find()->orderBy('job_type')->asArray()->all(), 'id', 'job_type'),
                    ['prompt' => Yii::t('app', 'Select Contract Type')]
            );
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <?=
            $form->field($model, 'job_responsability')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'en',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <?=
            $form->field($model, 'how_to_apply')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'en',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);
            ?>
        </div>
    </div>
</div>
<div class="row" style="display: none">
    <div class="col-md-12">
        <div class="mb-3">
            <?=
            $form->field($model, 'job_summary')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'en',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <?=
            $form->field($model, 'education_level_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
                    ['prompt' => Yii::t('app', 'Select Education Level')]
            );
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="pxp-company-job-category" class="form-label">Required assessment test(s)</label>
            <select class="form-control select2" multiple="" data-placeholder="Select Education Fields" tabindex="-1" aria-hidden="true" name="JobAssessments[]">
                <?php
                if (count($registered_assessments) > 0) {
                    foreach ($registered_assessments as $assessment) {
                        ?>
                        <option value='<?= $assessment->id; ?>' <?= (in_array($assessment->id, $selected_assessments)) ? 'selected' : '' ?>><?= $assessment->name; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="pxp-company-job-category" class="form-label">Education Fields</label>
            <select class="form-control select2" multiple="" data-placeholder="Select Education Fields" tabindex="-1" aria-hidden="true" name="EducationField[]">
                <?php
                if (count($educationfields) > 0) {
                    foreach ($educationfields as $edufield) {
                        ?>
                        <option value='<?= $edufield['id']; ?>' <?= (in_array($edufield['id'], $selected_education_field)) ? 'selected' : '' ?>><?= $edufield['field']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <div class="form-group field-servicejob-education_level_id">
                <label for="pxp-company-job-category" class="form-label">Required skills</label>
                <select class="form-control select2" multiple="" data-placeholder="Select skills" tabindex="-1" aria-hidden="true" name="JobSkills[]">
                    <?php
                    if (count($skills) > 0) {
                        foreach ($skills as $skill) {
                            ?>
                            <option value='<?= $skill['id']; ?>' <?= (in_array($skill['id'], $selected_job_skills)) ? 'selected' : '' ?>><?= $skill['skill']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <?= $form->field($model, 'years_of_experience')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <?= $form->field($model, 'closure_date')->dateInput(['maxlength' => true,]) ?>

        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-6">
        <div class="mb-3">
            <?php $form->field($model, 'job_remuneration')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
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
    </div>
    <div class="col-md-4">
        <div class="mb-3">
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
    <div class="col-md-4">
        <div class="mb-3">
            <?= $form->field($model, 'positions_number')->textInput(['id' => 'job_position', 'placeholder' => ''])->label('Number of positions<span class="red-star">*</span>'); ?>
        </div>
        <!-- <div class="col-md-2">
                        <div>&nbsp;</div>
                        <div class="pull-left btn btn-success"><a href="#location" style="color:white" onClick="addLocation()">Add</a></div>
                </div> -->
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="display: none">
        <div class="mb-3">
            <?=
            $form->field($model, 'competency_level_id')->dropDownList(
                    ArrayHelper::map(\common\models\SCompetencyLevel::find()->all(), 'id', 'competency_level'),
                    [
                        'id' => 'competency_level_id',
                        'placeholder' => Yii::t('app', 'Select Competency Level')
                    ]
            );
            ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            <?= $form->field($model, 'docFile')->fileInput(); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <?= $form->field($model, 'apply_through_kora_flag')->checkbox(['value' => 1]) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
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
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <?php if (!Yii::$app->request->isAjax) { ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Post') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
</div>
<script>
    $(document).ready(function () {
        if (isNaN(parseInt($('#saved_employer').val()))) {
            $('#servicejob-employer').attr('name', "Other");
            $('#other_institution').css("display", "block");
            $('#other_employer').val($('#saved_employer').val());
            $('#other_employer').attr('name', "ServiceJob[employer]");
        }
    });
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

    function removeHttps(id) {
        let httplink = $("#" + id).val().toLowerCase().replace('https', 'http');
        $("#" + id).val(httplink);
    }

    function check_slected(value) {
        if (value === '0') {
            $('#servicejob-employer').attr('name', "Other");
            $('#other_institution').css("display", "block");
            $('#other_employer').attr('name', "ServiceJob[employer]");
        } else {
            $('#servicejob-employer').attr('name', "ServiceJob[employer]");
            $('#other_institution').css("display", "none");
            $('#other_employer').attr('name', "Other");
        }
    }

    //$('#Job_Opportunity_Form').attr('onsubmit', 'return false;');

    function validate_form_data() {
        var data = $("#person-form-edit_person-form").serialize();


        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::$app->link->frontendUrl('/service/service-job/validate-form-data') ?>',
            data: data,
            success: function (data) {
                alert(data);
            },
            error: function (data) { // if error occured
                alert("Error occured.please try again");
                alert(data);
            },

            dataType: 'html'
        });
    }

</script>
