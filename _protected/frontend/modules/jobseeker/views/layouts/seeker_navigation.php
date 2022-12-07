<?php
$current_view = Yii::$app->controller->action->id;
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <div class="pxp-logo">
        <a href="<?= Yii::getAlias('@frontendUrl'); ?>" class="pxp-animate"><img src="<?= Yii::getAlias('@staticUrl') ?>/images/kora.png" width="82px" height='40px'></a>
    </div>
    <?php if (!isset($_GET['js'])) { ?>
        <nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
            <div class="pxp-dashboard-side-label">User tools</div>
            <ul class="list-unstyled">
                <li class="<?= ($current_view == 'dashboard') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/jobseeker/user-profile/dashboard'; ?>"><span class="fa fa-home"></span>Dashboard</a></li>
                <li class="<?= ($current_view == 'index') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/jobseeker/user-profile/index'; ?>"><span class="fa fa-user"></span>My Profile</a></li>
                <li class="<?= ($current_view == 'applications') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/jobseeker/user-profile/applications'; ?>"><span class="fa fa-file-text-o"></span>Applications</a></li>
                <li class="<?= ($current_view == 'favourites') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/jobseeker/user-profile/favourites'; ?>"><span class="fa fa-user-circle-o"></span>Favourties Jobs</a></li>
                <li class="<?= ($current_view == '#') ? 'pxp-active' : '' ?>"> <a data-bs-toggle="modal" href="#change-password-modal"  href="#" ><span class="fa fa-lock"></span> Change Password</a></li>

            </ul>

        </nav>
    <?php } ?>
</div>
