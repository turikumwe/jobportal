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
        <h1>Serviced job seekers summary</h1>
        <p class="pxp-text-light">Summary list of serviced job seekers.</p>

        <div class="mt-4">
            <div class="row justify-content-between align-content-center">

                <div class="col-auto order-2 order-sm-1">
                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">

                        <div class="form-group field-servicejob-posting_date required">
                            <label class="control-label" for="servicejob-posting_date">From date</label>
                            <input type="date" id="from_date_input" class="form-control" name="from" aria-required="true" value="<?= $from ?>">
                        </div>&nbsp;&nbsp;&nbsp;
                        <div class="form-group field-servicejob-posting_date required">
                            <label class="control-label" for="servicejob-posting_date">To date</label>
                            <input type="date" id="to_date_input" class="form-control" name="to" aria-required="true" value="<?= $to ?>">
                        </div>
                        <div class="form-group field-servicejob-posting_date required">
                            <button class="btn ms-2" onclick="return filter_by_date();" style="margin-top: 20px;">Filter</button>
                        </div>
                        <?php $form = ActiveForm::begin(['id' => 'search_by_date', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/mediator-service/serviced-summary')]); ?>
                        <input type="hidden" id="from_date" name="from" />
                        <input type="hidden" id="to_date" name="to" />
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>

            </div>
            <?php if (count($service_summary) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 25%;">#</th>
                                <th style="width: 25%;">Service name</th>
                                <th style="width: 25%;">Male</th>
                                <th style="width: 20%;">Female</th>
                                <th style="width: 15%;">Disabled</th>
                            </tr>
                        </thead>
                        <tbody id="TableItems">
                            <?php
                            $counter = 1;
                            $male_count = 0;
                            $female_count = 0;
                            $disabled_count = 0;
                            foreach ($service_summary as $row) {
                                $male_count += isset($row['Male']) ? $row['Male'] : 0;
                                $female_count += isset($row['Female']) ? $row['Female'] : 0;
                                $disabled_count += isset($row['Disabled']) ? $row['Disabled'] : 0;
                                ?>
                                <tr>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $counter; ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $row['service_name']; ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><a href="<?= Yii::$app->link->frontendUrl('/service/mediator-service/serviced-details?s=' . $row['service_id'].'&g=1&fo='.$from.'&to='.$to) ?>"><?= isset($row['Male']) ? $row['Male'] : 0; ?></a></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><a href="<?= Yii::$app->link->frontendUrl('/service/mediator-service/serviced-details?s=' . $row['service_id'].'&g=2&fo='.$from.'&to='.$to) ?>"><?= isset($row['Female']) ? $row['Female'] : 0; ?></a></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><a href="<?= Yii::$app->link->frontendUrl('/service/mediator-service/serviced-details-d?s=' . $row['service_id'].'&fo='.$from.'&to='.$to) ?>"><?= isset($row['Disabled']) ? $row['Disabled'] : 0; ?></a></div>
                                    </td>

                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>

                        </tbody>
                        <tfoot id="TableItems">
                            <tr>
                                <td colspan="2" style="font-weight: bold; font-size: 20px;">
                                    <div class="pxp-company-dashboard-job-date">Total</div>
                                </td>
                                <td style="font-weight: bold; font-size: 20px;">
                                    <div class="pxp-company-dashboard-job-date"><a href="<?= Yii::$app->link->frontendUrl('/service/mediator-service/serviced-details?g=1&fo='.$from.'&to='.$to) ?>"><?= $male_count; ?></a></div>
                                </td>
                                <td style="font-weight: bold; font-size: 20px;">
                                    <div class="pxp-company-dashboard-job-date"><a href="<?= Yii::$app->link->frontendUrl('/service/mediator-service/serviced-details?g=2&fo='.$from.'&to='.$to) ?>"><?= $female_count; ?></a></div>
                                </td>
                                <td style="font-weight: bold; font-size: 20px;">
                                    <div class="pxp-company-dashboard-job-date"><a href="<?= Yii::$app->link->frontendUrl('/service/mediator-service/serviced-details-d?fo='.$from.'&to='.$to) ?>"><?= $disabled_count; ?></a></div>
                                </td>

                            </tr>

                        </tfoot>
                    </table>
                </div>
            <?php } else {
                ?>
            <h2>No records</h2>
            <?php 
            } ?>
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