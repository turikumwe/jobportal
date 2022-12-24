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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pxp-company-dashboard-job-title"> 	
                            <div class="pxp-candiadates-card-1-name" style="font-size: 30px;"> 	<?= $assessment->name; ?> </div>
                            <div class="pxp-candiadates-card-1-title" style="font-size: 20px;font-size: 20px;"><i class="fa fa-flash"></i> <?= ApiAssessmentTest::find()->where(['assessment_id'=>$assessment->id])->count() ?> Test | <i class="fa fa-clock-o" ></i> <?= ApiAssessments::get_assessment_duration($assessment->id) ?> Minutes | <i class="fa fa-flag-o" ></i> <?= isset(ApiAssessments::LANGUAGE_DICT['' . $assessment->language . '']) ? ApiAssessments::LANGUAGE_DICT['' . $assessment->language . ''] : $assessment->language ?></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-6">
                <span style="float: right;">
                    <div class="row">
                        <?php
                        $label_color = "danger";

                        if (isset($assessement_details_synchronization)) {
                            $last_synchronisation_days = ceil((abs(strtotime(date("Y-m-d")) - strtotime($assessement_details_synchronization->sync_ended)) / (60 * 60 * 24)));
                            if ($last_synchronisation_days < 10) {
                                $label_color = "success";
                            }
                            if ($last_synchronisation_days > 10 && $last_synchronisation_days <= 30) {
                                $label_color = "warning";
                            }
                            if ($last_synchronisation_days > 30) {
                                $label_color = "danger";
                            }
                        }
                        ?>
                        <div class=" card bg-<?= $label_color ?> text-white col-sm-9">
                            <div class="card-body">
                                Last synced<br />
                                <span style="color: #fff; font-weight: bold"><?= (isset($assessement_details_synchronization)) ? date("M d, Y h:i:s A", strtotime($assessement_details_synchronization->sync_ended)) : 'Never synchronized...'; ?></span>
                            </div>
                        </div>
                        <div class=" card bg-success text-white col-sm-3">
                            <div class="card-body">
                                <span href="#" <?= !ApiSyncing::iSSyncing(ApiSyncing::OBJECT_NAME_ASSESSMENT_DETAILS, $current_assessment_id) ? 'onclick="sync_assessment_details(' . $current_assessment_id . ');" title="Click to synchronize"' : ' title="Synchronization in progress"' ?>  style="<?= ApiSyncing::iSSyncing(ApiSyncing::OBJECT_NAME_ASSESSMENT_DETAILS) ? 'cursor: no-drop;' : 'cursor: pointer;' ?>">
                                    <i class="fa fa-refresh <?= ApiSyncing::iSSyncing(ApiSyncing::OBJECT_NAME_ASSESSMENT_DETAILS, $current_assessment_id) ? 'fa-spin' : '' ?>" id="sync_ass" style="font-size:44px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </span>

            </div>
        </div>
        <br />

        <div class="accordion" id="faq">
            <div class="card">
                <div class="card-header" id="faqhead1">
                    <a href="#" class="accordion-button" style="background-color: transparent; font-size: 30px; padding: 0px;" data-toggle="collapse" data-target="#faq1"
                       aria-controls="faq1">Invite additional candidates here </a>
                </div>

                <div id="faq1" class="<?= isset($_GET['UserProfileSearch']) ? 'collapse show in' : 'collapse' ?>" aria-labelledby="faqhead1" data-parent="#faq">
                    <div class="card-body">
                        <div class="kora-container vd_content-section clearfix">
                            <div class='row'>
                                <!-- <div class="col-sm-3"> -->
                                <?php /* echo Yii::$app->jobSeeker->menu(); */ ?>
                                <!-- </div> -->

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <p>
                                                <span>
                                                    <?= Html::a(Yii::t('app', 'Advanced Search'), '#', ['class' => 'btn btn-success search-button']) ?>
                                                </span>

                                            </p>

                                            <div class="well search-form" style="display:none">
                                                <?= $this->render('_search', ['model' => $searchModel]); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <span id="Include_all_div" style="display: none;">
                                                Do you want to include all <b><?= number_format($total_records, 0) ?></b> job seekers from the current list?<a href="#" class="btn rounded-pill pxp-nav-btn" onclick="include_all_jobseekers('1');">Yes</a>
                                            </span>
                                        </div>
                                        <div class="col-sm-2">
                                            <span style="float: right;">
                                                <a href="#" class="btn rounded-pill pxp-nav-btn" onclick="invite_selected();">Invite selected</a>
                                            </span>
                                        </div>
                                    </div>


                                    <div class="panel widget light-widget panel-bd-top">
                                        <div class="panel-body">
                                            <div class="user-profile-index">
                                                <div id="ajaxCrudDatatable">
                                                    <?php Pjax::begin(['id' => 'crud-datatable', 'timeout' => false, 'enablePushState' => false,]); ?>
                                                    <?=
                                                    GridView::widget([
                                                        'id' => 'crud-datatable',
                                                        'dataProvider' => $dataProvider,
                                                        'filterModel' => $searchModel,
                                                        'pjax' => true,
                                                        'showPageSummary' => false,
                                                        'striped' => false,
                                                        'hover' => true,
                                                        'panel' => ['type' => 'primary', 'heading' => 'Jobseeker list'],
                                                        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                                                        'columns' => require(__DIR__ . '/_jobseekerlist.php'),
                                                        'toolbar' => [
                                                            [
                                                                'content' =>
                                                                '{toggleData}' .
                                                                '{export}'
                                                            ],
                                                        ],
                                                        'striped' => true,
                                                        'condensed' => true,
                                                        'responsive' => true,
                                                        'panel' => [
                                                            'type' => '',
                                                        ],
                                                        'pager' => [
                                                            'class' => 'yii\widgets\CustomLinkPager',
                                                        //other pager config if nesessary
                                                        ],
                                                        'tableOptions' => [
                                                            'id' => 'JobSeekerTable',
                                                            'class' => 'table table-striped table-bordered'
                                                        ],
                                                    ])
                                                    ?>
                                                    <?php Pjax::end(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $form = ActiveForm::begin(['id' => 'invite_candidates', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/hr/assessments/invite-candidate')]); ?>
                        <input type="hidden" name="user_ids" id="selected_user_ids" value="<?= $all_jobseeker_ids ?>" />
                        <input type="hidden" name="assessment_id" id="assessment_id" value="<?= $current_assessment_id ?>" />
                        <input type="hidden" name="total_current_users" id="total_current_users" value="<?= $total_records ?>" />
                        <input type="hidden" name="include_all_records" id="include_all_records" value="0" />
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

        </div>
        <br />
        <div class="accordion" id="invited">
            <div class="card">
                <div class="card-header" id="faqhead2">
                    <a href="#" class="accordion-button exp" style="background-color: transparent; font-size: 30px; text-transform: uppercase;padding: 0px;" data-toggle="collapse" data-target="#faq2"
                       aria-controls="faq2" aria-expanded="tru">Invited Candidates</a>
                </div>

                <div id="faq2" class="collapse show in" aria-labelledby="faqhead2" data-parent="#invited">
                    <div class="card-body">
                        <div class="mt-4">
                            <div class="col-sm-7">
                                <p>
                                    <span>
                                        <?= Html::a(Yii::t('app', 'Advanced Search'), '#', ['class' => 'btn btn-success search-button-candidates']) ?>
                                    </span>

                                </p>

                                <div class="well search-form-candidates" style="display:none">
                                    <?= $this->render('_search_candidates', ['candidate_model' => $candidatesSearchModel]); ?>
                                </div>
                            </div>
                            <div class="row justify-content-between align-content-center">
                                <div class="col-auto order-2 order-sm-1">
                                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                                        <select class="form-select" id="action">
                                            <option>Bulk actions</option>
                                            <option value="1">Send reminder</option>
                                            <option value="2">Send results to candidates</option>
                                            <option value="3">Remove from assessment</option>
                                        </select>
                                        <button class="btn ms-2" onclick="return apply_bulk_action();">Apply</button>
                                    </div>
                                </div>
                                <div class="col-auto order-1 order-sm-2">
                                    <div class="pxp-company-dashboard-jobs-search mb-3">
                                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $assessment_candidates_count; ?> invited candidates</div>
                                        <div class="pxp-company-dashboard-jobs-search-search-form">
                                            <?php $form = ActiveForm::begin(['id' => 'search_assessment_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/hr/assessments/view')]); ?>
                                            <div class="input-group">
                                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                                <input type="text" name="title" class="form-control" placeholder="Search assessment...">
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (count($assessment_candidates) > 0) { ?>
                                <div class="table-responsive">
                                    <?php $form = ActiveForm::begin(['id' => 'bulk_candidate_action', 'action' => Yii::$app->link->frontendUrl('/hr/assessments/send-bulk')]); ?>
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th class="pxp-is-checkbox" style="width: 1%;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 40%;">Candidate names</th>
                                                <th style="width: 20%;">Invited on</th>
                                                <th style="width: 10%;">Obtained score</th>
                                                <th style="width: 20%;">Status</th>
                                                <th style="width: 20%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $counter = 1;
                                            foreach ($assessment_candidates as $candidate) {
                                                $candidate_user = \common\models\UserProfile::find()->where(['user_id' => $candidate->user_id])->one();
                                                ?>
                                                <tr>
                                                    <td><input type="checkbox" class="form-check-input checkboxAll" name="ids[]" value="<?= $candidate->id; ?>" class="job_selection"></td>
                                                    <td><?= $counter ?></td>
                                                    <td>
                                                        <a href="<?= Yii::$app->link->frontendUrl('/hr/assessments/assessment-candidate?id=' . $assessment->id . '&tt_id=' . $candidate->testtaker_id) ?>">
                                                            <div class="pxp-company-dashboard-job-title"><?= $candidate_user->firstname . ' ' . $candidate_user->lastname ?></div>
                                                        </a>
                                                    </td>
                                                    <td><?= $candidate->created ?></td>
                                                    <td><span class="color: red;"><?= $candidate->average ?>%</span></td>
                                                    <td>
                                                        <div class="pxp-company-dashboard-job-status">
                                                            <span class="badge rounded-pill bg-success"></span><?= $candidate->status; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="pxp-company-dashboard-job-date mt-1"><span style="color: red !important;">
                                                                <a href="#" onclick="return confirm_remove(<?= $candidate->candidate_id; ?>)">Delete candidate</a>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                $counter++;
                                            }
                                            ?>


                                        </tbody>
                                    </table>
                                    <input type="hidden" id="bulk_action" name="bulk_action" value="" />
                                    <?php ActiveForm::end(); ?>
                                    <div class="row mt-4 justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <nav class="mt-3 mt-sm-0" aria-label="Jobs list pagination">
                                                <?php
                                                echo CustomLinkPager::widget([
                                                    'pagination' => $assessment_candidates_pagination,
                                                ]);
                                                ?>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php ActiveForm::begin(['id' => 'delete_candidate', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/hr/assessments/delete-candidate')]); ?>
                            <input type="hidden" name="candidate_id" id="candidate_id" value="" />
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#crud-datatable-filters').css("display", "none");
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


    function sync_assessment_details(assessment_id) {
        $("#sync_ass").addClass("fa-spin");
        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/hr/assessments/sync-assessment-details') ?>',
            type: 'post',
            data: {
                id: assessment_id
            },
            dataType: 'json',
            success: function (data) {
                alert("Assessment details job synchronization started. You may reflesh the page to check the updates");
            }
        });
    }
    function apply_bulk_action() {
        var total_checked = $("input[type='checkbox']:checked").length;

        if (parseInt($('#action :selected').val()) && total_checked > 0) {
            if (confirm("Are sure you want to send reminders to the selected candidates?")) {
                $('#bulk_action').val($('#action :selected').val());
                $("#bulk_candidate_action").submit();
            }

        } else {
            alert("Please make valid selections")
        }

    }
    function confirm_remove(id) {
        if (confirm("Are you sure you want to permanently delete this candidate? Access to the assessment will be revoked if the candidate hasn’t completed their assessment. After deleting, you can re-invite the candidate.")) {
            $('#candidate_id').val(id);
            $("#delete_candidate").submit();
        }
    }
    function include_all_jobseekers(selection) {

        $('#include_all_records').val(selection);
    }
    function invite_selected() {
        var selected = new Array();
        $("#JobSeekerTable tbody input[type=checkbox]:checked").each(function () {
            selected.push(this.value);
        });
        if (selected.length > 0) {

            if ($('#include_all_records').val() === '1') {
                if (confirm("Send invitation to selected " + $("#total_current_users").val() + " jobseekers")) {
                    $("#invite_candidates").submit();
                }
            } else {
                if (confirm("Send invitation to selected " + selected.length + " jobseekers")) {
                    $('#selected_user_ids').val(selected.join(","));
                    $("#invite_candidates").submit();
                }
            }

        } else {
            alert("Please select job seeker from the list");
        }

    }
    function extent_deadline(job_id) {
        $('#job_id_to_extend').val(job_id);
    }
    function confirm_extention() {
        if (confirm("Are sure you want to extend the current job application deadline?")) {
            return true;
        }
        return false;

    }
    function filter_selected(status) {
        window.location.href = '<?= Yii::$app->link->frontendUrl('/hr/assessments'); ?>' + '?status=' + status;


    }
    function search_job() {
        if (parseInt($('#opportunity_type :selected').val()) > 0) {
            window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-job/my-jobs'); ?>' + '?type=0&' + $('#opportunity_type :selected').val();
        } else {
            alert("Please make valid selections")
        }

    }
    function confirm_delete() {
        if (confirm("Are you sure want to delete this? No undo")) {
            return true;
        } else {
            return false;
        }

    }
</script>

