
<?php

//use kartik\typeahead\TypeaheadBasic;

use frontend\assets\FrontendAsset;
use yii\helpers\Url;
use trntv\filekit\widget\Upload;
use common\models\JsExperience;
use kartik\typeahead\Typeahead;
use common\models\JsEducation;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\JsEndorse;
use common\models\JsAddress;
use common\models\ServiceJob;
use common\models\JsSkill;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\db\Query;
use common\models\SOccupationGrouping;
use \yii\widgets\CustomLinkPager;
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_navigation.php") ?>


</div>
<div class="pxp-dashboard-content">
    <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_top_header.php") ?>


    <div class="pxp-dashboard-content-details">
        <h1>Job Applications</h1>
        <p class="pxp-text-light">Detailed list of Job that you applied for .</p>

        <div class="mt-4 mt-lg-5">
            <div class="row justify-content-between align-content-center">
                <div class="col-auto order-2 order-sm-1">
                    <?php
                    if (isset($title)) {
                        echo'<h5>All Jobs with name like ' . $title . '</h5>';
                    } else {
                        
                    }
                    ?>
                </div>
                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?php
                            if (isset($title)) {
                                
                            } else {
                                echo $totalapplied . ' Applications';
                            }
                            ?>
                        </div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_job_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/jobseeker/user-profile/applications')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="title" class="form-control" placeholder="Search jobs...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th   style="width: 25%;">Applied for</th>
                            <th style="width: 20%;">Posted by</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 15%;">Placement status</th>
                            <th>Posting date<span class="fa fa-angle-up ms-3"></span></th>
                            <th>Closure date<span class="fa fa-angle-up ms-3"></span></th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($allapp as $applications) {
                            ?>
                            <tr>

                                <td>

                                    <div class="pxp-company-dashboard-job-title"><a target="_blank" href="../../service/service-job/view?id=<?= $applications['job_id']; ?>"  ><?=
                                            $job = ServiceJob::findone($applications['job_id'])->jobtitle;
                                            ?></a></div>

                                </td>
                                <td><div class="pxp-company-dashboard-job-category"><?php
                                        $employer = common\models\EmplEmployer::findone(ServiceJob::findone($applications['job_id'])->employer);
                                        if (isset($employer)) {
                                            echo $employer->company_name;
                                        } else {
                                            echo ServiceJob::findone($applications['job_id'])->employer;
                                        }
                                        $application_status = \common\models\JobApplicationStatus::findOne($applications['job_application_status_id']);
                                        $job_application_status = null;
                                        if (isset($application_status)) {
                                            $job_application_status = backend\models\SStatus::findOne($application_status->status_id);
                                        }
                                        ?></div></td>
                                <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-<?= isset($job_application_status->label) ? $job_application_status->label : 'secondary'; ?>"><?= isset($job_application_status->status) ? $job_application_status->status : 'Waiting'; ?></span></div>
                                </td>
                                <td>
                                    N/A
                                </td>
                                <td>
                                    <div class="pxp-company-dashboard-job-date"><?=
                                        ServiceJob::findone($applications['job_id'])->posting_date;
                                        ?></div>
                                </td>
                                <td>
                                    <div class="pxp-company-dashboard-job-date"><?=
                                        ServiceJob::findone($applications['job_id'])->closure_date;
                                        ?></div>
                                </td>
                                <td >
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">

                                            <?php
                                            $today = DATE('Y-m-d');
                                            $closuredate = ServiceJob::findone($applications['job_id'])->closure_date;
                                            $application = common\models\JobApplicationStatus::find()->where(['job_application_id' => $applications['id']])->all();
                                            if ($today < $closuredate && count($application) == 0) {
                                                ?>
                                                <li><a title="Remove Job from List" href="#"   type="button" value="Cancel" onclick="if (confirm('Are you sure you want to withdraw your application ?'))
                                                                    window.location.href = 'removeitem?jobid=<?= $applications['id'] ?>';" />Withdraw application
                                                    </a></li>
                                            <?php } ?>  
                                        </ul>
                                    </div>
                                </td>
                            </tr><?php } ?>




                    </tbody>
                </table>

                <div  >
                    <div  >



                        <?php
                        if (!empty($title)) {
                            
                        } else {
                            echo CustomLinkPager::widget([
                                'pagination' => $pagination,
                            ]);
                        }
                        ?>
                    </div>     
                </div>

            </div>
        </div>
    </div>
</div>
