<?php

use common\models\UserProfile;
use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this View */
/* @var $model UserProfile */
/* @var $form ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    if (Yii::$app->user->can('mediator')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else {
        include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php");
    }
    ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <h1>New Job Offer</h1>
        <?php
        if (\common\models\User::isFromEmployer(Yii::$app->user->identity->id)) {
            if ($employer->employerProfile->is_verified == 1) {
                include('_job_form_selection.php');
            } else {
                ?>
                <div class="alert alert-warning">
                    <strong>Employer not verified!</strong><br />
                    Your employer is not verified. The verification process is ongoing. you will be notified upon verification completion. You may contact RDB for your status check<br />
                    <strong>It is after the verification that you can be able to post Jobs!</strong>
                </div>
                <?php
            }
        } else {
            ?>
            <?php include('_job_form_selection.php'); ?>
        <?php } ?>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
<script>
    function remove(id, url, div) {
        if (confirm("Are you sure?.")) {
            $.ajax({
                type: "POST",
                url: "/jobseeker/" + url + "/delete?id=" + id,
                dataType: "json",
                success: function (data) {
                    $("#" + div).load(" #" + div);
                }
            });
        }
    }

    function search(idOtherProfile) {
        window.location.href = "/jobseeker/user-profile/index?idOtherProfile=" + idOtherProfile;
    }
    function go_to_selected_form() {
        if (parseInt($('#form_type :selected').val()) > 0) {
            if (parseInt($('#form_type :selected').val()) === 1) {
                window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-job/post-opportunity'); ?>';

            } else {
                window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-job/post-opportunity-from-other-source'); ?>';
            }
        } else {
            alert("Please make valid selections");
        }
    }

    function removeHttps(id) {
        let httplink = $("#" + id).val().toLowerCase().replace('https', 'http');
        $("#" + id).val(httplink);
    }
</script>