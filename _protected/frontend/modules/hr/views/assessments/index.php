<?php

use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\SOccupationGrouping;
use frontend\modules\hr\models\ApiSyncing;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
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
        <div class="row">
            <div class="col-sm-6">
                <h1>Assessments</h1>
                <p class="pxp-text-light">List of registered assessments.</p>
            </div>
            <div class="col-sm-6">
                <span style="float: right;">
                    <div class="row">
                        <?php
                        $label_color = "danger";
                        if (isset($assessement_synchronization)) {
                            $last_synchronisation_days = ceil((abs(strtotime(date("Y-m-d")) - strtotime($assessement_synchronization->sync_ended)) / (60 * 60 * 24)));
                            if ($last_synchronisation_days < 30) {
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
                                <span style="color: #fff; font-weight: bold"><?= (isset($assessement_synchronization)) ? date("M d, Y h:i:s A", strtotime($assessement_synchronization->sync_ended)) : 'Never synchronized...'; ?></span>
                            </div>
                        </div>
                        <div class=" card bg-success text-white col-sm-3">
                            <div class="card-body">
                                <span href="#" <?= !ApiSyncing::iSSyncing(ApiSyncing::OBJECT_NAME_ASSESSMENT) ? 'onclick="sync_assessment();" title="Click to synchronize"' : ' title="Synchronization in progress"' ?>  style="<?= ApiSyncing::iSSyncing(ApiSyncing::OBJECT_NAME_ASSESSMENT) ? 'cursor: no-drop;' : 'cursor: pointer;' ?>">
                                    <i class="fa fa-refresh <?= ApiSyncing::iSSyncing(ApiSyncing::OBJECT_NAME_ASSESSMENT) ? 'fa-spin' : '' ?>" id="sync_ass" style="font-size:44px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </span>

            </div>
        </div>

        <div class="mt-4">
            <div class="row justify-content-between align-content-center">

                <div class="col-auto order-2 order-sm-1">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary <?= ($status == 'active') ? 'active' : '' ?>">
                            <input type="radio" name="options" id="active" autocomplete="off" onchange="return filter_selected('active');" <?= ($status == 'active') ? 'checked' : '' ?>> Active
                        </label>
                        <label class="btn btn-secondary <?= ($status == 'new') ? 'active' : '' ?>">
                            <input type="radio" name="options" id="new" autocomplete="off" onchange="return filter_selected('new');" <?= ($status == 'new') ? 'checked' : '' ?>> New
                        </label>
                        <label class="btn btn-secondary <?= ($status == 'archived') ? 'active' : '' ?>">
                            <input type="radio" name="options" id="archived" autocomplete="off" onchange="return filter_selected('archived');" <?= ($status == 'archived') ? 'checked' : '' ?>> Archived
                        </label>
                    </div>
                </div>
                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $assessment_count; ?> registered assessments</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_assessment_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/hr/assessments/list')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="title" class="form-control" placeholder="Search assessment...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($assessments) > 0) { ?>
                <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['id' => 'job_list', 'action' => Yii::$app->link->frontendUrl('/service/service-job/update-status')]); ?>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 3%;">#</th>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 10%;">Total candidates</th>
                                <th style="width: 10%;">Invited</th>
                                <th style="width: 10%;">Started</th>
                                <th style="width: 10%;">Finished</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 15%;">Last activity</th>
                                <th style="width: 12%;">Date created</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $counter = 1;
                            foreach ($assessments as $assessment) {
                                ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td>
                                        <a href="<?= Yii::$app->link->frontendUrl('/hr/assessments/view?id=' . $assessment->id) ?>">
                                            <div class="pxp-company-dashboard-job-title"><?= $assessment->name; ?></div>
                                        </a>
                                    </td>
                                    <td><?= $assessment->candidates ?></td>
                                    <td><?= $assessment->invited ?></td>
                                    <td><?= $assessment->started ?></td>
                                    <td><?= $assessment->finished . '(' . $assessment->finished_percentage . '%)' ?></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-status">
                                            <?php
                                            if ($assessment->status == "active") {
                                                ?>
                                                <span class="badge rounded-pill bg-success"><?= $assessment->status; ?></span>
                                                <?php
                                            } else if ($assessment->status == "new") {
                                                ?>
                                                <span class="badge rounded-pill bg-primary"><?= $assessment->status; ?></span>
                                                <?php
                                            } else if ($assessment->status == "archived") {
                                                ?>
                                                <span class="badge rounded-pill bg-primary"><?= $assessment->status; ?></span>
                                                <?php
                                            } else {
                                                //Nothing
                                            }
                                            ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date mt-1"><?= date_format(date_create($assessment->modified), "M d, Y H:m:s"); ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date mt-1"><?= date_format(date_create($assessment->created), "M d, Y H:m:s"); ?></div>
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
    function sync_assessment() {
        $("#sync_ass").addClass("fa-spin");
        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/hr/assessments/sync-asssessments') ?>',
            type: 'post',
            data: {
                id: 'none'
            },
            dataType: 'json',
            success: function (data) {
                alert("Assessment job synchronization started. You may reflesh the page to check the updates");
            }
        });
    }
    function filter_selected(status) {
        window.location.href = '<?= Yii::$app->link->frontendUrl('/hr/assessments/list'); ?>' + '?status=' + status;


    }
</script>

