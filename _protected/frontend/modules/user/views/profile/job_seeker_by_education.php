<?php

use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\SOccupationGrouping;

;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    if (Yii::$app->user->can('mediator')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else if (Yii::$app->user->can('employer')) {
        include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php");
    } else if (Yii::$app->user->can('RDB')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else {
        include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_navigation.php");
    }
    ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <h1>Job seekers by education field</h1>
        <p class="pxp-text-light">Total job seekers by education fields.</p>
        <div class="col-auto order-2 order-sm-1">
            <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                <select class="form-select" id="education_level" name="type">
                    <option value="0">Education level</option>
                    <?php
                    if (count($education_levels) > 0) {
                        foreach ($education_levels as $education_level) {
                            ?>
                            <option value="<?= $education_level['id'] ?>" <?php
                            if ($selected_level == $education_level['id']) {
                                echo 'selected';
                            }
                            ?>><?= $education_level['level'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                </select>
                <button class="btn ms-2" onclick="return filter_by_education_level();">Filter</button>
            </div>
        </div>
        <div class="mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                    <th>#</th>
                    <th>Education field</th>
                    <th>Total job seekers</th>
                    </thead>
                    <tbody>
                        <?php
                        if (count($educations) > 0) {
                            $counter = 1;
                            foreach ($educations as $education) {
                                if (strlen($education['field']) > 1) {
                                    ?>
                                    <tr>
                                        <td style="vertical-align: top;"><?= $counter ?></td>
                                        <td style="width: 65%;vertical-align: top;">
                                            <?= isset($education['field']) ? $education['field'] : ''; ?>
                                        </td>
                                        <td style="width: 15%;">
                                            <?= isset($education['total_user']) ? $education['total_user'] : ''; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $counter++;
                                }
                            }
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
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
<script type="text/javascript">
    function filter_by_education_level() {
        window.location.href = '<?= Yii::$app->link->frontendUrl('/user/profile/report-job-seekers'); ?>' + '?level=' + $('#education_level :selected').val();


    }
</script>


