<?php
$current_view = Yii::$app->controller->action->id;
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <div class="pxp-logo">
        <!--<a href="<?= Yii::getAlias('@frontendUrl'); ?>" class="pxp-animate"><img src="<?= Yii::getAlias('@staticUrl') ?>/images/kora.png" width="82px" height='40px'></a>-->
    </div>

    <nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
        <div class="pxp-dashboard-side-label">User tools</div>
        <ul class="list-unstyled">
            <li class="<?= ($current_view == 'index') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/employer/empl-employer'; ?>"><span class="fa fa-home"></span>Dashboard</a></li>
            <li class="<?= ($current_view == 'profile') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/employer/empl-employer/profile'; ?>"><span class="fa fa-user"></span>My Profile</a></li>
            <li class="<?= ($current_view == 'new-job') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/employer/empl-employer/new-job'; ?>"><span class="fa fa-file-text-o"></span>New Job Offer</a></li>
            <li class="<?= ($current_view == 'my-jobs') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/my-jobs'; ?>"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
            <li class="<?= ($current_view == 'candidates') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/employer/empl-employer/candidates'; ?>"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
            <li class="<?= ($current_view == 'reports') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/employer/empl-employer/reports'; ?>"><span class="fa fa-list"></span>Reports</a></li>
            <li class="<?= ($current_view == 'change-password') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/employer/empl-employer/change-password'; ?>"><span class="fa fa-lock"></span>Change Password</a></li>
        </ul>
        <div class="pxp-dashboard-side-label mt-3 mt-lg-4">Insights</div>
        <ul class="list-unstyled">

            <li>
                <a href="company-dashboard-notifications.html" class="d-flex justify-content-between align-items-center">
                    <div><span class="fa fa-bell-o"></span>Notifications</div>
                    <span class="badge rounded-pill">5</span>
                </a>
            </li>
        </ul>
    </nav>
</div>