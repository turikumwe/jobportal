<?php

use kartik\typeahead\TypeaheadBasic;
use common\models\JsRecommendation;
use frontend\assets\FrontendAsset;
use trntv\filekit\widget\Upload;
use common\models\JsExperience;
use kartik\typeahead\Typeahead;
use kartik\widgets\SwitchInput;
use common\models\UserProfile;
use common\models\JsEducation;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\JsEndorse;
use common\models\JsAddress;
use common\models\JsSkill;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */
$userid = $idOtherProfile;
$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Profile');

$side = (Yii::$app->user->can('employer') || Yii::$app->user->can('mediator')) ? 'admin' : '';
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_navigation.php") ?>
</div>
<div class="pxp-dashboard-content">
    <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_top_header.php") ?>

    <div class="pxp-dashboard-content-details">
        <div class="pxp-single-company-container"  style="margin-top:0px;">
            <div class="row justify-content-center">
                <div class="col-xl-9" style="width:100%">
                    <div class="pxp-single-company-hero pxp-cover pxp-boxed" style="background-image: url(images/ph-big.jpg); height: 260px;">
                        <div class="pxp-hero-opacity"></div>
                        <div class="pxp-single-company-hero-caption">
                            <div class="pxp-single-company-hero-content d-block text-center">
                                <a   data-bs-toggle="<?= ($userid == Yii::$app->user->identity->id) ? 'modal' : '' ?>" href="#profile" style="text-decoration: none;" > 
                                    <?php
                                    $profilepic = common\models\UserProfile::findOne($userid);
                                    if (isset($profilepic) && strlen($profilepic->profile) > 0) {
                                        ?>
                                        <div title='Click to edit picture' class="pxp-single-company-hero-logo d-inline-block" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/<?php echo $profilepic->profile; ?>); width:128px; height:128px "  ></div>
                                        <?php
                                    } else {
                                        ?>
                                        <div title='Click to edit picture' class="pxp-single-company-hero-logo d-inline-block" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/profiles/noimage.png); width:128px; height:128px "  ></div>

                                    <?php }
                                    ?>
                                </a>
                                <div class="pxp-single-company-hero-title ms-0 mt-3">
                                    <h1><?php $fname = common\models\UserProfile::findOne($userid); ?>
                                        <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?>
                                        <?php $lname = common\models\UserProfile::findOne($userid); ?>
                                        <?= (isset($lname->lastname)) ? $lname->lastname : ''; ?>
                                    </h1>
                                    <div class="pxp-single-company-hero-location"><span class="fa fa-globe"></span><?php
                                        $addresses = $jobseeker->jsAddresses;
                                        foreach ($addresses as $address) {
                                            ?>  <?= isset($address->district->district) ? $address->district->district : '-' ?> ,
                                            <?= isset($address->geosector->sector) ? $address->geosector->sector : '-' ?> 
                                        <?php } ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 mt-lg-5">
                        <?php
                        if (Yii::$app->session->hasFlash('error')):
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <strong><i class="icon fa fa-close"></i>Error!</strong> <?= Yii::$app->session->getFlash('error') ?>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: red; font-weight: bold;">&times;</a>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success alert-dismissible">
                                <strong><i class="icon fa fa-check"></i>Success!</strong> <?= Yii::$app->session->getFlash('success') ?>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: green; font-weight: bold;">&times;</a>
                            </div>
                        <?php endif; ?>
                        <div class="col-lg-7 col-xxl-8">
                            <a data-bs-toggle="modal" href="#profile-completion-modal" role="button" onclick="return check_user_completion_percentage(<?= $idOtherProfile; ?>);">
                                <div class="progress position-relative" style="height: 30px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"  style="width:<?= UserProfile::getProfileCompletionPercentage($idOtherProfile) ?>%; height: 30px;">
                                        <span class="justify-content-center d-flex position-absolute w-100" style="font-size: 20px;"><?= ceil(UserProfile::getProfileCompletionPercentage($idOtherProfile)) ?>% completed</span>
                                    </div>
                                </div>
                            </a>

                            <div class="accordion pxp-faqs-accordion" id="pxpFAQsAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader9">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs9" aria-expanded="false" aria-controls="pxpCollapseFAQs9">
                                            Summary
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs9" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader89" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('summary.php'); ?>  </div>
                                    </div>
                                </div>              
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader8">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs8" aria-expanded="false" aria-controls="pxpCollapseFAQs8">
                                            Address
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs8" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader8" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('address.php'); ?>  </div>
                                    </div>
                                </div> 

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs3" aria-expanded="false" aria-controls="pxpCollapseFAQs3">
                                            Experience
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs3" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader3" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('experience.php'); ?>
                                        </div>
                                    </div>
                                </div>        
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs2" aria-expanded="false" aria-controls="pxpCollapseFAQs2">
                                            Skills
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs2" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader2" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('skills.php'); ?>    </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs1" aria-expanded="false" aria-controls="pxpCollapseFAQs1">
                                            Education
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs1" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader1" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('education.php'); ?>   </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs4" aria-expanded="false" aria-controls="pxpCollapseFAQs4">
                                            Trainings
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs4" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader4" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('training.php'); ?>     </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs10" aria-expanded="false" aria-controls="pxpCollapseFAQs10">
                                            Language
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs10" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader10" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('language.php'); ?>     </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs5" aria-expanded="false" aria-controls="pxpCollapseFAQs5">
                                            Driving License
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs5" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader5" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('drivinglicense.php'); ?>  </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader12">

                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs12" aria-expanded="false" aria-controls="pxpCollapseFAQs12">
                                            Assessments
                                        </button>

                                    </h2>
                                    <div id="pxpCollapseFAQs12" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader12" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php
                                            $user_assessments = frontend\modules\hr\models\ApiAssessmentCandidate::find()->where(['user_id' => $userid])->all();
                                            if (count($user_assessments) > 0) {
                                                ?>
                                                <table class="table table-hover table-bordered table-striped" style="background-color:#fff;color:#333;">
                                                    <thead>
                                                        <tr style="font-weight: bold;">
                                                            <th style="width: 50%">Assessment name </th>
                                                            <th style="width: 15%">Status </th>
                                                            <th style="width: 15%">Average score </th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        foreach ($user_assessments as $assessment) {
                                                            ?>
                                                            <tr>
                                                                <td><?= \frontend\modules\hr\models\ApiAssessments::find()->where(['id' => $assessment->assessment_id])->one()->name; ?></td>
                                                                <td><?= $assessment->status; ?> </td>
                                                                <td style="text-align: right; font-weight: bold;"><?= strlen($assessment->average) > 0 ? $assessment->average . ' %' : ''; ?></td>
                                                                <td>
                                                                    <div class="pxp-dashboard-table-options">
                                                                        <ul class="list-unstyled">
                                                                            <a href="<?php echo Yii::$app->link->frontendUrl('/hr/api/candidate-send-pdf-result?tt_id=' . $assessment->testtaker_id . '&c_id=' . $assessment->candidate_id . '') ?>"><li style="size: 40px;"><button class="action-button" title="Send results to candidate"><span class="fa fa-envelope-o"></span></button></li></a>
                                                                            <a href="<?php echo Yii::$app->link->frontendUrl('/hr/api/candidate-result-pdf?tt_id=' . $assessment->testtaker_id . '&c_id=' . $assessment->candidate_id . '') ?>" target="_blank"><li><button class="action-button" title="Download results"><span class="fa fa-download"></span></button></li></a>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>


                                                    </tbody>
                                                </table>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="pxp-jobs-card-3-date pxp-text-light" style="font-size: 30px;">
                                                    Not invited to any assessment
                                                </span>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader6">

                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs6" aria-expanded="false" aria-controls="pxpCollapseFAQs6">
                                            Endorsement
                                        </button>

                                    </h2>
                                    <div id="pxpCollapseFAQs6" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader6" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('endorse.php'); ?>    </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pxpFAQsHeader7">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs7" aria-expanded="false" aria-controls="pxpCollapseFAQs7">
                                            Recommendation
                                        </button>
                                    </h2>
                                    <div id="pxpCollapseFAQs7" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader7" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?php include('recommandation.php'); ?>  </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-5 col-xxl-4">
                            <div class="pxp-single-candidate-side-panel mt-5 mt-lg-0">
                                <table class='table table-responsive'>  
                                    <tr>
                                        <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta"><?php include('identification.php'); ?> </td>
                                    </tr>



                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<script>
    function remove(id, url, div) {

        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

        if (confirm("Are you sure?.")) {
            $.ajax({
                type: "POST",
                url: FRONTEND_BASE_URL + "/jobseeker/" + url + "/delete?id=" + id,
                dataType: "json",
                success: function (data) {
                    $("#" + div).load(" #" + div);
                }
            });
        }
    }

    function search(idOtherProfile) {

        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";
        window.location.href = FRONTEND_BASE_URL + "/jobseeker/user-profile/index?idOtherProfile=" + idOtherProfile;

        //window.history.pushState("Profile", "Title", "/jobseeker/user-profile/index?idOtherProfile="+idOtherProfile);
        //$("#search").load(" #search");
    }
</script>

<div class="modal fade pxp-user-modal" id="profile" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php include('profilepic.php'); ?> 

            </div>
        </div>
    </div>
</div>