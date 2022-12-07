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
<?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php") ?>
<div class="pxp-dashboard-content">
    <?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_top_header.php") ?>

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
                        <div class="pxp-dashboard-stats-card-info-number">13</div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Jobs posted</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-success">
                        <span class="fa fa-user-circle-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number">312</div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Applications</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-warning">
                        <span class="fa fa-envelope-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number">14</div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Unread messages</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-danger">
                        <span class="fa fa-bell-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number">5</div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Notifications</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xl-6">
                <h2>Company Profile Visits</h2>
                <div class="mt-3 mt-lg-4 pxp-dashboard-chart-container">
                    <div class="row justify-content-between align-content-center mb-4">
                        <div class="col-auto">
                            <span class="pxp-dashboard-chart-value">154</span><span class="pxp-dashboard-chart-percent text-success"><span class="fa fa-long-arrow-up"></span> 34%</span><span class="pxp-dashboard-chart-vs">vs last 7 days</span>
                        </div>
                        <div class="col-auto">
                            <select class="form-select">
                                <option value="-7 days">Last 7 days</option>
                                <option value="-30 days">Last 30 days</option>
                                <option value="-60 days">Last 60 days</option>
                                <option value="-90 days">Last 90 days</option>
                                <option value="-12 months">Last 12 months</option>
                            </select>
                        </div>
                    </div>
                    <canvas id="pxp-company-dashboard-visits-chart"></canvas>
                </div>
            </div>
            <div class="col-xl-6">
                <h2 class="mt-4 mt-xl-0">Applications</h2>
                <div class="mt-3 mt-lg-4 pxp-dashboard-chart-container">
                    <div class="row justify-content-between align-content-center mb-4">
                        <div class="col-auto">
                            <span class="pxp-dashboard-chart-value">280</span><span class="pxp-dashboard-chart-percent text-success"><span class="fa fa-long-arrow-up"></span> 56%</span><span class="pxp-dashboard-chart-vs">vs last 7 days</span>
                        </div>
                        <div class="col-auto">
                            <select class="form-select">
                                <option value="-7 days">Last 7 days</option>
                                <option value="-30 days">Last 30 days</option>
                                <option value="-60 days">Last 60 days</option>
                                <option value="-90 days">Last 90 days</option>
                                <option value="-12 months">Last 12 months</option>
                            </select>
                        </div>
                    </div>
                    <canvas id="pxp-company-dashboard-app-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
