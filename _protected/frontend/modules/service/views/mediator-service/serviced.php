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
        <h1>Serviced job seekers</h1>
        <p class="pxp-text-light">Detailed list of candidates that serviced in the center.</p>

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
                        <?php $form = ActiveForm::begin(['id' => 'search_by_date', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/mediator-service/serviced')]); ?>
                        <input type="hidden" id="from_date" name="from" />
                        <input type="hidden" id="to_date" name="to" />
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>

                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $all_services_count; ?> reports</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'candidate', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/mediator-service/serviced')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="js" class="form-control" placeholder="Search jobseeker...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

            </div>
            <?php if (count($all_services) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="pxp-is-checkbox" style="width: 1%;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th style="width: 20%;">Mediator</th>
                                <th style="width: 15%;">Service name</th>
                                <th style="width: 15%;">Institution</th>
                                <th style="width: 25%;">Job seekers</th>
                                <th style="width: 10%;">Service date</th>
                                <th style="width: 5%;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody id="TableItems">
                            <?php
                            $counter = 1;
                            foreach ($all_services as $key => $serviced) {
                                $current_service = \common\models\SServices::findOne($serviced['service_id']);
                                $service_clients = \common\models\MediatorServiceClient::findByService($serviced['id']);
                                ?>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input checkboxAll" name="selected_application[]" value="<?= $serviced['id']; ?>"></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= isset($mediator->madiator_name) ? $mediator->madiator_name : '-'; ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $current_service['name'] ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $serviced['institution'] ?></div>
                                    </td>
                                    <td>
                                        <?php
                                        if (count($service_clients) > 0) {
                                            foreach ($service_clients as $key => $client) {
                                                $user_profile = common\models\UserProfile::findOne($client['user_id']);
                                                ?>
                                                <a href="#">
                                                    <div class="pxp-company-dashboard-job-title"><?= $user_profile['firstname'] . ' ' . $user_profile['lastname'] ?></div>
                                                </a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?= $serviced['service_date'] ?></div>
                                    </td>


                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled ">
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/service/mediator-service/update-service?id=' . $serviced['id']) ?>"><button title="Edit" type="button" class="action-button"><span class="fa fa-pencil"></span></button></a></li>
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/service/mediator-service/delete?id=' . $serviced['id']) ?>" onclick="return confirm_delete();"><button title="Delete" type="button" class="action-button-danger"><span class="fa fa-trash-o"></span></button></a></li>
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
                    <?php $form = ActiveForm::begin(['id' => 'bulk_delete', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/mediator-service/bulk-delete')]); ?>
                    <input type="hidden" id="selected_service" name="selected_service" value="" />
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