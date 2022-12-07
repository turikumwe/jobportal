<div class='well profil'>
    <div class="row">
        <div class="col-sm-6">
            <div class="pull-left">
                <b><i class="glyphicon glyphicon-user"></i> Identification</b>
                <hr>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <?php if (!isset($_GET['idOtherProfile'])) { ?>
                    <div class='pull-right'><span class="fa fa-cog"></span><?php include('settings.php') ?></div>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover align-middle">

            <tbody>
                <tr>
                    <td><div class="pxp-company-dashboard-job-category">Registration Number:</div></td>
                    <td><div class="pxp-company-dashboard-job-category"><?= isset($mediator->registration_number) ? $mediator->registration_number : ''; ?></div></td>

                </tr>
                <tr>
                    <td><div class="pxp-company-dashboard-job-category">Mediator Name:</div></td>
                    <td><div class="pxp-company-dashboard-job-category"><?= isset($mediator->madiator_name) ? $mediator->madiator_name : '-'; ?></div></td>

                </tr>
                <tr>
                    <td><div class="pxp-company-dashboard-job-category">Opening Date:</div></td>
                    <td><div class="pxp-company-dashboard-job-category"><?= date('M d,Y', strtotime($mediator->opening_date)); ?></div></td>

                </tr>
                <tr>
                    <td><div class="pxp-company-dashboard-job-category">Mediator Type:</div></td>
                    <td><div class="pxp-company-dashboard-job-category"><?php
                            $mediator_type = backend\models\SMediatorType::findOne($mediator->mediator_type_id);
                            if (isset($mediator_type)) {
                                echo $mediator_type->mediator_type;
                            } else {
                                echo '-';
                            }
                            ?></div>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>

</div>