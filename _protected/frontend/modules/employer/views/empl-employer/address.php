<?php

use common\models\EmplAddress;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
    <div class="col-sm-12">

        <div id="address" class="content-list content-menu responsive">
            <table class='table table-bordered table-striped'>
                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                    <tr>
                        <td colspan="5" style="text-align: left;">
                            <?php
                            $addressModel = new EmplAddress();
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $addressModel,
                                            "Add Address",
                                            "green",
                                            "plus",
                                            "/empl-address/_form",
                                            "/employer/empl-address/create",
                                            "Create address"
                            );
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Employer</th>
                    <th>Phone Number</th>
                    <th>Website</th>
                    <th>Physical Address</th>
                    <th>Action</th>
                </tr>
                <?php
                $addresses = $employer->emplAddresss;
                foreach ($addresses as $address) {
                    ?>
                    <tr>
                        <td><?= $address->email_address ?></td>
                        <td><?= $address->phone_number ?></td>
                        <td><?= $address->website ?></td>
                        <td><?= $address->physical_address ?></td>
                        <td>
                            <div class="pxp-dashboard-table-options">

                                <a href="#"">
                                    <?php
                                    $addressModel = EmplAddress::find()->where(['id' => $address->id])->one();
                                    Yii::$app->jobPortalModal->popup($addressModel, "Update Address", "blue", "fa-eye", "/empl-address/view");
                                    ?>

                                </a>
                                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                                    <a href="#">
                                        <?php
                                        $addressModel = EmplAddress::find()->where(['id' => $address->id])->one();
                                        Yii::$app->jobPortalModal
                                                ->popup(
                                                        $addressModel,
                                                        "address",
                                                        "green",
                                                        "fa-pencil",
                                                        "/empl-address/_form",
                                                        '/employer/empl-address/update?id=' . $addressModel->id
                                        );
                                        ?>

                                    </a>
                                    <a href="#" class="" onClick='remove(<?= $address->id ?>, "empl-address", "address")'>
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
    function hideAndShowAddress() {

        let column = "show_address";
        let variable = $("#input_address").val();
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

        if ($("#label_address").html() == 'Show') {
            $("#label_address").html('Hide');
        } else {
            $("#label_address").html('Show');
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