<?php

use common\models\CommonPerson;
use common\models\MdMediator;
use common\models\User;
use common\models\UserProfile;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\CustomLinkPager;

/* @var $this View */
/* @var $model UserProfile */
/* @var $form ActiveForm */
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php") ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <h1>Employee users</h1>
        <p class="pxp-text-light">Detailed list of users in the institution.</p>

        <div class="mt-4">
            <div class="row justify-content-between align-content-center">
                <div class="col-auto order-2 order-sm-1">
                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">

                    </div>
                </div>
                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><span style="font-weight: bold;"><?= $mediator_employees_count ?></span> Users</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_job_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/mediator/md-mediator/mediator-users')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="name" class="form-control" placeholder="Search users...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($mediator_employees) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="pxp-is-checkbox" style="width: 1%;">#</th>
                                <th style="width: 25%;">Mediator</th>
                                <th style="width: 25%;">Names</th>
                                <th style="width: 10%;">Position</th>
                                <th>Phone</th>
                                <th >Email</th>
                                <th>Employment start Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="TableItems">
                            <?php
                            $gender = array(1 => 'Male', 2 => 'Female', '' => '');
                            $counter = 1;
                            foreach ($mediator_employees as $key => $employee) {
                                $current_user = User::findOne($employee->created_by);
                                ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td> 
                                        <?php
                                        $employee_mediator = MdMediator::findOne($employee->mediator_id);
                                        echo $employee_mediator->madiator_name;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $mediator_person = CommonPerson::findOne($employee->person_id);
                                        ?>
                                        <a href="#"> <?= $employee->person->first_name . ' ' . $employee->person->last_name ?>
                                        </a>
                                    </td>
                                    <td> <?= $employee->position->position ?></td>
                                    <td><?= $employee->person->phone ?></td>
                                    <td><?= $employee->person->email ?></td>
                                    <td><?= $employee->start_date ?></td>
                                    <td><div class="pxp-company-dashboard-job-status">
                                            <span class="badge rounded-pill bg-<?= ($current_user->status == 2) ? 'success' : 'danger'; ?>">
                                                <?= ($current_user->status == 2) ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <?php
                                                    if ($current_user->id != Yii::$app->user->id) {
                                                        if ($current_user->status == 1) {
                                                            ?>

                                                            <button title="Activate" class="action-button" onclick="return confirm_action(<?= $current_user->id ?>, 2);"><span class="fa fa-check"></span></button>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <button title="Deactivate" class="action-button" onclick="return confirm_action(<?= $current_user->id ?>, 1);"><span class="fa fa-ban"></span></button>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </li>

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
<?php $form = ActiveForm::begin(['id' => 'change_user_status', 'method' => 'POST', 'action' => Url::to(['/mediator/md-mediator/status'])]); ?>
<input type="hidden" name="user_id" id="selected_user_id">
<input type="hidden" name="action" id="action">
<?php ActiveForm::end(); ?>

<script type="text/javascript">
    function confirm_action(id, action) {
        if (confirm("Are you sure you want to perfom this action?")) {
            $('#selected_user_id').val(id);
            $('#action').val(action);
            $('#change_user_status').submit();
        }
        return false;
    }
</script>