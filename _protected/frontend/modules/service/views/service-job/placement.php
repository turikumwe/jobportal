<?php

use frontend\assets\FrontendAsset;
use backend\models\SDistrict;
use frontend\modules\jobseeker\models\search\JsAddressSearch;
use frontend\modules\service\models\search\ServiceJobSearch;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\ServiceJob;
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
        <?php if (Yii::$app->session->hasFlash('shortlisting_error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <strong><i class="icon fa fa-close"></i>Error!</strong> <?= Yii::$app->session->getFlash('shortlisting_error') ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: red; font-weight: bold;">&times;</a>
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('placement_error')): ?>
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
        <br>
        <h1>Candidates</h1>
        <p class="pxp-text-light">Detailed list of candidates that applied for job offers.</p>
        <?php
        if (isset($selected_job)) {
            $current_job = \common\models\ServiceJob::findOne($selected_job);
            $job_applicants = common\models\JsJobApplication::countApplications($selected_job);
            $shortlisted = common\models\JsJobApplication::shortlisted($selected_job);
            if (isset($current_job)) {
                ?>
                <table class="table table-hover align-middle">
                    <tbody>
                        <tr>
                            <th>Job title</th>
                            <td colspan="2"><?= $current_job->jobtitle; ?></td>
                        </tr>
                        <tr>
                            <th>Total applicants</th>
                            <td colspan="2"><?= $job_applicants; ?></td>
                        </tr>
                        <tr>
                            <th>Shortlisted applicants</th>
                            <td colspan="2"><?= count($shortlisted) ?></td>
                        </tr>
                        <tr>
                            <th>Results notification</th>
                            <td>
                                <?php
                                if (count($shortlisted) > 0 && ($current_job->results_notified == ServiceJob::RESULTS_NOTIFIED)) {
                                    ?>
                                    <button class="btn btn-success" role="button">Notifications sent</button>
                                    <?php
                                } else {
                                    ?>
                                    <button class="btn btn-warning" role="button">Notifications not sent</button>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <?php if (count($shortlisted) > 0 && ($current_job->results_notified != ServiceJob::RESULTS_NOTIFIED)) { ?>
                                    <div class="form-group">
                                        <?php $form = ActiveForm::begin(['id' => 'notify', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-job/notify-applicant')]); ?>
                                        <input type="hidden" id="notify_job_id" name="job_id" value="<?= $current_job->id; ?>" />
                                        <button class="btn btn-success" onclick="return confirm_notification_send();" role="button">Send notifications to applicants</button>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Recruitment status</th>
                            <td><?php
                                if ($current_job->recruitment_stage == ServiceJob::JOB_RECRUITMENT_STAGE_CLOSED) {
                                    ?>
                                    <button class="btn btn-danger" role="button">CLOSED</button>
                                    <?php
                                } else {
                                    ?>
                                    <button class="btn btn-success" role="button">OPEN</button>
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?php
                                if ($current_job->recruitment_stage != ServiceJob::JOB_RECRUITMENT_STAGE_CLOSED) {
                                    ?>
                                    <div class="form-group">
                                        <?php $form = ActiveForm::begin(['id' => 'close_application', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-job/close-job')]); ?>
                                        <input type="hidden" id="notify_job_id" name="job_id" value="<?= $current_job->id; ?>" />
                                        <button class="btn btn-success" onclick="return confirm_job_close();" role="button">Mark as closed</button>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
        }
        ?>
        <div class="mt-4">
            <div class="row justify-content-between align-content-center">

                <div class="col-auto order-2 order-sm-1" style="max-width: 500px;">
                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                        <select class="form-select" id="job_id">
                            <option>Select job</option>
                            <?php
                            if (count($jobs) > 0) {
                                foreach ($jobs as $key => $job) {
                                    ?>
                                    <option value="<?= $job->id ?>" <?= ($selected_job == $job->id) ? 'selected' : '' ?>><?= $job->jobtitle; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <button class="btn ms-2" onclick="return filter_job();">Filter</button>
                    </div>
                </div>
                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $applicant_count; ?> candidates</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_job_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-job/placement')]); ?>
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
                                <th class="pxp-is-checkbox" style="width: 1%;">#</th>
                                <th colspan="2" style="width: 25%;">Name</th>
                                <th style="width: 20%;">Applied for</th>
                                <th style="width: 15%;">Shorlisting Status</th>
                                <th style="width: 15%;">Placement Status</th>
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
                                    } else {
                                        echo 'No status' . $candidate->job_application_status_id;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $counter ?></td>
                                        <td style="width: 3%;">
                                            <?php
                                            $profilepic = common\models\UserProfile::findOne($current_user->user_id);
                                            if (isset($current_user->profile) && strlen($current_user->profile) > 2) {
                                                ?>
                                                <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/<?php echo $profilepic->profile; ?>);"></div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/noimage.png);"></div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?= Yii::$app->link->frontendUrl('/site/seeker-profile?idOtherProfile=' . $candidate->user_id) ?>">
                                                <div class="pxp-company-dashboard-job-title"><?= $current_user->firstname . ' ' . $current_user->lastname; ?></div>
                                                <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span><?= isset($user_address) ? SDistrict::findOne($user_address->district_id)->district : ''; ?></div>
                                            </a>
                                        </td>
                                        <td><div class="pxp-company-dashboard-job-category"><?= isset($current_job->jobtitle) ? $current_job->jobtitle : ''; ?></div></td>
                                        <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-<?= isset($job_application_status->label) ? $job_application_status->label : 'secondary'; ?>"><?= isset($job_application_status->status) ? $job_application_status->status : 'Waiting'; ?></span></div></td>
                                        <td><div class="col-auto">
                                                <form id="sort_by" action="/jobportal/service/service-job" method="GET">                            
                                                    <select class="form-select" id="sort" name="sort" onchange="confirm_status_change(<?= $candidate->id; ?>, this.value);" <?= ($current_job->recruitment_stage != ServiceJob::JOB_RECRUITMENT_STAGE_CLOSED) ? '' : 'disabled title="Recruitment closed"' ?>>

                                                        <?php
                                                        if (intval($candidate->placement_status_id) == 0) {
                                                            ?>
                                                            <option value="">Pending</option>
                                                            <?php
                                                        }
                                                        if (count($placement_statuses) > 0) {
                                                            $placement_status = \common\models\JobApplicationStatus::find()->where(['id' => $candidate->placement_status_id])->one();
                                                            $job_placement_status = null;
                                                            if (isset($placement_status)) {
                                                                $job_placement_status = backend\models\SStatus::findOne($placement_status->status_id);
                                                            }
                                                            foreach ($placement_statuses as $status) {
                                                                ?>
                                                                <option value="<?= $status->pk_status ?>" <?= (isset($job_placement_status) && $job_placement_status->pk_status == $status->pk_status) ? ' selected' : '' ?>><?= $status->status ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </form>                        
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pxp-company-dashboard-job-date"><?= $candidate->application_date; ?></div>
                                        </td>
                                        <td>
                                            <div class="pxp-company-dashboard-job-location">Not set</div>
                                        </td>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <?php
                                    $counter++;
                                }
                            }
                            ?>

                        </tbody>
                    </table>

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
            <?php }
            ?>
            <?php $form = ActiveForm::begin(['id' => 'filter_job', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-job/placement')]); ?>
            <input type="hidden" id="selected_job_id" name="job" value="" />
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
<div class="modal fade pxp-user-modal" id="job-application_status-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-small">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Placement status</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['id' => 'change_status_form', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-job/change-placement-status')]); ?>
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
<script type="text/javascript">
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });

    function filter_job() {
        if (parseInt($('#job_id :selected').val()) > 0) {
            $('#selected_job_id').val($('#job_id :selected').val());
            $("#filter_job").submit();
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
    function confirm_notification_send() {
        if (confirm("Are sure you want to send email notification to applicants?")) {
            return true;
        } else {
            return false;
        }
    }
    function confirm_job_close() {
        if (confirm("Are sure you want to complete this recruitment process?")) {
            return true;
        } else {
            return false;
        }
    }
    function confirm_status_change(application_id, placement_status_id) {
        $("#job_application_id").val(application_id);
        $("#status_id").val(placement_status_id);
        $("#job-application_status-modal").modal('show');
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

