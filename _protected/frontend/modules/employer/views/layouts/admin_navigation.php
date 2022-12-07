<?php
$current_view = Yii::$app->controller->action->id;
$current_controller = Yii::$app->controller->id;
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <div class="pxp-logo">
        <a href="<?= Yii::getAlias('@frontendUrl'); ?>" class="pxp-animate"><img src="<?= Yii::getAlias('@staticUrl') ?>/images/kora.png" width="82px" height='40px'></a>
    </div>

    <nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
        <div class="pxp-dashboard-side-label">User tools</div>
        <ul class="list-unstyled">
            <li class="<?= (in_array($current_view, array('index')) && strlen(strstr($current_controller, 'report')) < 1) ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/employer/empl-employer'; ?>"><span class="fa fa-home"></span>Dashboard</a></li>
            <li class="<?= ($current_view == 'profile') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/employer/empl-employer/profile'; ?>"><span class="fa fa-user"></span>My Profile</a></li>
            
            <li class="<?= (in_array($current_view, array('post-opportunity', 'post-opportunity-from-other-source','post-job'))) ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/post-job'; ?>"><span class="fa fa-briefcase"></span>Post a Job</a></li>
            <li class="<?= ($current_view == 'my-jobs') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/my-jobs'; ?>"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
            <li class="<?= ($current_view == 'my-training') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-event/my-training'; ?>"><span class="fa fa-briefcase"></span>Manage trainings</a></li>
            <li class="<?= ($current_view == 'my-events') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-event/my-events'; ?>"><span class="fa fa-briefcase"></span>Manage events</a></li>
            <li class="<?= ($current_view == 'job-applicant') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/job-applicant'; ?>"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
            <li class="<?= (in_array($current_view, array('report', 'serviced-summary', 'serviced-details', 'serviced-details-d', 'report-job-seekers')) || strlen(strstr($current_controller, 'report')) > 0) ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/mediator/report'; ?>"><span class="fa fa-list"></span>Reports</a></li>
            <li class="<?= ($current_view == 'change-password') ? 'pxp-active' : '' ?>"><a data-bs-toggle="modal" href="#change-password-modal"  href="#" ><span class="fa fa-lock"></span>Change Password</a></li>

        </ul>

    </nav>
</div>