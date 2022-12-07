<?php

use common\models\EmplStatus;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$statusModel = new EmplStatus();
?>
<div class="row profile">
    <div class="col-sm-12">
        <div id="status" class="content-list content-menu responsive">
            <table class='table table-bordered table-striped'>
                <?php if (!isset($_GET['idOtherProfile']) && EmplStatus::find()->where(['employer_id' => Yii::$app->user->id, 'deleted_by' => 0])->count() == 0) { ?>
                    <tr>
                        <td colspan="5" style="text-align: left;">
                            <?php
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $statusModel,
                                            "Add status",
                                            "green",
                                            "plus",
                                            "/empl-status/_form",
                                            "/employer/empl-status/create",
                                            "Add"
                            );
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th><?= $statusModel->getAttributeLabel('employer_id') ?></th>
                    <th><?= $statusModel->getAttributeLabel('employer_status_id') ?></th>
                    <th><?= $statusModel->getAttributeLabel('status_effective_date') ?></th>
                    <th>Action</th>
                </tr>
                <?php
                $statuses = $employer->emplStatus;
                foreach ($statuses as $status) {
                    ?>
                    <tr>
                        <td><?= isset($status->employer->company_name) ? $status->employer->company_name : '-' ?></td>
                        <td><?= $status->employerStatus->status ?></td>
                        <td><?= $status->status_effective_date ?></td>
                        <td>
                            <div class="pxp-dashboard-table-options">
                                <a href="#">
                                    <?php
                                    $statusModel = EmplStatus::find()->where(['id' => $status->id])->one();
                                    Yii::$app->jobPortalModal->popup($statusModel, "View Employer status", "blue", "fa-eye", "/empl-status/view");
                                    ?>
                                </a>
                                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                                    <a href="#">
                                        <?php
                                        $statusModel = EmplStatus::find()->where(['id' => $status->id])->one();
                                        Yii::$app->jobPortalModal
                                                ->popup(
                                                        $statusModel,
                                                        "status",
                                                        "green",
                                                        "fa-pencil",
                                                        "/empl-status/_form",
                                                        '/employer/empl-status/update?id=' . $statusModel->id
                                        );
                                        ?>

                                    </a>
                                    <a href="#" onClick='remove(<?= $status->id ?>, "empl-status", "status")'>
                                        <button title="Delete" class="action-button"><span class="fa fa-trash-o"></span></button>
                                    </a>
                                <?php } ?>
                            </div>

                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<script>
    function hideAndShowStatus() {

        let column = "show_employer_status";
        let variable = $("#input_status").val();
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

        if ($("#label_status").html() == 'Show') {
            $("#label_status").html('Hide');
        } else {
            $("#label_status").html('Show');
        }

        $.ajax({
            type: "POST",
            url: FRONTEND_BASE_URL + "/employer/empl-employer/hide-and-show?variable=" + variable + "&column=" + column,
            dataType: "json",
            success: function (data) {

            }
        });

    }
</script>