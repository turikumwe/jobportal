<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<nav class="pxp-nav dropdown-hover-all d-none d-xl-block">
    <ul>
        <li class="nav-item dropdown"><?= Html::a(Yii::t('frontend', 'Home'), Yii::getAlias('@frontendUrl') . '/', ["class" => "active"]); ?></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Job seeker</a>
            <ul class="dropdown-menu" style="">
                <li class="pxp-dropdown-body">
                    <div class="pxp-dropdown-layout">
                        <div class="row gx-5 pxp-dropdown-lists">
                            <div class="col-auto pxp-dropdown-list">
                                <ul>
                                    <li>
                                        <a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job' ?>" class="pxp-has-icon-small">
                                            <div class="pxp-dropdown-icon">
                                                <span class="fa fa-th-large"></span>
                                            </div>
                                            <div class="pxp-dropdown-text">
                                                Find jobs
                                                <span>Browse for all available jobs</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= Yii::getAlias('@frontendUrl') . '/article/where-to-find-information-about-vacancies' ?>" class="pxp-has-icon-small">
                                            <div class="pxp-dropdown-icon">
                                                <span class="fa fa-th-large"></span>
                                            </div>
                                            <div class="pxp-dropdown-text">
                                                How to Apply
                                                <span>Instructions for applicants</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::getAlias('@frontendUrl') . '/article/rwandan-abroad'; ?>" class="pxp-has-icon-small">
                                            <div class="pxp-dropdown-icon">
                                                <span class="fa fa-th"></span>
                                            </div>
                                            <div class="pxp-dropdown-text">
                                                Rwandan Abroad
                                                <span>Rwandans abroad guidelines</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::getAlias('@frontendUrl') . '/article/nep-kora-wigire'; ?>" class="pxp-has-icon-small">
                                            <div class="pxp-dropdown-icon">
                                                <span class="fa fa-th-list"></span>
                                            </div>
                                            <div class="pxp-dropdown-text">
                                                NEP Kora Wigire
                                                <span>About NEP Kora wigire</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::getAlias('@frontendUrl') . '/article/career-guidance'; ?>" class="pxp-has-icon-small">
                                            <div class="pxp-dropdown-icon">
                                                <span class="fa fa-toggle-right"></span>
                                            </div>
                                            <div class="pxp-dropdown-text">
                                                Career Guidance
                                                <span>All you need grow your career</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::getAlias('@frontendUrl') . '/article/employment-service-centres' ?>" class="pxp-has-icon-small">
                                            <div class="pxp-dropdown-icon">
                                                <span class="fa fa-list-ul"></span>
                                            </div>
                                            <div class="pxp-dropdown-text">
                                                Employment Service Centres
                                                <span>Centres which can help you</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                            </div>

                        </div>
                    </div>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown"><?php echo Html::a(Yii::t('frontend', 'Training'), Yii::getAlias('@frontendUrl') . '/service/service-event'); ?></li>
        <?php
        if (Yii::$app->user->isGuest || Yii::$app->user->can('employer') || Yii::$app->user->can('mediator')) {
            ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Employer</a>
                <ul class="dropdown-menu" style="">
                    <li class="pxp-dropdown-body">
                        <div class="pxp-dropdown-layout">
                            <div class="row gx-5 pxp-dropdown-lists">
                                <div class="col-auto pxp-dropdown-list">
                                    <ul>
                                        <li>
                                            <a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/post-opportunity' ?>" class="pxp-has-icon-small">
                                                <div class="pxp-dropdown-icon">
                                                    <span class="fa fa-th-large"></span>
                                                </div>
                                                <div class="pxp-dropdown-text">
                                                    Post job
                                                    <span>Publish job to Kora</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="pxp-has-icon-small">
                                                <div class="pxp-dropdown-icon">
                                                    <span class="fa fa-th"></span>
                                                </div>
                                                <div class="pxp-dropdown-text">
                                                    Find talents
                                                    <span>Submit request for talents</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/job-applicant' ?>" class="pxp-has-icon-small">
                                                <div class="pxp-dropdown-icon">
                                                    <span class="fa fa-th-large"></span>
                                                </div>
                                                <div class="pxp-dropdown-text">
                                                    Manage applicants
                                                    <span>Applicants from my jobs</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                </div>

                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        <?php }
        ?>
        <li class="nav-item dropdown"><?php echo Html::a(Yii::t('frontend', 'Digital Jobs'), 'https://kora.rw/digitaljobs/', ['target' => '_blank']); ?></li>

