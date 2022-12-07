
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
 
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
            <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_navigation.php") ?>
    
             
        </div>
        <div class="pxp-dashboard-content">
             <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_top_header.php") ?>
    
                       <div class="pxp-dashboard-content-details">
                <h1>Job Lists</h1>
                <p class="pxp-text-light">Detailed list of Jobs.</p>

                <div class="mt-4 mt-lg-5">
                    <div class="row justify-content-between align-content-center">
                        <div class="col-auto order-2 order-sm-1">
                            <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                                <select class="form-select">
                                    <option>Bulk actions</option>
                                    <option>Approve</option>
                                    <option>Reject</option>
                                    <option>Delete</option>
                                </select>
                                <button class="btn ms-2">Apply</button>
                            </div>
                        </div>
                        <div class="col-auto order-1 order-sm-2">
                            <div class="pxp-company-dashboard-jobs-search mb-3">
                                <div class="pxp-company-dashboard-jobs-search-results me-3">3 candidates</div>
                                <div class="pxp-company-dashboard-jobs-search-search-form">
                                    <div class="input-group">
                                        <span class="input-group-text"><span class="fa fa-search"></span></span>
                                        <input type="text" class="form-control" placeholder="Search candidates...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="pxp-is-checkbox" style="width: 1%;"><input type="checkbox" class="form-check-input"></th>
                                    <th colspan="2" style="width: 25%;">Job</th>
                                    <th style="width: 20%;">Category</th>
                                    <th style="width: 15%;">Type</th>
                                    <th style="width: 15%;">Required Skills</th>
                                    <th>Date<span class="fa fa-angle-up ms-3"></span></th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                $conn= \Yii::$app->db;
                $alljobs= 'select * from service_job order by posting_date asc limit 8';
                $jobresult=$conn->createCommand($alljobs)->queryAll();
                foreach($jobresult as $jobz)
                {
                ?>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title"><a href="../../service/service-job/view?id=<?=$jobz['id'];?>"  >
                                    <?= (isset($jobz['jobtitle'])) ? $jobz['jobtitle']:'' ;?></a></div>
                                               </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category"><?php $occup=SOccupationGrouping::findOne($jobz['occupation_grouping_id']);?><?= (isset($occup->occupation_grouping))?$occup->occupation_grouping:'';?></div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-success">
                                    <?php  $jobtye=\backend\models\SJobType::findone([$jobz['job_type_id']]);?><?= (isset($jobtype->job_type))? $jobtype->job_type:'';?></span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?php 
                                        $conn= \Yii::$app->db;
                                        $requiredskillz='select s.skill from jobskills as j,s_skill as s where j.job_id="'.$jobz['id'].'" and j.skill_id=s.id'; 
                                        $skillzresult=$conn->createCommand($requiredskillz)->queryAll();
                                        foreach($skillzresult as $reqskills)
                                        {
                                           ?>
                                            <span class="badge rounded-pill bg-success"><?= (isset($reqskills['skill'])) ? $reqskills['skill']:'' ;?></span>
                                            <?php
                                        }
                                        ?></div>
                                    </td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date"><?=
                                            (isset($jobz['posting_date']))? $jobz['posting_date']:'' ;?>
                                            </div>
                                    </td>
                                    <td>
                                         
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><?php if (Yii::$app->user->can('user')){?> 
                                           <form action='favjobs' method="GET">
                                              <input type='hidden' name='fav' value='1'> 
                                                   <input type='hidden' name='user_id' value='<?=Yii::$app->user->id; ?>'> 
                                                   <input type='hidden' name='jobid' value='<?=$jobz['id']; ?>'> 
                                                 <button class='btn rounded-pill pxp-nav-btn'><span class='fa fa-heart'></span></button>
                                                    </form><?php }?></li>
                                                 
                                            </ul>
                                        </div>
                                    </td>
                </tr><?php }?>
                            
                                 
                                 
                                 
                            </tbody>
                        </table>

                        <div class="row mt-4 mt-lg-5 justify-content-between align-items-center">
                            <div class="col-auto">
                                <nav class="mt-3 mt-sm-0" aria-label="Candidates pagination">
                                    <ul class="pagination pxp-pagination">
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">1</span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="btn rounded-pill pxp-section-cta mt-3 mt-sm-0">Show me more<span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>