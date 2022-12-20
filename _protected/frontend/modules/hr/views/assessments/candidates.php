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
                <h1>My candidates</h1>
                <p class="pxp-text-light">List of candidates invited to assessments.</p>
            </div>
        </div>

        <div class="mt-4">
            <div class="row justify-content-between align-content-center">
                <div class="col-auto order-2 order-sm-1" style="max-width: 500px;">
                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                        <select class="form-select" id="assessment_id">
                            <option value="">Select assessment</option>
                            <?php
                            if (count($assessments) > 0) {
                                foreach ($assessments as $assessment) {
                                    ?>
                                    <option value="<?= $assessment->id ?>" <?= ($selected_assessment == $assessment->id) ? 'selected' : '' ?>><?= $assessment->name; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <button class="btn ms-2" onclick="filter_candidates();">Filter</button>
                    </div>
                </div>

                <div class="col-auto order-1 order-sm-2" style="float: right;">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $assessment_count; ?> Candidates</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_candidate_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/hr/assessments/candidates')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="candidate" class="form-control" placeholder="Search candidate...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($candidates) > 0) { ?>
                <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['id' => 'job_list', 'action' => Yii::$app->link->frontendUrl('/service/service-job/update-status')]); ?>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 3%;">#</th>
                                <th style="width: 20%;">Names</th>
                                <th style="width: 10%;">Email</th>
                                <th style="width: 10%;">Total assessments</th>
                                <th style="width: 10%;">Total tests</th>
                                <th style="width: 10%;">Last activity</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $counter = 1;
                            foreach ($candidates as $candidate) {
                                $canditate_user = \common\models\UserProfile::find()->where(['user_id' => $candidate->user_id])->one();
                                if(isset($selected_assessment)){
                                    $candidate_assessments = frontend\modules\hr\models\ApiAssessmentCandidate::find()->where(['user_id' => $canditate_user->user_id])->andWhere(['assessment_id' => $selected_assessment])->all();
                                }else{
                                    $candidate_assessments = frontend\modules\hr\models\ApiAssessmentCandidate::find()->where(['user_id' => $canditate_user->user_id])->all();
                                }
                                $candidate_assessment_ids = array();
                                $assessment_list = "";
                                if (count($candidate_assessments) > 0) {
                                    $assessment_counter = 0;
                                    foreach ($candidate_assessments as $assessment) {
                                        array_push($candidate_assessment_ids, $assessment->assessment_id);
                                        $assessment_item = \frontend\modules\hr\models\ApiAssessments::find()->where(['id'=>$assessment->assessment_id])->one();
                                        if($assessment_counter==0){
                                            $assessment_list .= $assessment_item->name;
                                        }else{
                                            $assessment_list .= ', '.$assessment_item->name;
                                        }
                                        $assessment_counter++;
                                    }
                                }
                                $candidate_assessments_tests = frontend\modules\hr\models\ApiAssessments::getAssessmentTest($candidate_assessment_ids);
                                $test_list = "";
                                if(count($candidate_assessments_tests)>0){
                                    $test_counter = 0;
                                    foreach ($candidate_assessments_tests as $test){
                                        if($test_counter==0){
                                            $test_list .= $test;
                                        }else{
                                            $test_list .= ', '.$test;
                                        }
                                        $test_counter++;
                                    }
                                }
                                ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td>
                                        <a href="<?= Yii::$app->link->frontendUrl('/hr/assessments/assessment-candidate?id=' . $candidate->assessment_id . '&tt_id=' . $candidate->testtaker_id) ?>">
                                            <div class="pxp-company-dashboard-job-title"><?= $canditate_user->firstname . ' ' . $canditate_user->lastname; ?></div>
                                        </a>
                                    </td>
                                    <td><?= $candidate->email ?></td>
                                    <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= $assessment_list ?>"><?= count($candidate_assessments) ?></a></td>
                                    <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= $test_list ?>"><?= count($candidate_assessments_tests); ?></a></td>

                                    <td>
                                        <div class="pxp-company-dashboard-job-date mt-1"><?= date_format(date_create($candidate->last_activity), "M d, Y H:m:s"); ?></div>
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
            <?php $form = ActiveForm::begin(['id' => 'filter_assessment', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/hr/assessments/candidates')]); ?>
            <input type="hidden" id="selected_assessment_id" name="ass_id" value="" />
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });

    function filter_candidates() {
            $('#selected_assessment_id').val($('#assessment_id :selected').val());
            $("#filter_assessment").submit();
        

    }
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

