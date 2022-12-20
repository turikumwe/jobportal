<?php

use dosamigos\tinymce\TinyMce;
use frontend\assets\FrontendAsset;
use backend\models\SDistrict;
use common\models\JobApplicationStatus;
use frontend\modules\jobseeker\models\search\JsAddressSearch;
use frontend\modules\service\models\search\ServiceJobSearch;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    if (Yii::$app->user->can('mediator')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else {
        include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php");
    }
    ?>
</div>
<div class="pxp-dashboard-content">


    <?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <strong><i class="icon fa fa-close"></i>Error!</strong> <?= Yii::$app->session->getFlash('placement_error') ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: red; font-weight: bold;">&times;</a>
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <strong><i class="icon fa fa-check"></i>Success!</strong> <?= Yii::$app->session->getFlash('success') ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: green; font-weight: bold;">&times;</a>
            </div>
        <?php endif; ?>
        <h1>Candidates</h1>
        <p class="pxp-text-light">Detailed list of candidates that applied for job offers.</p>

        <div class="mt-4">
            <div class="row justify-content-between align-content-center">

                <div class="col-auto order-2 order-sm-1">
                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                        <?php if (isset($selected_job) && ($selected_job->recruitment_stage != \common\models\ServiceJob::JOB_RECRUITMENT_STAGE_CLOSED)) { ?>
                            <select class="form-select" id="status">
                                <option>Bulk actions</option>
                                <option value="1">Waiting</option>
                                <option value="2">Accepted</option>
                                <option value="3">Rejected</option>
                            </select>
                            <button class="btn ms-2" onclick="return change_status();">Apply</button>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $applicant_count; ?> candidates</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_job_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-job/job-applicant')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="name" class="form-control" placeholder="Search candidates...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($applicants) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="pxp-is-checkbox" style="width: 1%;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th colspan="2" style="width: 25%;">Name</th>
                                <th >Cover</th>
                                <th style="width: 20%;">Applied for</th>
                                <th style="width: 15%;">Status</th>
                                <th>Applied on<span class="fa fa-angle-up ms-3"></span></th>
                                <th>Assessments<span class="fa fa-angle-up ms-3"></span></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody id="TableItems">
                            <?php
                            $counter = 1;
                            foreach ($applicants as $key => $candidate) {
                                $current_user = common\models\UserProfile::findOne($candidate->user_id);
                                if (isset($current_user)) {
                                    $current_job = ServiceJobSearch::findOne($candidate->job_id);
                                    $user_address = JsAddressSearch::getJobSeekerFirstAddress($candidate->user_id);
                                    $application_status = \common\models\JobApplicationStatus::find()->where(['id' => $candidate->job_application_status_id])->one();
                                    $job_application_status = null;
                                    if (isset($application_status)) {
                                        $job_application_status = backend\models\SStatus::findOne($application_status->status_id);
                                    }
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input checkboxAll" name="selected_application[]" value="<?= $candidate->id; ?>"></td>
                                        <td style="width: 3%;">
                                            <?php
                                            if (isset($current_user)) {

                                                $profilepic = common\models\UserProfile::findOne($current_user->user_id);
                                                if (isset($current_user->profile) && strlen($current_user->profile) > 2) {
                                                    ?>
                                                    <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/<?php echo $profilepic->profile; ?>);"></div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/noimage.png);"></div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?= Yii::$app->link->frontendUrl('/jobseeker/user-profile?js=' . $candidate->user_id) ?>" target="_blank">
                                                <div class="pxp-company-dashboard-job-title" style="color: black"><?= $current_user->firstname . ' ' . $current_user->lastname; ?></div>
                                                <div class="pxp-company-dashboard-job-title">View profile</div>
                                            </a>
                                        </td>
                                        <td>
                                            <a data-bs-toggle="modal" href="#cover-letter-modal"  href="#" onclick="return check_cover_letter(<?= $candidate->id; ?>)" >
                                                <div class="pxp-company-dashboard-job-title">View</div>
                                            </a>
                                        </td>
                                        <td><div class="pxp-company-dashboard-job-category"><?= isset($current_job->jobtitle) ? $current_job->jobtitle : ''; ?></div></td>
                                        <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-<?= isset($job_application_status->label) ? $job_application_status->label : 'secondary'; ?>"><?= isset($job_application_status->status) ? $job_application_status->status : 'Waiting'; ?></span></div></td>
                                        <td>
                                            <div class="pxp-company-dashboard-job-date"><?= $candidate->application_date; ?></div>
                                        </td>
                                        <td>
                                            <div class="pxp-company-dashboard-job-location">
                                                <?php
                                    $existing_job_assessments = \common\models\JobAssessment::findByJobId($current_job->id);
                                    if (count($existing_job_assessments) > 0) {
                                        $counter = 1;
                                        foreach ($existing_job_assessments as $current_assessment) {
                                            $assessment = \frontend\modules\hr\models\ApiAssessments::find()->where(['id' => $current_assessment['assessment_id']])->one();
                                            $user_assessment_results = frontend\modules\hr\models\ApiAssessmentCandidate::find()->where(['assessment_id' => $current_assessment['assessment_id']])->andWhere(['user_id' => $current_user->user_id])->one();
                                            $status_text = "";

                                            if ($counter == 1) {
                                                if (isset($user_assessment_results->status) && $user_assessment_results->status == 'completed') {
                                                    echo $counter . '. ' . $assessment->name;
                                                    ?><a href="<?php echo Yii::$app->link->frontendUrl('/hr/api/candidate-result-pdf?tt_id=' . $user_assessment_results->testtaker_id . '&c_id=' . $user_assessment_results->candidate_id . '') ?>" target="_blank" title="Click to view assessment results"><span class="badge rounded-pill bg-success">Completed - <?= $user_assessment_results->average ?>%</span></a>
                                                    <?php
                                                }else{
                                                    echo $counter . '. ' . $assessment->name;
                                                    ?><a href="#" title="Click to complete the assessment"><span class="badge rounded-pill bg-warning">Pending</span></a>
                                                    <?php
                                                }
                                            } else {
                                                if (isset($user_assessment_results->status) && $user_assessment_results->status == 'completed') {
                                                    echo '<br />'.$counter . '. ' . $assessment->name;
                                                    ?><a href="<?php echo Yii::$app->link->frontendUrl('/hr/api/candidate-result-pdf?tt_id=' . $user_assessment_results->testtaker_id . '&c_id=' . $user_assessment_results->candidate_id . '') ?>" target="_blank" title="Click to view assessment results"><span class="badge rounded-pill bg-success">Completed</span></a>
                                                    <?php
                                                }else{
                                                    echo '<br />'.$counter . '. ' . $assessment->name;
                                                    ?><a href="#" title="Click to complete the assessment"><span class="badge rounded-pill bg-warning">Pending</span></a>
                                                    <?php
                                                }
                                            }

                                            $counter++;
                                        }
                                    } else {
                                        echo 'Not needed';
                                    }
                                    ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pxp-dashboard-table-options">
                                                <ul class="list-unstyled">
                                                    <li><button title="Send message" class="action-button" data-bs-toggle="modal" href="#contact-jobseeker-modal" type="button" onclick="set_job_id(<?= $current_job->id ?>,<?= $candidate->user_id ?>)"><span class="fa fa-envelope-o"></span></button></li>
                                                    <?php if ($current_job->recruitment_stage != \common\models\ServiceJob::JOB_RECRUITMENT_STAGE_CLOSED) { ?>
                                                        <li>
                                                            <button title="Accept" class="action-button" onclick="return show_status_modal(<?= $candidate->id; ?>,<?= JobApplicationStatus::JOB_APPLICATION_STATUS_ACCEPTED ?>);" ><span class="fa fa-check"></span></button>
                                                        </li>
                                                        <li>
                                                            <button title="Reject" class="action-button-danger" onclick="return show_status_modal(<?= $candidate->id; ?>,<?= JobApplicationStatus::JOB_APPLICATION_STATUS_REJECTED ?>);" ><span class="fa fa-ban"></span></button>

                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $counter++;
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php $form = ActiveForm::begin(['id' => 'change_application_status', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-job/bulk-change-application-status')]); ?>
                    <input type="hidden" id="selected_application" name="selected_application" value="" />
                    <input type="hidden" id="selected_status" name="selected_status" value="" />
                    <?php ActiveForm::end(); ?>
                    <div class="row mt-4 justify-content-between align-items-center">
                        <div class="col-auto">
                            <nav class="mt-3 mt-sm-0" aria-label="Jobs list pagination">
                                <?php
                                echo CustomLinkPager::widget([
                                    'pagination' => $pagination,
                                ]);
                                ?>
                            </nav>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
<div class="modal fade pxp-user-modal" id="job-application_status-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-small">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Change application status</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['id' => 'change_status_form', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-job/change-status')]); ?>
                    <div class='input-text'> 
                        <div class="input-div">
                            <?= $form->field($job_application_status_model, 'status_comment')->textArea(['maxlength' => true, 'rows' => '6', 'placeholder' => 'Status comment']) ?>
                        </div>

                    </div>
                    <input type="hidden" name="JobApplicationStatus[job_application_id]" id="job_application_id" value="" />
                    <input type="hidden" name="JobApplicationStatus[status_id]" id="status_id" value="" />

                    <div class="col-md-12">
                        <div class="form-group">
                            <?= Html::submitButton($job_application_status_model->isNewRecord ? Yii::t('app', 'Submit changes') : Yii::t('app', 'Update'), ['class' => $job_application_status_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'onclick' => 'return confirm_status_update();']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade pxp-user-modal" id="cover-letter-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-small">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Cover letter</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <tbody id="TableItemsCover">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade pxp-user-modal" id="contact-jobseeker-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Contact job seeker</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="col-md-12">
                        <?php
                        $model = new \common\models\SNotifications();
                        $form = ActiveForm::begin(['id' => 'contact_jobseeker', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-job/contact-job-seeker')]);
                        ?>
                        <div class="form-group field-servicejob-closure_date required">
                            <div class="mb-3">
                                <input type="hidden" id="snotifications-opportunity_id" class="form-control" name="SNotifications[opportunity_id]" placeholder="" aria-required="true" aria-invalid="true">
                                <input type="hidden" id="snotifications-user_id" class="form-control" name="SNotifications[user_id]" placeholder="" aria-required="true" aria-invalid="true">
                            </div>
                            <div class="mb-3">
                                <?= $form->field($model, 'message_title')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
                            </div>
                            <div class="mb-3">
                                <?=
                                $form->field($model, 'message_body')->widget(TinyMce::class, [
                                    'options' => ['rows' => 10],
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
                        <hr />
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" onclick="return confirm_extention();">Send message</button>                
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function check_cover_letter(id) {
        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/service/api/cover-letter-modal') ?>',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                $("#TableItemsCover").empty().append(data.table_data);
                console.log(data.table_data);
            }
        });
    }
    function show_status_modal(job_application_id, status_id) {
        $("#job_application_id").val(job_application_id);
        $("#status_id").val(status_id);
        $("#job-application_status-modal").modal('show');
    }
    function set_job_id(job_id, user_id) {
        $("#snotifications-opportunity_id").val(job_id);
        $("#snotifications-user_id").val(user_id);
    }
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });

    function change_status() {
        var selected = new Array();
        $("#TableItems input[type=checkbox]:checked").each(function () {
            selected.push(this.value);
        });
        if (parseInt($('#status :selected').val()) && selected.length > 0) {

            if (confirm("Are sure you want to change the application Status?")) {
                $('#selected_application').val(selected.join(","));
                $('#selected_status').val($('#status :selected').val());
                $("#change_application_status").submit();
            }

        } else {
            alert("Please make valid selections");
        }

    }
    function confirm_status_update() {
        if (confirm("Are sure you want to change the application Status?")) {
            return true;
        } else {
            return false;
        }
    }
    function filter_by_opportunity() {
        if (parseInt($('#opportunity_type :selected').val()) > 0) {
            window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-job/my-jobs'); ?>' + '?type=' + $('#opportunity_type :selected').val();
        } else {
            alert("Please make valid selections")
        }

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

