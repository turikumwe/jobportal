
<?php

use backend\models\SEducationField;
use backend\models\SEducationLevel;
use backend\models\SJobType;
use common\models\SOccupationGrouping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use common\models\FavoriteJobs;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = \frontend\assets\FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<style>
    .howapply-wrp .howapply__cont .howapply__xpla li {
        list-style-type: initial;
        margin-left: 15px;
    }
</style>
<?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
<section class="mt-4" style="background-color: var(--pxpSecondaryColorLight);">
    <div class="pxp-container">
        <div class="pxp-single-job-cover pxp-cover" style="background-image: url(../../static/images/ph-big.jpg);"></div>
        <?php
        if ($model->employer_logo) {
            ?>
            <div class="pxp-single-job-cover-logo" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/<?php echo $profilepic->profile; ?>);"></div> 
            <?php
        } else {
            ?>
            <div class="pxp-single-job-cover-logo" style="background-image: url(../../static/images/company-logo-3.png);"></div> 

        <?php }
        ?>
        <div class="pxp-single-job-content mt-4">
            <div class="row" style="background-color:#ffffff; border-radius: 25px; padding-top: 15px; padding-bottom: 15px; padding-left: 20px">

                <div class="col-lg-7 col-xl-8 col-xxl-9" > <div class="row justify-content-between align-items-center">
                        <div class="col-xl-8 col-xxl-6"> 
                            <h1><?= $model->jobtitle; ?></h1>
                            <div class="pxp-single-job-company-location">
                                Posted  by: <a href="#" class="pxp-single-job-company"><?php
                                    if (isset($model->employer)) {
                                        $employer = \common\models\EmplEmployer::findone($model->employer);
                                        if (isset($employer)) {
                                            echo \common\models\EmplEmployer::findone($model->employer)->company_name;
                                        } else {
                                            echo $model->employer;
                                        }
                                    }
                                    ?></a>   

                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="pxp-single-job-options mt-4 col-xl-0">
                                <?php
                                if (Yii::$app->user->isGuest) {
                                    ?> 
                                    <a href="<?= Yii::getAlias('@frontendUrl') . '/site/createaccount'; ?>" type="button" title="Add job to your favorites" type="submit" class="btn pxp-single-job-save-btn"><span class="fa fa-heart-o"></span></button>

                                        <?php
                                    } else {
                                        $modelexist = FavoriteJobs::find()->where(['job_id' => $model->id])->all();
                                        if (count($modelexist) > 0) {
                                            
                                        } else {
                                            ?>
                                            <form action="<?= Yii::getAlias('@frontendUrl') . '/jobseeker/user-profile/favjobs'; ?>" method="GET">
                                                <input type="hidden" name="jobid" value="<?= $model->id ?>">
                                                <button title="Add job to your favorites" type="submit" class="btn pxp-single-job-save-btn"><span class="fa fa-heart-o"></span></button>
                                            </form><?php
                                        }
                                    }
                                    ?>

                                    <?php
                                    if (Yii::$app->user->isGuest) {

                                        if ($model->apply_through_kora_flag == 0) {
                                            ?>
                                            <a href="#pxp-signin-modal" data-bs-toggle="modal" class="btn rounded-pill pxp-card-btn">Apply now</a>
                                            <?php
                                        }
                                    } else {
                                        if (Yii::$app->user->can('user')) {
                                            if ($model->apply_through_kora_flag == 0) {
                                                if (common\models\JsJobApplication::canApply($model->id)) {
                                                    ?>
                                                    <a href="<?= $model->link ?>" class="btn rounded-pill pxp-card-btn" target="_blank">Apply now</a>
                                                    <?php
                                                } else {
                                                    if (\common\models\User::isAJobSeeker(Yii::$app->user->identity->id)) {
                                                        ?>
                                                        &nbsp;&nbsp;&nbsp;<span style="color: green; font-weight: bold">Applied</span>
                                                        <?php
                                                    }
                                                }
                                            } else {
                                                if (common\models\JsJobApplication::alreadyApplied($model->id)) {
                                                    ?>
                                                    &nbsp;&nbsp;&nbsp;<span style="color: green; font-weight: bold">Applied</span>
                                                    <?php
                                                } else if (common\models\JsJobApplication::canApply($model->id)) {
                                                    if (intval(common\models\UserProfile::getProfileCompletionPercentage(Yii::$app->user->identity->id)) > 97) {
                                                        ?>
                                                        <a href="#application-modal" data-bs-toggle="modal" class="btn rounded-pill pxp-card-btn" onclick="set_selected_job(<?= $job->id; ?>)">Apply</a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="#incomplete-profile-modal" data-bs-toggle="modal" class="btn rounded-pill pxp-card-btn">Apply</a>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    &nbsp;&nbsp;
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 justify-content-between align-items-center">
                        <div class="col-6">
                            <a href="#" class="pxp-single-job-category">
                                <div class="pxp-single-job-category-icon"><span class="fa fa-bullhorn"></span></div>
                                <div class="pxp-single-job-category-label"><?php
                                    $grouping = SOccupationGrouping::findOne($model->occupation_grouping_id);
                                    if (isset($grouping)) {
                                        echo SOccupationGrouping::findOne($model->occupation_grouping_id)->occupation_grouping;
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?></div>
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="pxp-single-job-date pxp-text-light"><?php
                                echo 'Posted on: ' . $model->posting_date;
                                ?></div>
                        </div>
                    </div>

                    <div class="pxp-single-job-content-details mt-4">
                        <hr />

                        <div class="mt-4">
                            <h4>Description of main duties and responsibilities of the position</h4>
                            <p><?= $model->job_responsability; ?></p>
                        </div>

                        <div class="mt-4">
                            <h4>Required Skills</h4>
                            <?php
                            foreach ($requiredskills as $skillsrequired) {
                                ?>
                                <ul>
                                    <li><?= $skillsrequired['skill']; ?></li>
                                </ul>   
                                <?php
                            }
                            ?>

                        </div>
                        <div class="mt-4">
                            <h4>Education  Fields</h4>

                            <?php
                            foreach ($educationfields as $edfield) {
                                ?>
                                <ul>
                                    <li><?= $edfield['field']; ?></li>
                                </ul>   
                                <?php
                            }
                            ?>
                        </div>
                        <div class="mt-4">
                            <h4>How to Apply</h4>
                            <p><?= $model->how_to_apply ?></p> </div>
                        <?php
                        if (!empty($model->doc_path)) {
                            ?>
                            <div class="mt-4">
                                <h4>Document Attached</h4>
                                <a  target="_blank" href=<?= Yii::getAlias('@storageUrl') . '/source/1/' . $model->doc_path; ?>><img title="View Document" width="110px" height="120px" src="<?= Yii::getAlias('@staticUrl') . '/images/download.png'; ?>"></a> 
                            </div>
                        <?php } ?>


                    </div>
                </div>
                <div class="col-lg-5 col-xl-4 col-xxl-3">
                    <div class="pxp-single-job-side-panel mt-5 mt-lg-0">

                        <div>
                            <div class="pxp-single-job-side-info-label pxp-text-light" style="color:red; font-weight: bold">Application Deadline</div>
                            <div class="pxp-single-job-side-info-data" style="color:red; font-weight: bold"><?= $model->closure_date; ?></div>
                        </div>
                        <div class="mt-4">
                            <div class="pxp-single-job-side-info-label pxp-text-light">Experience</div>
                            <div class="pxp-single-job-side-info-data"><?= $model->years_of_experience; ?> Years</div>
                        </div>

                        <div class="mt-4">
                            <div class="pxp-single-job-side-info-label pxp-text-light">Contract Type</div>
                            <div class="pxp-single-job-side-info-data"><?php
                                $modeltype = SJobType::findOne($model->job_type_id);
                                if (!empty($modeltype)) {
                                    echo $modeltype['job_type'];
                                } else {
                                    echo'';
                                }
                                ?></div>
                        </div>
                        <div class="mt-4">
                            <div class="pxp-single-job-side-info-label pxp-text-light">Occupation Grouping</div>
                            <div class="pxp-single-job-side-info-data"><?php
                                if (isset($model->occupation_grouping_id)) {
                                    echo SOccupationGrouping::findOne($model->occupation_grouping_id)->occupation_grouping;
                                }
                                ?></div>
                        </div>
                        <div class="mt-4">
                            <div class="pxp-single-job-side-info-label pxp-text-light">Number of Position</div>
                            <div class="pxp-single-job-side-info-data"><?= (isset($model->positions_number)); ?></div>
                        </div>


                        <div class="mt-4">
                            <div class="pxp-single-job-side-info-label pxp-text-light">Education level</div>
                            <div class="pxp-single-job-side-info-data"><?php
                                if (!empty($level = SEducationLevel::findOne($model->education_level_id, null))) {
                                    echo $level->level;
                                } else {
                                    echo'';
                                };
                                ?></div>
                        </div>
                        <div class="mt-4">
                            <div class="pxp-single-job-side-info-label pxp-text-light">Required assessment(s)</div>
                            <div class="pxp-single-job-side-info-data"><?php
                                $existing_job_assessments = \common\models\JobAssessment::findByJobId($model->id);
                                if (count($existing_job_assessments) > 0) {
                                    $counter = 1;
                                    foreach ($existing_job_assessments as $current_assessment) {
                                        $assessment = \frontend\modules\hr\models\ApiAssessments::find()->where(['id' => $current_assessment['assessment_id']])->one();
                                        if ($counter == 1) {
                                            echo $counter . '. ' . $assessment->name;
                                        } else {
                                            echo '<br />' . $counter . '. ' . $assessment->name;
                                        }

                                        $counter++;
                                    }
                                } else {
                                    echo 'None';
                                }
                                ?></div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function remove(id, url, div) {
        if (confirm("Are you sure?.")) {
            $.ajax({
                type: "POST",
                url: "/jobseeker/" + url + "/delete?id=" + id,
                dataType: "json",
                success: function (data) {
                    $("#" + div).load(" #" + div);
                }
            });
        }
    }

    function search(idOtherProfile) {
        window.location.href = "/jobseeker/user-profile/index?idOtherProfile=" + idOtherProfile;
    }
</script>



