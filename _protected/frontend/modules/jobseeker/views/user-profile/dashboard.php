<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;
use kartik\ipinfo\IpInfo;

if ($addresses == NULL || $addresses->country_id == 183) {
    $divsize = 9;
} else
    $divsize = 6;
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
<?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_navigation.php") ?> 


</div>
<div class="pxp-dashboard-content">
<?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_top_header.php") ?>



    <div class="pxp-dashboard-content-details">
        <h1>Dashboard</h1>
        <p class="pxp-text-light">Welcome to Your Kora Job Portal!
        </p>

        <div class="row mt-4 mt-lg-5 align-items-center">
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-primary">
                        <span class="fa fa-file-text-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number"><?php
                            foreach ($relatedskills as $jobrelated) {
                                echo $jobrelated['total'];
                            }
                            ?></div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Job applications</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-success bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-success">
                        <span class="fa fa-user-circle-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number">312</div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Profile visits</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-warning bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-warning">
                        <span class="fa fa-envelope-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number">?</div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Messages</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="pxp-dashboard-stats-card bg-danger bg-opacity-10 mb-3 mb-xxl-0">
                    <div class="pxp-dashboard-stats-card-icon text-danger">
                        <span class="fa fa-bell-o"></span>
                    </div>
                    <div class="pxp-dashboard-stats-card-info">
                        <div class="pxp-dashboard-stats-card-info-number"><?php foreach ($notifications as $notif) {
                                echo $notif['total'];
                            }
                            ?></div>
                        <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Notifications</div>
                    </div>
                </div>
            </div>
        </div>

        



        <div class="mt-4 mt-lg-5">
            <h2>Recent Job Apllications</h2>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <tr>
                        <th style="width: 25%;">Job Title</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 20%;">Company</th>
                        <th style="width: 12%;">Type</th>
                        <th></th>
                    </tr>
                    <?php
                    foreach ($relatedjob as $relatedjobs) {
                        ?>

                        <tr>
                            <td style="width: 25%;">
                                <a href="../../service/service/../service-job/view?id=<?= $relatedjobs['jobid'] ?>"><div class="pxp-candidate-dashboard-job-title"> <?= (isset($relatedjobs['jobtitle'])) ? $relatedjobs['jobtitle'] : ''; ?></div>
                                </a> </td>
                            <td style="width: 25%;"><div class="pxp-candidate-dashboard-job-category"><?php $occup = common\models\SOccupationGrouping::findOne($relatedjobs['occupation_grouping_id']); ?><?= (isset($occup->occupation_grouping)) ? $occup->occupation_grouping : ''; ?></div></td>
                            <td style="width: 25%;"><div class="pxp-candidate-dashboard-job-location"><span class="fa fa-globe"></span><?= $relatedjobs['employer'] ?></div></td>
                            <td style="width: 10%;"><div class="pxp-candidate-dashboard-job-type">
    <?php $jobtye = \backend\models\SJobType::findone([$relatedjobs['job_type_id']]); ?><?= (isset($jobtype->job_type)) ? $jobtype->job_type : ''; ?></div></td>
                            <td class="pxp-dashboard-table-options">
                                <div  >
                                    <ul class="list-unstyled">
                                        <li> <a title="View job details" href="../../service/service/../service-job/view?id=<?= $relatedjobs['jobid'] ?>"><button title="Preview" type="button" class="action-button"><span class="fa fa-eye"></span></button></a> </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
<?php } ?>

                </table>
            </div>
        </div>
    </div>


</div>