<!--                    <li class="nav-item dropdown"><?php if (Yii::$app->user->can('mediator')) echo Html::a(Yii::t('frontend', 'Job seeker'), Yii::getAlias('@frontendUrl') . '/jobseeker/user-profile/admin'); ?></li>
<li class="nav-item dropdown"><?php if (Yii::$app->user->can('mediator')) echo Html::a(Yii::t('frontend', 'Applicants'), Yii::getAlias('@frontendUrl') . '/mediator/report-application'); ?></li>
<li class="nav-item dropdown"><?php if (Yii::$app->user->can('manager') || Yii::$app->user->can('RDB')) echo Html::a(Yii::t('frontend', 'List of Rwandan Abroad'), Yii::getAlias('@frontendUrl') . '/abroad/user-profile/admin'); ?></li>-->
        <!--<li class="nav-item dropdown"><?php if (Yii::$app->user->can('manager') || Yii::$app->user->can('employer') || Yii::$app->user->can('mediator')) echo Html::a(Yii::t('frontend', 'Job seekers'), Yii::getAlias('@frontendUrl') . '/user/profile/report-job-seekers'); ?></li>-->

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">News and events</a>
            <ul class="dropdown-menu" style="">
                <li class="pxp-dropdown-body">
                    <div class="pxp-dropdown-layout">
                        <div class="row gx-5 pxp-dropdown-lists">
                            <div class="col-auto pxp-dropdown-list">
                                <ul>
                                    <li>
                                        <a href="<?= Yii::getAlias('@frontendUrl') . '/news/news-news' ?>" class="pxp-has-icon-small">
                                            <div class="pxp-dropdown-icon">
                                                <span class="fa fa-th-large"></span>
                                            </div>
                                            <div class="pxp-dropdown-text">
                                                News
                                                <span>All posted news</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= Yii::getAlias('@frontendUrl') . '/service/service-event/event' ?>" class="pxp-has-icon-small">
                                            <div class="pxp-dropdown-icon">
                                                <span class="fa fa-th-large"></span>
                                            </div>
                                            <div class="pxp-dropdown-text">
                                                Events
                                                <span>List all posted events</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                            </div>

                        </div>
                    </div>
                </li>
            </ul>
        </li>
        <!--<li class="nav-item dropdown"><?php echo Html::a(Yii::t('frontend', 'News and events'), Yii::getAlias('@frontendUrl') . '/news/news-news'); ?></li>-->
        <!--<li class="nav-item dropdown"><?php if (Yii::$app->user->can('mediator')) echo Html::a(Yii::t('frontend', 'USSD'), Yii::getAlias('@frontendUrl') . '/service/ussd-jobseeker/admin'); ?></li>-->
        <!--<li class="nav-item dropdown"><?php if (Yii::$app->user->can('mediator')) echo Html::a(Yii::t('frontend', 'Mediators'), Yii::getAlias('@frontendUrl') . '/mediator/md-mediator/admin'); ?></li>-->
    </ul>
