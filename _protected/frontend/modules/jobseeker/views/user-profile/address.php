<?php

use common\models\JsAddress;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>

<div class="row profile">
    <div  class="col-sm-12">


        <div id="address" class="content-list content-menu responsive">
            <table class='table table-bordered table-striped'>
                <?php if (!isset($_GET['js'])) { ?>
                    <tr>
                        <td colspan="6" style="text-align: left;" >
                            <?php
                            $addressModel = new JsAddress();
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $addressModel,
                                            "Add Address",
                                            "green",
                                            "plus",
                                            "/js-address/_form",
                                            "/jobseeker/js-address/create",
                                            "Add"
                            );
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Province</th>
                    <th>District</th>
                    <th>Sector</th>
                    <th>Action</th>
                </tr>
                <?php
                $addresses = $jobseeker->jsAddresses;
                foreach ($addresses as $address) {
                    ?>
                    <tr>
                        <td><?= isset($address->district->province->province) ? $address->district->province->province : '-' ?></td>
                        <td><?= isset($address->district->district) ? $address->district->district : '-' ?></td>
                        <td><?= isset($address->geosector->sector) ? $address->geosector->sector : '-' ?></td>
                        <td  class="pxp-dashboard-table-options">	
                            <a href="#">
                                <?php
                                $addressModel = JsAddress::find()->where(['id' => $address->id])->one();
                                Yii::$app->jobPortalModal->popup($addressModel, "View address", "blue", "fa fa-eye", "/js-address/_view");
                                ?>
                            </a>
                                <?php if (!isset($_GET['js'])) { ?>
                                <a href="#">
                                    <?php
                                    $addressModel = JsAddress::find()->where(['id' => $address->id])->one();
                                    Yii::$app->jobPortalModal
                                            ->popup(
                                                    $addressModel,
                                                    "address",
                                                    "green",
                                                    "fa fa-pencil",
                                                    "/js-address/_form",
                                                    '/jobseeker/js-address/update?id=' . $addressModel->id
                                    );
                                    ?>
                                </a>
                                <a href="#"      type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?'))
                                                                    window.location.href = 'removeitem?addresseid=<?= $addressModel->id ?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true"  ></button>
                                </a> 
    <?php } ?>
                        </td>
                    </tr> 
                    <?php }
                ?>
            </table>          

        </div>
    </div>
</div>
<script>
    function hideAndShowAddress() {

        let column = "show_contact";
        let variable = $("#input_address").val();
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

        $.ajax({
            type: "POST",
            url: FRONTEND_BASE_URL + "/jobseeker/user-profile/hide-and-show?variable=" + variable + "&column=" + column,
            dataType: "json",
            success: function (data) {

            }
        });

    }
</script>