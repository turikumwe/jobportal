<?php

use common\models\UserProfile;
use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$this->title = Yii::t('app', 'Service Job');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});";

$this->registerJs($search);

/* @var $this View */
/* @var $model UserProfile */
/* @var $form ActiveForm */
$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Profile');
$admin = (isset($_GET['visitor'])) ? "admin" : "";
?>
<?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php") ?>
<div class="pxp-dashboard-content">
    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_top_header.php") ?>

    <div class="pxp-dashboard-content-details">
        <h1>Dashboard</h1>
        <p class="pxp-text-light">Welcome to Your Kora Job  Portal</p>

        <div class="row mt-4 align-items-center">
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-primary">
                        <span class="fa fa-file-text-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number"><?= $published_jobs; ?></div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Posted Jobs </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-primary">
                        <span class="fa fa-file-text-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number"><?= $published_events; ?></div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Posted events </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-success">
                        <span class="fa fa-user-circle-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number"><?= $total_jobseekers; ?></div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Job seekers</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-danger">
                        <span class="fa fa-bell-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <?php
                        $user_notifications = common\models\SNotifications::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
                        ?>
                        <div class="pxp-dashboard-stats-card-info-number"><?= count($user_notifications) ?></div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Notifications</div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
