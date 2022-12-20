<?php
$current_view = Yii::$app->controller->action->id;
$current_controller = Yii::$app->controller->id;
$current_module = Yii::$app->controller->module->id; 
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <div class="pxp-logo">
        <a href="<?= Yii::getAlias('@frontendUrl'); ?>" class="pxp-animate"><img src="<?= Yii::getAlias('@staticUrl') ?>/images/kora.png" width="82px" height='40px'></a>
    </div>

    <nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
        <ul class="list-unstyled">
            <li class="<?= (in_array($current_view, array('index')) && strlen(strstr($current_controller, 'report')) < 1) ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/mediator/md-mediator'; ?>"><span class="fa fa-home"></span>Dashboard</a></li>
            <li class="<?= ($current_view == 'user-profile') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/mediator/md-mediator/user-profile'; ?>"><span class="fa fa-user"></span>My Profile</a></li>
            <li class="dropdown pxp-dashboard-side-user-nav-dropdown dropdown <?= (in_array($current_view, array('post-service', 'serviced', 'post-service-private', 'private-serviced', 'post-service-private'))) ? 'pxp-active' : '' ?>">
                <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="fa fa-file-text-o"></span>
                    <div class="pxp-dashboard-side-user-nav-name">My reports</div>
                </a>
                <ul class="dropdown-menu">
                    <?php if (common\models\MdMediator::isFromPublicMediator()) { ?>
                        <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/service/mediator-service/post-service'; ?>">Submit a report</a></li>
                        <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/service/mediator-service/serviced'; ?>">View submitted reports</a></li>
                        <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/service/mediator-service/serviced-summary'; ?>">Service summary</a></li>
                    <?php } else { ?>
                        <?php ?>
                        <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/service/mediator-service/post-service-private'; ?>">Submit quarterly report</a></li>
                        <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/service/mediator-service/private-serviced'; ?>">View submitted reports</a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php if (Yii::$app->user->can('RDB')) { ?>
                <li class="dropdown pxp-dashboard-side-user-nav-dropdown dropdown <?= (in_array($current_module, array('hr'))) ? 'pxp-active' : '' ?>">
                    <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="fa fa-file-text-o"></span>
                        <div class="pxp-dashboard-side-user-nav-name">Human resource</div>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/hr/assessments/list'; ?>">Assessment</a></li>
                        <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/hr/assessments/candidates'; ?>">Candidates</a></li>

                    </ul>
                </li>
            <?php } ?>
            <li class="<?= (in_array($current_view, array('post-opportunity', 'post-opportunity-from-other-source', 'post-job'))) ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/post-job'; ?>"><span class="fa fa-briefcase"></span>Post a Job</a></li>
            <?php if (common\models\MdMediator::isFromPublicMediator()) { ?>
                <li class="<?= ($current_view == 'job-seeker') ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/mediator/md-mediator/job-seeker'; ?>"><span class="fa fa-user-circle-o"></span>My job seekers</a></li>
            <?php } ?>

            <li class="dropdown pxp-dashboard-side-user-nav-dropdown dropdown <?= (in_array($current_view, array('my-jobs', 'my-events', 'job-applicant'))) ? 'pxp-active' : '' ?>">
                <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="fa fa-file-text-o"></span>
                    <div class="pxp-dashboard-side-user-nav-name">Manage</div>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/my-jobs'; ?>">My posted jobs</a></li>
                    <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/service/service-event/my-training'; ?>">My posted training</a></li>
                    <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/service/service-event/my-events'; ?>">My posted events</a></li>
                    <?php if (Yii::$app->user->can('RDB')) { ?>
                        <li><a class="dropdown-item" href="<?= Yii::getAlias('@frontendUrl') . '/news/news-news/admin'; ?>">News</a></li>
                    <?php } ?>
                </ul>
            </li>
            <li class="<?= (in_array($current_view, array('placement'))) ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/placement '; ?>"><span class="fa fa-list"></span>Placement</a></li>

            <li class="<?= (in_array($current_view, array('report', 'serviced-summary', 'serviced-details', 'serviced-details-d', 'report-job-seekers')) || strlen(strstr($current_controller, 'report')) > 0) ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/mediator/report'; ?>"><span class="fa fa-list"></span>Reports</a></li>

            <?php if (Yii::$app->user->can('mediator_admin')) { ?>
                <li class="<?= (in_array($current_view, array('mediator-users'))) ? 'pxp-active' : '' ?>"><a href="<?= Yii::getAlias('@frontendUrl') . '/mediator/md-mediator/mediator-users'; ?>"><span class="fa fa-user-circle-o"></span>Users</a></li>
            <?php } ?>
            <li class="<?= ($current_view == 'change-password') ? 'pxp-active' : '' ?>"><a data-bs-toggle="modal" href="#change-password-modal"  href="#" ><span class="fa fa-lock"></span>Change Password</a></li>

        </ul>

    </nav>
</div>