<?php

use common\models\EmplManagers;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$managerModel = new EmplManagers();
?>
<div class="row profile">
    <div class="col-sm-12">
        <div id="manager" class="content-list content-menu responsive">
            <table class='table table-bordered table-striped'>
                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                    <tr>
                        <td colspan="5" style="text-align: left;">
                            <?php
                            $managerModel = new EmplManagers();
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $managerModel,
                                            "Add manager",
                                            "green",
                                            "plus",
                                            "/empl-managers/_form",
                                            "/employer/empl-managers/create",
                                            "Add"
                            );
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th><?= $managerModel->getAttributeLabel('person_id') ?></th>
                    <th><?= $managerModel->getAttributeLabel('start_date') ?></th>
                    <th><?= $managerModel->getAttributeLabel('end_date') ?></th>
                    <th>Action</th>
                </tr>
                <?php
                $manageres = $employer->emplManager;
                foreach ($manageres as $manager) {
                    ?>
                    <tr>
                        <td><?= $manager->person->fullName ?></td>
                        <td><?= $manager->start_date ?></td>
                        <td><?= $manager->end_date ?></td>
                        <td>
                            <div class="pxp-dashboard-table-options">
                                <a href="#">
                                    <?php
                                    $managerModel = EmplManagers::find()->where(['id' => $manager->id])->one();
                                    Yii::$app->jobPortalModal->popup($managerModel, "Update manager", "blue", "fa-eye", "/empl-managers/view");
                                    ?>

                                </a>
                                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                                    <a href="#">
                                        <?php
                                        $managerModel = EmplManagers::find()->where(['id' => $manager->id])->one();
                                        Yii::$app->jobPortalModal
                                                ->popup(
                                                        $managerModel,
                                                        "manager",
                                                        "green",
                                                        "fa-pencil",
                                                        "/empl-managers/_form",
                                                        '/employer/empl-managers/update?id=' . $managerModel->id
                                        );
                                        ?>

                                    </a>
                                    <a href="#" onClick='remove(<?= $manager->id ?>, "empl-managers", "manager")'>
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
    function hideAndShowmanager() {

        let column = "show_manager";
        let variable = $("#input_manager").val();
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

        if ($("#label_manager").html() == 'Show') {
            $("#label_manager").html('Hide');
        } else {
            $("#label_manager").html('Show');
        }

        $.ajax({
            type: "POST",
            url: FRONTEND_BASE_URL + "/employer/empl-employers/hide-and-show?variable=" + variable + "&column=" + column,
            dataType: "json",
            success: function (data) {

            }
        });

    }
</script>