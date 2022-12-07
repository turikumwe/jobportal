<?php

use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\SOccupationGrouping;

;

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
        <h1>Manage Jobs</h1>
        <p class="pxp-text-light">Detailed list with all your Organization job offers.</p>
        <div class="mt-4">
            <div class="row justify-content-between align-content-center">
                <div class="col-auto order-2 order-sm-1">
                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                        <select class="form-select" id="status">
                            <option>Bulk actions</option>
                            <option value="1">Publish</option>
                            <option value="2">Unpublish</option>
                        </select>
                        <button class="btn ms-2" onclick="return change_status();">Apply</button>&nbsp;&nbsp;&nbsp;
                        <select class="form-select" id="opportunity_type" name="type">
                            <option>Opportunity Type</option>
                            <?php
                            if (count($opportinities) > 0) {
                                foreach ($opportinities as $opportunity) {
                                    ?>
                                    <option value="<?= $opportunity['id'] ?>" <?php
                                    if ($selected_type == $opportunity['id']) {
                                        echo 'selected';
                                    }
                                    ?>><?= $opportunity['name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                        </select>
                        <button class="btn ms-2" onclick="return filter_by_opportunity();">Filter</button>
                    </div>
                </div>
                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $jobs_count; ?> jobs</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_job_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-job/my-jobs')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="title" class="form-control" placeholder="Search jobs...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($jobs) > 0) { ?>
                <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['id' => 'job_list', 'action' => Yii::$app->link->frontendUrl('/service/service-job/update-status')]); ?>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="pxp-is-checkbox" style="width: 1%;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th style="width: 25%;">Job</th>
                                <th style="width: 20%;">Category</th>
                                <th style="width: 12%;">Type</th>
                                <th style="width: 15%;">Applications</th>
                                <th style="width: 15%;">Required skills</th>
                                <th style="width: 15%;">Required tests</th>
                                <th>Application deadline<span class="fa fa-angle-up ms-3"></span></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $counter = 1;
                            foreach ($jobs as $key => $job) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input checkboxAll" name="selected_jobs[]" value="<?= $job->id; ?>" class="job_selection"></td>
                                    <td>
                                        <a href="<?= Yii::$app->link->frontendUrl('/service/service-job/view?id=' . $job->id) ?>">
                                            <div class="pxp-company-dashboard-job-title"><?= $job->jobtitle; ?></div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span><?= isset($job->districts->district) ? $job->districts->district : '-' ?></div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category"><?= isset($job->occupation_grouping_id) ? SOccupationGrouping::findOne($job->occupation_grouping_id)->occupation_grouping : '' ?></div></td>
                                    <td><div class="pxp-company-dashboard-job-type">
                                            <?php
                                            $jobtype = backend\models\SJobType::findOne($job->job_type_id);
                                            if (!empty($jobtype)) {
                                                echo $jobtype['job_type'];
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>

                                        </div>
                                    </td>
                                    <td><a href="<?= Yii::$app->link->frontendUrl('/service/service-job/job-applicant?job=' . $job->id) ?>" class="pxp-company-dashboard-job-applications"><?= Yii::$app->jobSeeker->numberOfApplicants($job->id) ?> Candidates</a></td>
                                    <td><div class="pxp-company-dashboard-job-category"><?php
                                            $job_skills = backend\models\JobSkills::findByJobId($job->id);
                                            $total_skills = count($job_skills);
                                            $counter = 1;
                                            $skill_set = '';
                                            if ($total_skills > 0) {
                                                foreach ($job_skills as $skill) {
                                                    $skill = backend\models\SSkill::findOne($skill['skill_id']);
                                                    if ($counter < $total_skills) {
                                                        $skill_set .= $counter . '. ' . $skill['skill'] . '<br />';
                                                    } else {
                                                        $skill_set .= $counter . '. ' . $skill['skill'];
                                                    }
                                                    $counter++;
                                                }
                                            }
                                            echo $skill_set;
                                            ?></div></td>
                                    <td><div class="pxp-company-dashboard-job-category">Not set</div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-status">
                                            <?php
                                            $job_action = backend\models\SActions::findOne($job->action_id);

                                            if ($job->action_id == 1) {
                                                ?>
                                                <span class="badge rounded-pill bg-success"><?= $job_action['action']; ?></span>
                                                <?php
                                            } else if ($job->action_id == 2) {
                                                ?>
                                                <span class="badge rounded-pill bg-secondary"><?= $job_action['action']; ?></span>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                        <div class="pxp-company-dashboard-job-date mt-1"><?= date_format(date_create($job->closure_date), "M d, Y"); ?></div>
                                        <?php
                                        if ($job->action_id == \common\models\ServiceJob::JOB_STATUS_PUBLISHED && (new DateTime() < new DateTime($job->closure_date))) {
                                            ?>
                                            <div class="pxp-company-dashboard-job-status" type="button">
                                                <span data-bs-toggle="modal" href="#deadline-modal" class="badge rounded-pill bg-success" onclick="extent_deadline(<?= $job->id ?>);">Extend deadline</span>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled ">
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/service/service-job/view?id=' . $job->id) ?>"><button title="Preview" type="button" class="action-button"><span class="fa fa-eye"></span></button></a></li>
                                                <?php if ($job->recruitment_stage != \common\models\ServiceJob::JOB_RECRUITMENT_STAGE_CLOSED) { ?>
                                                    <li><a href="<?= Yii::$app->link->frontendUrl('/service/service-job/update-opportunity?id=' . $job->id) ?>"><button title="Edit" type="button" class="action-button"><span class="fa fa-pencil"></span></button></a></li>
                                                    <li><a href="<?= Yii::$app->link->frontendUrl('/service/service-job/delete?id=' . $job->id) ?>" onclick="return confirm_delete();"><button title="Delete" type="button" class="action-button-danger"><span class="fa fa-trash-o"></span></button></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>


                        </tbody>
                    </table>
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
<div class="modal fade pxp-user-modal" id="deadline-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-small">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Extend application deadline</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="col-md-6">
                        <?php $form = ActiveForm::begin(['id' => 'extend_deadline', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-job/extend-deadline')]); ?>
                        <div class="mb-3">
                            <div class="form-group field-servicejob-closure_date required">
                                <label class="control-label" for="closure_date">Application Deadline</label>
                                <input type="date" id="servicejob-closure_date" class="form-control" name="closure_date" aria-required="true">

                                <input type="hidden" name="job_id" id="job_id_to_extend" value="" />
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" onclick="return confirm_extention();">Extend deadline</button>                
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });
    function change_status() {
        var total_checked = $("input[type='checkbox']:checked").length;

        if (parseInt($('#status :selected').val()) && total_checked > 0) {
            if (confirm("Are sure you want to change the Job Status?")) {
                $('#selected_status').val($('#status :selected').val());
                $("#job_list").submit();
            }

        } else {
            alert("Please make valid selections")
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