</nav>
<nav class="pxp-user-nav d-none d-sm-flex">
    <div class="pxp-user-nav pxp-on-light">
        <?php
        if (Yii::$app->user->isGuest) {
            echo Html::a('Create account', Yii::getAlias('@frontendUrl') . '/site/createaccount', ['title' => 'This link will take you to the page where different accounts can be created', 'class' => 'btn rounded-pill pxp-nav-btn', 'accesskey' => 'c']) . ' | ';
            ?>
            <a class="btn rounded-pill pxp-user-nav-trigger pxp-on-light" id="loginButton" data-bs-toggle="modal" href="#pxp-signin-modal" role="button">Sign in</a>
            <?php
        }
        ?>
        <?php if (!Yii::$app->user->isGuest) { ?>
            <?php
            $user_notifications = common\models\SNotifications::find()->where(['user_id' => Yii::$app->user->identity->id, 'is_opened' => 0])->all();
            $user_notifications_display = common\models\SNotifications::find()->where(['user_id' => Yii::$app->user->identity->id])->limit(5)->all();
            ?>
            <div class="dropdown pxp-user-nav-dropdown pxp-user-notifications">
                <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="fa fa-bell-o"></span>
                    <div class="pxp-user-notifications-counter"><?= count($user_notifications) ?></div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php
                    if (count($user_notifications_display) > 0) {
                        foreach ($user_notifications_display as $notification) {
                            ?>
                            <li><a class="dropdown-item" data-bs-toggle="modal" href="#notification-view-modal"  href="#" onclick="return load_notification(<?= $notification->id; ?>)"><strong><?= strlen($notification->message_title) > 25 ? substr($notification->message_title, 0, 25) . "..." : $notification->message_title; ?></strong> Message details <strong><?= strlen($notification->message_body) > 50 ? substr($notification->message_body, 0, 50) . "..." : $notification->message_body; ?></strong>. <span class="pxp-is-time"><?= date_format(date_create($notification->created_at), "M d, Y H:i:s") ?></span></a></li>
                            <?php
                        }
                    }
                    ?>
                    <li><a class="dropdown-item pxp-link" href="<?= Yii::getAlias('@frontendUrl') . '/user/profile/notification'; ?>">View All</a></li>
                </ul>
            </div>
            <div class="dropdown pxp-user-nav-dropdown">

                <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <?php
                    $profilepic = common\models\UserProfile::findOne(Yii::$app->user->identity);
                    if (isset($profilepic) && strlen($profilepic->profile) > 2) {
                        ?>
                        <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/<?php echo $profilepic->profile; ?>);"></div>
                        <?php
                    } else {
                        ?>
                        <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/noimage.png);"></div>
                    <?php } ?>

                    <div class="pxp-user-nav-name d-none d-md-block"><?= Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username; ?></div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php if (Yii::$app->user->can('user') && !Yii::$app->user->can('administrator')) { ?>
                        <li><?php echo Html::a(Yii::t('frontend', 'My profile'), Url::to(['/jobseeker/user-profile']), ['data-method' => 'post', 'class' => 'dropdown-item']); ?></li>
                    <?php } ?>
                    <?php if (Yii::$app->user->can('mediator')) { ?>
                        <li><?php echo Html::a(Yii::t('frontend', 'My profile'), Url::to(['/mediator/md-mediator']), ['data-method' => 'post', 'class' => 'dropdown-item']); ?></li>
                    <?php } ?>
                    <?php if (Yii::$app->user->can('employer')) { ?>
                        <li><?php echo Html::a(Yii::t('frontend', 'My profile'), Url::to(['/employer/empl-employer/']), ['data-method' => 'post', 'class' => 'dropdown-item']); ?></li>
                    <?php } ?>
                    <?php if (Yii::$app->user->can('manager')) { ?>
                        <li><?php echo Html::a(Yii::t('frontend', 'Backend'), Yii::getAlias('@web/backend'), ['class' => 'dropdown-item']); ?></li>
                    <?php } ?>
                    <li><?php echo Html::a(Yii::t('frontend', 'Logout'), Url::to(['/user/sign-in/logout']), ['data-method' => 'POST', 'accesskey' => 'g', 'class' => 'dropdown-item']); ?></li>
                </ul>
            </div>
        <?php } ?>
    </div>
</nav>

<div class="modal fade pxp-user-modal" id="notification-view-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Notification</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <tbody id="TableItemsNotification">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade pxp-user-modal" id="profile-completion-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-small">
        <div class="modal-content">
            <div class="modal-header">
                <h3>User profile completion</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <tbody id="TableItems">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (!Yii::$app->user->isGuest) {
    ?>
    <div class="modal fade pxp-user-modal" id="change-password-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Change password</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="user-profile-form"> 
                            <?php
                            //$password_model = \common\models\ChangePasswordForm::find()->where(['id' => \Yii::$app->user->identity->id])->One();
                            $accountForm = new frontend\modules\user\models\AccountForm();
                            $accountForm->setUser(Yii::$app->user->identity);
                            ?>
                            <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl('/user/profile/change-password'), 'method' => 'POST']); ?>

                            <?= $form->errorSummary($accountForm); ?>
                            <div class="col-md-12">
                                <div class="mb-12">
                                    <?php echo $form->field($accountForm, 'username')->textInput(['readonly' => true]) ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-12">
                                    <?php echo $form->field($accountForm, 'email')->textInput(['readonly' => true]) ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-12">
                                    <?php echo $form->field($accountForm, 'password')->passwordInput() ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-12">
                                    <?php echo $form->field($accountForm, 'password_confirm')->passwordInput() ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group"> 
                                <?= Html::submitButton(Yii::t('app', 'Change password'), ['class' => 'btn btn-success']) ?> 
                            </div> 

                            <?php ActiveForm::end(); ?> 

                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<script type="text/javascript">
    function load_notification(id) {
        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/service/api/notification-modal') ?>',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                $("#TableItemsNotification").empty().append(data.table_data);
                console.log(data.table_data);
            }
        });
    }

    function check_user_completion_percentage(id) {
        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/service/api/profile-completeness-modal') ?>',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                $("#TableItems").empty().append(data.table_data);
                console.log(data.table_data);
            }
        });
    }

</script>