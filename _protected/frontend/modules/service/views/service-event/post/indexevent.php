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
        <?php if (!$is_update) {
            ?>
            <h1>New Event</h1>
            <p class="pxp-text-light">Add a new Event to your company's Event list. Fields with <span style="color:red">*</span> are required</p>
            <?php
        } else {
            ?>
            <h1>Update event</h1>
            <p class="pxp-text-light">Update the registered event. Fields with <span style="color:red">*</span> are required</p>
            <?php
        }
        ?>
        <?php include('event.php'); ?>
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
    
    
    $("#serviceevent-always_open_flag").on('change', function ()
    {
        if ($(this).is(':checked')) {
            $("#serviceevent-closure_date").val("");
            $('#serviceevent-closure_date').prop('readonly', true);
        } else {
            $('#serviceevent-closure_date').prop('readonly', false);
        }

    });

    // A $( document ).ready() block.
    $(document).ready(function () {
        if ($("#serviceevent-always_open_flag").is(':checked')) {
            $('#serviceevent-closure_date').prop('readonly', true);
        } else {
            $('#serviceevent-closure_date').prop('readonly', false);
        }
    });
</script>
