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
        <div class="row">
            <div class="col-md-6">
                <h1>Manage trainings</h1>
                <span class="pxp-text-light">Detailed list with all your Organization trainings.</span>
            </div>
            <div class="col-md-6">
                <?php
                $employer = common\models\User::findOne(Yii::$app->user->identity->id);
                if (\common\models\User::isFromEmployer(Yii::$app->user->identity->id)) {
                    if ($employer->employerProfile->is_verified == 1) {
                        ?>
                        <span style="float: right;"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-event/post-opportunity'; ?>" class="btn rounded-pill pxp-nav-btn">Post new training</a></span>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-warning">
                            <strong>Employer not verified!</strong><br />
                            Your employer is not verified. The verification process is ongoing. you will be notified upon verification completion. You may contact RDB for your status check<br />
                            <strong>It is after the verification that you can be able to post events!</strong>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <span style="float: right;"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-event/post-opportunity'; ?>" class="btn rounded-pill pxp-nav-btn">Post new training</a></span>
                <?php } ?>
                
            </div>
        </div>

        <div class="mt-4">
            <div class="row justify-content-between align-content-center">
                <div class="col-auto order-2 order-sm-1">
                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                        <select class="form-select" id="status">
                            <option>Bulk actions</option>
                            <option value="1">Publish</option>
                            <option value="2">Unpublish</option>
                        </select>
                        <button class="btn ms-2" onclick="return change_status();">Apply</button>

                    </div>
                </div>
                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $events_count; ?> trainings</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_job_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-event/my-events')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="title" class="form-control" placeholder="Search trainings...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($opportunities) > 0) { ?>
                <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['id' => 'event_list', 'action' => Yii::$app->link->frontendUrl('/service/service-event/bulk-event-status')]); ?>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="pxp-is-checkbox" style="width: 1%;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th style="width: 25%;">Event title</th>
                                <th style="width: 15%;">Organizer</th>
                                <th style="width: 20%;">Venue</th>
                                <th style="width: 12%;">Start date</th>
                                <th style="width: 15%;">End date</th>
                                <th>Date<span class="fa fa-angle-up ms-3"></span></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $counter = 1;
                            foreach ($opportunities as $key => $event) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input checkboxAll" name="selected_events[]" value="<?= $event->id; ?>" class="job_selection"></td>
                                    <td>
                                        <a href="<?= Yii::$app->link->frontendUrl('/service/service-event/view?id=' . $event->id) ?>">
                                            <div class="pxp-company-dashboard-job-title"><?= $event->event_title; ?></div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>
                                                <?php
                                                $event_sector = \backend\models\SGeosector::findOne($event->location);
                                                if (isset($event_sector)) {
                                                    $sector_district = \backend\models\SDistrict::findOne($event_sector->district_id);
                                                    if (isset($sector_district)) {
                                                        echo $sector_district->district;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category"><?= $event->description_organiser; ?></div></td>
                                    <td><div class="pxp-company-dashboard-job-type">
                                            <?= $event->venue; ?>
                                        </div>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-date mt-1"><?= $event->start_date; ?></div></td>
                                    <td><div class="pxp-company-dashboard-job-date mt-1"><?= $event->closure_date; ?></div></td>

                                    <td>
                                        <div class="pxp-company-dashboard-job-status">
                                            <?php
                                            $job_action = backend\models\SActions::findOne($event->action_id);
                                            if ($event->action_id == 1) {
                                                ?>
                                                <span class="badge rounded-pill bg-success"><?= $job_action['action']; ?></span>
                                                <?php
                                            } else if ($event->action_id == 2) {
                                                ?>
                                                <span class="badge rounded-pill bg-secondary"><?= $job_action['action']; ?></span>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                        <div class="pxp-company-dashboard-job-date mt-1"><?= $event->updated_at; ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled ">
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/service/service-event/update-opportunity?id=' . $event->id) ?>"><button title="Edit" type="button" class="action-button"><span class="fa fa-pencil"></span></button></a></li>
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/service/service-event/view?id=' . $event->id) ?>"><button title="Preview" type="button" class="action-button"><span class="fa fa-eye"></span></button></a></li>
                                                <?php $form = ActiveForm::begin(['method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-event/my-events')]); ?>
                                                <input type="hidden" name="id" value="<?= $event->id ?>" />
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/service/service-event/delete?id=' . $event->id) ?>" onclick="return confirm_delete();"><button title="Delete" type="button" class="action-button-danger"><span class="fa fa-trash-o"></span></button></a></li>
                                                <?php ActiveForm::end(); ?>
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
<script type="text/javascript">
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });
    function change_status() {
        var total_checked = $("input[type='checkbox']:checked").length;

        if (parseInt($('#status :selected').val()) && total_checked > 0) {
            if (confirm("Are sure you want to change the event Status?")) {
                $('#selected_status').val($('#status :selected').val());
                $("#event_list").submit();
            }
        } else {
            alert("Please make valid selections")
        }

    }
    function filter_by_opportunity() {
        if (parseInt($('#opportunity_type :selected').val()) > 0) {
            window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-event/my-events'); ?>' + '?type=' + $('#opportunity_type :selected').val();
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

