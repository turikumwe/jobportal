<?php

use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\SOccupationGrouping;
use frontend\modules\hr\models\ApiSyncing;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use frontend\modules\hr\models\ApiAssessmentTest;
use frontend\modules\hr\models\ApiAssessments;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');

$this->title = Yii::t('frontend', 'User Profiles');
$this->params['breadcrumbs'][] = $this->title;

$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});";

$search_candidates = "$('.search-button-candidates').click(function(){ 
    $('.search-form-candidates').toggle(1000); 
    return false; 
});";

$this->registerJs($search);
$this->registerJs($search_candidates);

CrudAsset::register($this);
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <?php
        if (Yii::$app->session->hasFlash('error')):
            ?>
            <div class="alert alert-danger alert-dismissible">
                <strong><i class="icon fa fa-close"></i>Error!</strong> <?= Yii::$app->session->getFlash('error') ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: red; font-weight: bold;">&times;</a>
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <strong><i class="icon fa fa-check"></i>Success!</strong> <?= Yii::$app->session->getFlash('success') ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: green; font-weight: bold;">&times;</a>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <table class="table table-hover align-middle">
                        <tbody><tr>
                                <td style="font-size: 30px;">Assessment</td>
                                <td>
                                    <div class="pxp-candiadates-card-1-name" style="font-size: 30px;"><?= $assessment->name; ?> </div>
                                    <div class="pxp-company-dashboard-job-title">
                                        <div class="pxp-candiadates-card-1-title" style="font-size: 20px;font-size: 20px;"><i class="fa fa-flash"></i> <?= ApiAssessmentTest::find()->where(['assessment_id' => $assessment->id])->count() ?> Test | <i class="fa fa-clock-o"></i> <?= ApiAssessments::get_assessment_duration($assessment->id) ?> Minutes | <i class="fa fa-flag-o" ></i> <?= isset(ApiAssessments::LANGUAGE_DICT['' . $assessment->language . '']) ? ApiAssessments::LANGUAGE_DICT['' . $assessment->language . ''] : $assessment->language ?></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <table class="table table-hover align-middle">
                        <tbody><tr>
                                <td style="font-size: 30px;">Candidate</td>
                                <td>
                                    <div class="pxp-company-dashboard-job-title"> 	
                                        <div class="pxp-candiadates-card-1-name" style="font-size: 30px;"> 	<?= $candidate_user_profile->firstname . ' ' . $candidate_user_profile->lastname; ?> </div>
                                        <div class="pxp-candiadates-card-1-title" style="font-size: 20px;font-weight: 20;"><?= $candidate->email; ?></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-6">
                <?php if ($candidate->status == "completed") { ?>
                    <span style="float: right;">
                        <div class="pxp-dashboard-table-options">
                            <ul class="list-unstyled">
                                <a href="<?php echo Yii::$app->link->frontendUrl('/hr/api/candidate-send-pdf-result?tt_id=' . $candidate->testtaker_id . '&c_id=' . $candidate->candidate_id . '') ?>"><li style="size: 40px;"><button class="action-button" title="Send results to candidate"><span class="fa fa-envelope-o"></span></button></li></a>
                                <a href="<?php echo Yii::$app->link->frontendUrl('/hr/api/candidate-result-pdf?tt_id=' . $candidate->testtaker_id . '&c_id=' . $candidate->candidate_id . '') ?>" target="_blank"><li><button class="action-button" title="Download results"><span class="fa fa-download"></span></button></li></a>
                            </ul>
                        </div>
                    </span>
                <?php } ?>
            </div>
        </div>
        <br />

        <div class="kora-container vd_content-section clearfix">
            <div class='row'>
                <!-- <div class="col-sm-3"> -->
                <?php /* echo Yii::$app->jobSeeker->menu(); */ ?>
                <!-- </div> -->

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="hidden" value="<?= $assessment->id; ?>" id="current_assessment_id"/>
                            <input type="hidden" value="<?= $candidate->candidate_id; ?>" id="current_candidate_id"/>
                            <input type="hidden" value="<?= $candidate->testtaker_id; ?>" id="current_testtaker_id"/>
                            <div class="pxp-posts-card-1 pxp-has-border" style="border-radius: 0px; border: 0px; border-right: 1px solid var(--pxpLightGrayColor);">
                                <div class="pxp-posts-card-1-top">

                                    <div class="pxp-posts-card-1-content">
                                        <a href="#" class="pxp-posts-card-1-title">Invited</a>
                                        <div class="pxp-posts-card-1-summary pxp-text-light"><?= date_format(date_create($candidate_details->invited), "M d, Y H:m:s"); ?></div>
                                    </div>
                                    <?php if ($candidate_details->status != 'invited') { ?>
                                        <div class="pxp-posts-card-1-content">
                                            <a href="#" class="pxp-posts-card-1-title"><?= ucfirst($candidate_details->status); ?></a>
                                            <div class="pxp-posts-card-1-summary pxp-text-light"><?= date_format(date_create($candidate_details->last_activity), "M d, Y H:m:s"); ?></div>
                                        </div>
                                    <?php } ?>
                                    <div class="pxp-posts-card-1-content">
                                        <a href="#" class="pxp-posts-card-1-title">Extra time breakdown</a>
                                        <div class="pxp-posts-card-1-summary pxp-text-light"><?= ($candidate_details->assessment_extra_time == 0) ? 'No extra time was granted to this candidate' : $candidate_details->assessment_extra_time ?></div>
                                    </div>
                                    <div class="pxp-posts-card-1-content">
                                        <a href="#" class="pxp-posts-card-1-title">Total extra time</a>
                                        <div class="pxp-posts-card-1-summary pxp-text-light"><?= $candidate_details->total_extra_time ?></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="pxp-posts-card-1 pxp-has-border" style="border-radius: 0px; border: 0px; border-right: 1px solid var(--pxpLightGrayColor); padding-right: 20px;">
                                <div class="row">
                                    <div class="col-sm-10" >
                                        <div class="pxp-posts-card-1-content">
                                            <a href="#" class="pxp-posts-card-1-title">Test name</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" >
                                        <div class="pxp-posts-card-1-content">
                                            <a href="#" class="pxp-posts-card-1-title">Score</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="please_wait_icon"><center>Please wait <div class="spinner-border"></div></center></div>

                                <div class="accordion pxp-faqs-accordion assessment-test-accordion" id="pxpFAQsAccordion">


                                </div>
                                <table class="table table-hover" style="background-color:#fff;color:#333;">
                                    <thead>
                                        <tr style="background-color: #0dcaf0;">
                                            <th style="width: 70%; font-size: 25px;">Average score</th>
                                            <th><span style="float: right;font-size: 25px;" id="overall_score"><?= $candidate->average ?>%</span></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <table class="table table-hover" style="background-color:#fff;color:#333;">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">Anti-cheating monitor </th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="AntiCheatingRows">

                                </tbody>
                            </table>
                            <div id="please_wait_meta_icon"><center>Please wait <div class="spinner-border"></div></center></div>
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" id="CandidateImages">

                                </div>
                                <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- / Collapsible element -->
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#crud-datatable-filters').css("display", "none");
        assessment_test_results($("#current_assessment_id").val(), $("#current_testtaker_id").val());
        assessment_candidate_meta_results($("#current_testtaker_id").val(), $("#current_candidate_id").val());
    });
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });
    $(".select-on-check-all").change(function () {
        if (this.checked) {
            $('#Include_all_div').css("display", "block");
        } else {
            $('#Include_all_div').css("display", "none");
            $('#include_all_records').val('0');
        }
    });
    function load_data() {

    }
    function assessment_test_results(assessment_id, test_taker_id) {

        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/hr/api/assessment-test-results') ?>',
            type: 'get',
            data: {
                assessent_id: assessment_id,
                tt_id: test_taker_id
            },
            dataType: 'json',
            success: function (data) {
                var total_records = data.results.length;
                $('#please_wait_icon').css("display", "none");

                if (parseInt(total_records) > 0) {
                    for (i = 0; i < data.results.length; i++) {
                        var test_data_accordion = "<div class='accordion-item'> <h2 class='accordion-header' id='pxpFAQsHeader" + data.results[i].id + "'> <div class='row'> <div class='col-sm-11'> <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#pxpCollapseFAQs" + data.results[i].id + "' aria-expanded='false' aria-controls='pxpCollapseFAQs" + data.results[i].id + "'> " + data.results[i].name + " </button> </div> <div class='col-sm-1' style='font-size: 1rem; padding: 1rem 1.25rem;'> " + data.results[i].score + "% </div> </div> </h2> <div id='pxpCollapseFAQs" + data.results[i].id + "' class='accordion-collapse collapse' aria-labelledby='pxpFAQsHeader" + data.results[i].id + "' data-bs-parent='#pxpFAQsAccordion' style=''> <div class='accordion-body'>";

                        if (data.results[i].skill_areas_score.length > 0) {
                            var result_table = "<table class='table table-hover' style='background-color:#fff;color:#333;'><tbody>";
                            for (s = 0; s < data.results[i].skill_areas_score.length; s++) {
                                var score_color = "success";
                                var score_percentage = parseInt(data.results[i].skill_areas_score[s].score) / parseInt(data.results[i].skill_areas_score[s].total_questions);
                                if (parseFloat(score_percentage) < 0.5) {
                                    score_color = "danger";
                                }
                                result_table += "<tr> <td style='width: 60%'>" + data.results[i].skill_areas_score[s].description + "</td> <td style='width: 25%'> answered " + data.results[i].skill_areas_score[s].answered_questions + "/" + data.results[i].skill_areas_score[s].total_questions + "</td> <td><span style='float: right;'><button type='button' class='btn btn-" + score_color + "'>" + data.results[i].skill_areas_score[s].score + "/" + data.results[i].skill_areas_score[s].total_questions + "</button></span></td> </tr>";
                            }
                            result_table += "</tbody></table>";
                        }
                        test_data_accordion += result_table;
                        test_data_accordion += "</div> </div> </div>";
                        $('#pxpFAQsAccordion').append(test_data_accordion);
                    }
                }
            }
        });
    }
    function assessment_candidate_meta_results(testtaker_id, candidate_id) {

        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/hr/api/assessment-candidate-details') ?>',
            type: 'get',
            data: {
                testtaker_id: testtaker_id,
                candidate_id: candidate_id
            },
            dataType: 'json',
            success: function (data) {
                $('#please_wait_meta_icon').css("display", "none");

                if (data.data.assessments_detail['0'].status === "completed") {

                    var full_screen_enabled = "True";
                    if (data.data.assessments_detail['0'].is_exited_full_screen === "false") {
                        full_screen_enabled = "False";
                    }
                    var met_row_data = "";
                    met_row_data += "<tr> <td>Device used</td> <td><span style='float: right;'>" + data.data.assessments_detail['0'].user_agent.description + "</td> </tr>";
                    met_row_data += "<tr> <td>Location</td> <td><span style='float: right;'>" + data.data.assessments_detail['0'].geoip.city + ", " + data.data.assessments_detail['0'].geoip.country_code + "</td> </tr>";
                    met_row_data += "<tr> <td>Webcam enabled?</td> <td><span style='float: right;'>" + data.data.assessments_detail['0'].is_camera_enabled + "</td> </tr>";
                    met_row_data += "<tr> <td>Full-screen mode always active?</td> <td><span style='float: right;'>" + full_screen_enabled + "</td> </tr>";
                    $('#AntiCheatingRows').append(met_row_data);
                }


            }
        });
    }

    function assessment_candidate_meta_results(testtaker_id, candidate_id) {

        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/hr/api/assessment-candidate-details') ?>',
            type: 'get',
            data: {
                testtaker_id: testtaker_id,
                candidate_id: candidate_id
            },
            dataType: 'json',
            success: function (data) {
                $('#please_wait_meta_icon').css("display", "none");

                if (data.data.assessments_detail['0'].status === "completed") {

                    var full_screen_enabled = "True";
                    if (data.data.assessments_detail['0'].is_exited_full_screen === "false") {
                        full_screen_enabled = "False";
                    }
                    var met_row_data = "";
                    met_row_data += "<tr> <td>Device used</td> <td><span style='float: right;'>" + data.data.assessments_detail['0'].user_agent.description + "</td> </tr>";
                    met_row_data += "<tr> <td>Location</td> <td><span style='float: right;'>" + data.data.assessments_detail['0'].geoip.city + ", " + data.data.assessments_detail['0'].geoip.country_code + "</td> </tr>";
                    met_row_data += "<tr> <td>Webcam enabled?</td> <td><span style='float: right;'>" + data.data.assessments_detail['0'].is_camera_enabled + "</td> </tr>";
                    met_row_data += "<tr> <td>Full-screen mode always active?</td> <td><span style='float: right;'>" + full_screen_enabled + "</td> </tr>";
                    $('#AntiCheatingRows').append(met_row_data);
                    var candidate_images = "";
                    if (data.data.assessments_detail['0'].test_taker_photos.length > 0) {
                        for (i = 0; i < data.data.assessments_detail['0'].test_taker_photos.length; i++) {
                            if (i === 0) {
                                candidate_images += "<div class='carousel-item active'> <img src='" + data.data.assessments_detail['0'].test_taker_photos[i].image + "' class='d-block w-100'></div>";
                            } else {
                                candidate_images += "<div class='carousel-item'> <img src='" + data.data.assessments_detail['0'].test_taker_photos[i].image + "' class='d-block w-100'></div>";
                            }
                        }
                        $('#CandidateImages').append(candidate_images);
                    }


                }


            }
        });
    }
</script>