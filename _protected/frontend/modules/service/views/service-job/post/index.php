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
        <p class="pxp-text-light">Add a new job to your company's jobs list. Fields with <span style="color:red">*</span> are required</p>

        <?php include('opportunity.php'); ?>
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

    function removeHttps(id) {
        let httplink = $("#" + id).val().toLowerCase().replace('https', 'http');
        $("#" + id).val(httplink);
    }
</script>