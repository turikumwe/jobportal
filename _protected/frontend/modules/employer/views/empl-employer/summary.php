<?php

use common\models\EmplSummary;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
    <div class="col-sm-12">
        <div id="summary" class="content-list content-menu responsive">

            <table class='table table-striped'>
                <?php if (!isset($_GET['idOtherProfile']) && EmplSummary::find()->where(['employer_id' => Yii::$app->user->id, 'deleted_by' => 0])->count() == 0) { ?>
                    <tr>
                        <td colspan="5" style="text-align: left">
                            <?php
                            $summaryModel = new EmplSummary();
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $summaryModel,
                                            "Add Summary",
                                            "green",
                                            "plus",
                                            "/empl-summary/_form",
                                            "/employer/empl-summary/create",
                                            "Add"
                            );
                            ?>
                        </td>
                    </tr>
                <?php } ?>

                <?php
                $summaries = $employer->emplSummary;
                foreach ($summaries as $summary) {
                    ?>
                    <tr>
                        <td colspan="2" class="pull-right">
                            <div class="pxp-dashboard-table-options">
                                <a href="#">
                                    <?php
                                    $summaryModel = EmplSummary::find()->where(['id' => $summary->id])->one();
                                    Yii::$app->jobPortalModal->popup($summaryModel, "View employer Summary", "blue", "fa-eye", "/empl-summary/view");
                                    ?>
                                </a>
                                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                                    <a href="#">
                                        <?php
                                        $addressModel = EmplSummary::find()->where(['id' => $summary->id])->one();
                                        Yii::$app->jobPortalModal
                                                ->popup(
                                                        $summaryModel,
                                                        "summary",
                                                        "green",
                                                        "fa-pencil",
                                                        "/empl-summary/_form",
                                                        '/employer/empl-summary/update?id=' . $summaryModel->id
                                        );
                                        ?>
                                    </a>
                                    <!-- delete to be added -->
                                    <a href="#" onClick='remove(<?= $summary->id ?>, "empl-summary", "summary")'>
                                        <button title="Delete" class="action-button"><span class="fa fa-trash-o"></span></button>
                                    </a>
                                <?php } ?>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Professional profile</h3>
                            <?= $summary->professional_profile ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Specialty</h3>
                            <?= $summary->specialty; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<script>
    function hideAndShowSummary() {

        let column = "show_employer_summary";
        let variable = $("#input_summary").val();
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

        if ($("#label_summary").html() == 'Show') {
            $("#label_summary").html('Hide');
        } else {
            $("#label_summary").html('Show');
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