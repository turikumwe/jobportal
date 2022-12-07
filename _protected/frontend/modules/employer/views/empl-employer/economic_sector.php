<?php

use common\models\EmplEconomicSector;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$economicsectorModel = new EmplEconomicSector();
?>
<div class="row profile">
    <div class="col-sm-12">
        <div id="economic_sector" class="content-list content-menu responsive">
            <table class='table table-bordered table-striped'>
                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                    <tr>
                        <td colspan="5" style="text-align: left;">
                            <?php
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $economicsectorModel,
                                            "Add economic sector",
                                            "green",
                                            "plus",
                                            "/empl-economic-sector/_form",
                                            "/employer/empl-economic-sector/create",
                                            "Add"
                            );
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                        <!-- <th> -->
                    <?php //echo $economicsectorModel->getAttributeLabel('employer_id')
                    ?>
                    <!-- </th> -->
                    <th><?= $economicsectorModel->getAttributeLabel('economic_sector_id') ?></th>
                    <th><?= $economicsectorModel->getAttributeLabel('main_economic_sector_id') ?></th>
                    <th><?= $economicsectorModel->getAttributeLabel('start_date') ?></th>
                </tr>
                <?php
                $economic_sectors = $employer->emplEconomicSector;
                foreach ($economic_sectors as $economic_sector) {
                    ?>
                    <tr>
                            <!-- <td> -->
                        <?php //echo isset($economic_sector->employer->company_name) ? $economic_sector->employer->company_name : '-'
                        ?>
                        <!-- </td> -->
                        <td><?= isset($economic_sector->economicSector->ecosector) ? $economic_sector->economicSector->ecosector : '-' ?></td>
                        <td><?= isset($economic_sector->mainEconomicSector->sector) ? $economic_sector->mainEconomicSector->sector : '-' ?></td>
                        <td><?= isset($economic_sector->start_date) ? $economic_sector->start_date : '-' ?></td>
                        <td>
                            <div class="pxp-dashboard-table-options">
                                <a href="#">
                                    <?php
                                    $economic_sectorModel = EmplEconomicSector::find()->where(['id' => $economic_sector->id])->one();
                                    Yii::$app->jobPortalModal->popup($economic_sectorModel, "Update EconomicS ector", "blue", "fa-eye", "/empl-economic-sector/view");
                                    ?>

                                </a>
                                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                                    <a href="#">
                                        <?php
                                        $economic_sectorModel = EmplEconomicSector::find()->where(['id' => $economic_sector->id])->one();
                                        Yii::$app->jobPortalModal
                                                ->popup(
                                                        $economic_sectorModel,
                                                        "economic_sector",
                                                        "green",
                                                        "fa-pencil",
                                                        "/empl-economic-sector/_form",
                                                        '/employer/empl-economic-sector/update?id=' . $economic_sectorModel->id
                                        );
                                        ?>

                                    </a>
                                    <a href="#" onClick='remove(<?= $economic_sector->id ?>, "empl-economic-sector", "economic_sector")'>
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
    function hideAndShowEconomic() {

        let column = "show_economic_sector";
        let variable = $("#input_economic_sector").val();
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

        if ($("#label_economic_sector").html() == 'Show') {
            $("#label_economic_sector").html('Hide');
        } else {
            $("#label_economic_sector").html('Show');
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