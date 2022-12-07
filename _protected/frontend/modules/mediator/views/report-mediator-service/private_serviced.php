<?php

use frontend\assets\FrontendAsset;
use backend\models\SDistrict;
use frontend\modules\jobseeker\models\search\JsAddressSearch;
use frontend\modules\service\models\search\ServiceJobSearch;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;

/* @var $this View */
/* @var $model UserProfile */
/* @var $form ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php") ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <h1>Reported service</h1>
        <p class="pxp-text-light">Summary report on services offered</p>

        <div class="mt-4">
            <div class="row justify-content-between align-content-center">
                <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                    <?php $form = ActiveForm::begin(['id' => 'search_by_date', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/mediator/report-mediator-service/private')]); ?>
                    <table>
                        <tr>
                            <td>
                                <select class="form-select" id="opportunity_type" name="mediator">
                                    <option value="0">Select mediator</option>
                                    <?php
                                    if (count($private_mediators) > 0) {
                                        foreach ($private_mediators as $mediator) {
                                            ?>
                                            <option value="<?= $mediator['id'] ?>" <?php
                                            if ($selected_mediator == $mediator['id']) {
                                                echo 'selected';
                                            }
                                            ?>><?= $mediator['madiator_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                </select>  
                            </td>
                            <td>
                                <button class="btn ms-2">Filter</button> 
                            </td>
                        </tr>
                    </table>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $all_services_count; ?> reports</div>
                    </div>
                </div>

            </div>
            <?php if (count($all_services) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="pxp-is-checkbox" style="width: 1%;">#</th>
                                <th style="width: 25%;">Mediator</th>
                                <th style="width: 20%;">Service name</th>
                                <th style="width: 20%;">Quarter</th>
                                <th>Male</th>
                                <th>Female</th>
                                <th>Disabled</th>
                            </tr>
                        </thead>
                        <tbody id="TableItems">
                            <?php
                            $counter = 1;
                            foreach ($all_services as $key => $serviced) {
                                $current_service = \common\models\SServices::findOne($serviced['id']);
                                $current_service_quarter = \common\models\ReportQuarter::findOne($serviced['quarter_id']);
                                ?>
                                <tr>
                                    <td><?= $counter; ?></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= isset($mediator->madiator_name) ? $mediator->madiator_name : '-'; ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $current_service['name'] ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $current_service_quarter['quarter_name'] . ' - ' . $current_service_quarter['quarter_year'] ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $serviced['male_count'] ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $serviced['female_count'] ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $serviced['disabled_count'] ?></div>
                                    </td>
                                </tr>
                                <?php
                                $counter++;
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
            <?php } ?>
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
<script type="text/javascript">
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });

    function bulk_delete() {
        var selected = new Array();
        $("#TableItems input[type=checkbox]:checked").each(function () {
            selected.push(this.value);
        });
        if (parseInt($('#status :selected').val()) && selected.length > 0) {

            if (confirm("Are sure you want to delete the selected? No undo")) {
                $('#selected_service').val(selected.join(","));
                $("#bulk_delete").submit();
            }

        } else {
            alert("Please make valid selections");
        }

    }
    function filter_by_date() {
        $('#from_date').val($('#from_date_input').val());
        $('#to_date').val($('#to_date_input').val());
        $("#search_by_date").submit();
    }

    function confirm_delete() {
        if (confirm("Are you sure want to delete this? No undo")) {
            return true;
        } else {
            return false;
        }

    }
</script>