<?php

use common\models\MdAddress;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
    <div class="col-sm-12">
        <div id="address" class="content-list content-menu responsive">
            <table class='table table-hover align-middle'>

                <tr>
                    <th>mediator</th>
                    <th>Phone Number</th>
                    <th>Physical Address</th
                </tr>
                <?php
                $addresses = $mediator->mdAddresses;
                foreach ($addresses as $address) {
                    ?>
                    <tr>
                        <td><?= $address->email_address ?></td>
                        <td><?= $address->phone_number ?></td>
                        <td><?= $address->physical_address ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>