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
    <div class="pxp-logo">
        <a href="index.html" class="pxp-animate"><img src="../../images/kora.png" width="82px" height='40px'></a>
    </div>


    <nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">

        <ul class="list-unstyled">
            <li ><a href="dashboard"><span class="fa fa-home"></span>Dashboard</a></li>
            <li class="pxp-active"><a href="#"><span class="fa fa-pencil"></span>My Profile</a></li>
            <li><a href="applications"><span class="fa fa-file-text-o"></span>Applications</a></li>
            <li><a href="jobs"><span class="fa fa-file-text-o"></span>Opportunities</a></li>
            <li><a href="favourites"><span class="fa fa-heart-o"></span>Favourite Jobs</a></li>
            <li><a href="candidate-dashboard-password.html"><span class="fa fa-lock"></span>Change Password</a></li>
        </ul>
        <div class="pxp-dashboard-side-label mt-3 mt-lg-4"><?php include("visibility.php") ?></div>

    </nav>


</div>
<div class="pxp-dashboard-content">
    <div class="pxp-dashboard-content-header pxp-is-candidate">
        <div class="pxp-nav-trigger navbar pxp-is-dashboard d-lg-none">
            <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                <div class="pxp-line-1"></div>
                <div class="pxp-line-2"></div>
                <div class="pxp-line-3"></div>
            </a>
            <div class="offcanvas offcanvas-start pxp-nav-mobile-container pxp-is-dashboard pxp-is-candidate" tabindex="-1" id="pxpMobileNav">
                <div class="offcanvas-header">
                    <div class="pxp-logo">
                        <a href="index.html" class="pxp-animate"><img src="../images/kora.png" width="82px" height='40px'></a>
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

            </div>
        </div>
        <nav class="pxp-user-nav pxp-on-light">
            <div class="dropdown pxp-user-nav-dropdown pxp-user-notifications">
                <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="fa fa-bell-o"></span>
                    <div class="pxp-user-notifications-counter">5</div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php
                    $conn = \Yii::$app->db;
                    $notification = 'select o.id,s.created_at,o.name,o.type from s_opportunity as o,s_notifications as s where s.user_id="' . Yii::$app->user->id . '" and s.opportunity_id=o.id';
                    $notiresult = $conn->createCommand($notification)->queryAll();
                    foreach ($notiresult as $notes) {
                        ?>
                        <li><a class="dropdown-item" href="#"><strong><?= $notes['name'] ?></strong> <?= $notes['type'] ?> <span class="pxp-is-time">Posted on <?= $notes['created_at'] ?></span></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="dropdown pxp-user-nav-dropdown">
                <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                    <div class="pxp-user-nav-name d-none d-md-block"><?= api\modules\v1\resources\User::findOne(Yii::$app->user->id)->username ?></div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="candidate-dashboard.html">Dashboard</a></li>
                    <li><a class="dropdown-item" href="update">Edit profile</a></li>
                    <li><a class="dropdown-item" href="../../user/sign-in/logout">Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <section>
        <div class="pxp-container">
            <div class="pxp-single-candidate-container">
                <div class="row justify-content-center">
                    <div class="col-xl-9">
                        <div class="pxp-single-candidate-hero pxp-cover pxp-boxed" style="background-image: url(images/ph-big.jpg);">
                            <div class="pxp-hero-opacity"></div>
                            <div class="pxp-single-candidate-hero-caption">
                                <div class="pxp-single-candidate-hero-content d-block text-center">
                                    <div class="pxp-single-candidate-hero-avatar d-inline-block" style="background-image: url(images/pro.jpg);"></div>
                                    <div class="pxp-single-candidate-hero-name ms-0 mt-3">
                                        <h1><?php $fname = common\models\UserProfile::findOne($userid); ?>
                                            <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?>
                                            <?php $lname = common\models\UserProfile::findOne($userid); ?>
                                            <?= (isset($lname->lastname)) ? $lname->lastname : ''; ?>
                                        </h1>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 mt-lg-5">
                            <div class="col-lg-7 col-xxl-8">
                                <div class="pxp-single-candidate-content">
                                    <h2>About <?php $fname = common\models\UserProfile::findOne($userid); ?>
                                        <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?></h2>


                                    <?php
                                    foreach ($summary as $summ) {
                                        ?>
                                        <p> <?= (isset($summ['professional_profile'])) ? $summ['professional_profile'] : ''; ?> </p><?php if (Yii::$app->user->can('user')) { ?> 
                                            <span class="badge rounded-pill"><a href="removeitem" onclick="document.test.action = encodeURIComponent(this.getAttribute('href')); document.forms['test'].submit(); return false;"><span class="fa fa-trash-o" title='Remove item'></span></a></span>
                                            <form method="get" action="removeitem" name="test">
                                                <input type='hidden' name='summaryid' value='<?= $summ['id']; ?>'> 
                                            </form>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="mt-4 mt-lg-5">
                                        <h2>Skills</h2>
                                        <div class="pxp-single-candidate-skills">
                                            <table><tr>
                                                <ul class="list-unstyled">
                                                    <?php foreach ($skills as $skill) { ?>
                                                        <li><?= (isset($skill['skill'])) ? $skill['skill'] : ''; ?>(<?= (isset($skill['level'])) ? $skill['level'] : ''; ?>)
                                                            <?php if (Yii::$app->user->can('user')) { ?> <span class="badge rounded-pill"><a href="removeitem=<?= $skill['id']; ?>" onclick="document.test.action = encodeURIComponent(this.getAttribute('href')); document.forms['test'].submit(); return false;"><span class="fa fa-trash-o" title='Remove item'></span></a></span>
                                                                <form method="get" action="removeitem" name="test">
                                                                    <input type='text' name='skillid' value='<?= $skill['id']; ?>'> 
                                                                </form><?php } ?>

                                                        </li>
                                                    <?php } ?>
                                                </ul></tr></table>
                                        </div>
                                    </div>

                                    <div class="mt-4 mt-lg-5">
                                        <h2>Work Experience</h2>
                                        <div class="pxp-single-candidate-timeline">
                                            <?php foreach ($experience as $exper) {
                                                ?>
                                                <div class="pxp-single-candidate-timeline-item">
                                                    <div class="pxp-single-candidate-timeline-dot"></div>
                                                    <div class="pxp-single-candidate-timeline-info ms-3">
                                                        <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'><?= (isset($exper['start_date'])) ? $exper['start_date'] : ''; ?> - <?= (isset($exper['end_date'])) ? $exper['end_date'] : ''; ?> </span></div>
                                                        <span class="badge rounded-pill">
                                                            <a href="removeitem" onclick="document.test.action = encodeURIComponent(this.getAttribute('href')); document.forms['test'].submit(); return false;"><span class="fa fa-trash-o" title='Remove item'></span></a></span>
                                                        <form method="get" action="removeitem" name="test">
                                                            <input type='hidden' name='experienceid' value='<?= $exper['id']; ?>'>  
                                                        </form>



                                                        <div class="pxp-single-candidate-timeline-position mt-2"> <?= (isset($exper['company'])) ? $exper['company'] : ''; ?></div>

                                                        <div class="pxp-single-candidate-timeline-about mt-2 pb-4"><?= (isset($exper['occupation'])) ? $exper['occupation'] : ''; ?> </div>
                                                    </div>
                                                </div>

                                            <?php } ?> 

                                        </div>
                                    </div>

                                    <div class="mt-4 mt-lg-5">
                                        <h2>Education  </h2>
                                        <div class="pxp-single-candidate-timeline">
                                            <?php foreach ($education as $jseducation) {
                                                ?>
                                                <div class="pxp-single-candidate-timeline-item">
                                                    <div class="pxp-single-candidate-timeline-dot"></div>
                                                    <div class="pxp-single-candidate-timeline-info ms-3">
                                                        <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'><?= (isset($jseducation['start_date'])) ? $jseducation['start_date'] : ''; ?> - <?= (isset($jseducation['end_date'])) ? $jseducation['end_date'] : ''; ?> </span>
                                                        </div><span class="badge rounded-pill"><a href="removeitem" onclick="document.test.action = encodeURIComponent(this.getAttribute('href')); document.forms['test'].submit(); return false;"><span class="fa fa-trash-o" title='Remove item'></span></a></span>
                                                        <form method="get" action="removeitem" name="test">
                                                            <input type='hidden' name='educationid' value='<?= $jseducation['id']; ?>'> 
                                                        </form>
                                                        <div class="pxp-single-candidate-timeline-position mt-2"> <?= (isset($jseducation['field'])) ? $jseducation['field'] : ''; ?></div>
                                                        <div class="pxp-single-candidate-timeline-about mt-2 pb-4"> <?= (isset($jseducation['school'])) ? $jseducation['school'] : ''; ?></div>

                                                        <div class="pxp-single-candidate-timeline-about mt-2 pb-4"><?= (isset($jseducation['exact_quali'])) ? $jseducation['exact_quali'] : ''; ?> </div>
                                                    </div>
                                                </div>

                                            <?php } ?> 

                                        </div>
                                    </div>
                                    <div class="mt-4 mt-lg-5">
                                        <h2>Trainings  </h2>
                                        <div class="pxp-single-candidate-timeline">
                                            <?php
                                            foreach ($trainings as $train) {
                                                ?>
                                                <div class="pxp-single-candidate-timeline-item">
                                                    <div class="pxp-single-candidate-timeline-dot"></div>
                                                    <div class="pxp-single-candidate-timeline-info ms-3">
                                                        <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'><?= (isset($train['start_date'])) ? $train['start_date'] : ''; ?> - <?= (isset($train['end_date'])) ? $train['end_date'] : ''; ?> </span>
                                                        </div><span class="badge rounded-pill"><a href="removeitem" onclick="document.test.action = encodeURIComponent(this.getAttribute('href')); document.forms['test'].submit(); return false;"><span class="fa fa-trash-o" title='Remove item'></span></a></span>
                                                        <form method="get" action="removeitem" name="test">
                                                            <input type='hidden' name='trainingid' value='<?= $train['id']; ?>'> 
                                                        </form>
                                                        <div class="pxp-single-candidate-timeline-position mt-2"> <?= (isset($train['training_title'])) ? $train['training_title'] : ''; ?></div>
                                                        <div class="pxp-single-candidate-timeline-about mt-2 pb-4"> <?= (isset($train['training_center'])) ? $train['training_center'] : ''; ?></div>

                                                    </div>
                                                </div>

                                            <?php } ?> 

                                        </div>
                                    </div>
                                    <div class="mt-4 mt-lg-5">
                                        <h2>Languages  </h2>
                                        <div class="pxp-single-candidate-timeline">
                                            <?php
                                            $language = common\models\JsLanguage::find()->where(['user_id' => $userid])->all();
                                            foreach ($language as $langues) {
                                                ?>
                                                <div class="pxp-single-candidate-timeline-item">
                                                    <div class="pxp-single-candidate-timeline-dot"></div>
                                                    <div class="pxp-single-candidate-timeline-info ms-3">
                                                        <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'><?= \backend\models\SLanguage::findOne($langues['language'])->language; ?> </span>


                                                        </div><span class="badge rounded-pill"><a href="removeitem" onclick="document.test.action = encodeURIComponent(this.getAttribute('href')); document.forms['test'].submit(); return false;"><span class="fa fa-trash-o" title='Remove item'></span></a></span>
                                                        <form method="get" action="removeitem" name="test">
                                                            <input type='hidden' name='languageid' value='<?= $langues['id']; ?>'> 
                                                        </form>
                                                        <div class="pxp-single-candidate-timeline-about mt-2 pb-4"><ul class="list-unstyled"> <li>Reading <span class="badge rounded-pill bg-success"><?= \backend\models\SLanguageRating::findOne($langues['reading'])->languagerate; ?></span></li>
                                                                <li>Writing <span class="badge rounded-pill bg-success"><?= \backend\models\SLanguageRating::findOne($langues['writing'])->languagerate; ?></span></li>
                                                                <li>Listening <span class="badge rounded-pill bg-success"><?= \backend\models\SLanguageRating::findOne($langues['listening'])->languagerate; ?></span></li>
                                                                <li>Speaking <span class="badge rounded-pill bg-success"><?= \backend\models\SLanguageRating::findOne($langues['speaking'])->languagerate; ?></span></li>
                                                            </ul></div>

                                                    </div>
                                                </div>

                                            <?php } ?> 

                                        </div>
                                    </div>
                                    <div class="mt-4 mt-lg-5">
                                        <h2>Endorsement  </h2>
                                        <div class="pxp-single-candidate-timeline">
                                            <?php
                                            $Endorse = JsEndorse::find()->where(['user_id' => $userid])->all();
                                            foreach ($Endorse as $endorsement) {
                                                ?>
                                                <div class="pxp-single-candidate-timeline-item">
                                                    <div class="pxp-single-candidate-timeline-dot"></div>
                                                    <div class="pxp-single-candidate-timeline-info ms-3">
                                                        <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'>Skill : <?php $skillendor = backend\models\SSkill::findOne($endorsement['skill_id']); ?><?= (isset($skillendor->skill)) ? $skillendor->skill : ''; ?> </span>
                                                        </div><span class="badge rounded-pill"><a href="removeitem" onclick="document.test.action = encodeURIComponent(this.getAttribute('href')); document.forms['test'].submit(); return false;"><span class="fa fa-trash-o" title='Remove item'></span></a></span>
                                                        <form method="get" action="removeitem" name="test">
                                                            <input type='hidden' name='endorsementid' value='<?= $endorsement['id']; ?>'> 
                                                        </form>
                                                        <div class="pxp-single-candidate-timeline-position mt-2"> Endorsed by: <?php $whoendo = mdm\admin\models\searchs\User::findOne($endorsement['who_endorsed_id']); ?><?= (isset($whoendo->username)) ? $whoendo->username : ''; ?></div>


                                                    </div>
                                                </div>

                                            <?php } ?> 

                                        </div>
                                    </div>
                                    <div class="mt-4 mt-lg-5">
                                        <h2>Recommendation</h2>

                                        <?php
                                        $recommendation = JsRecommendation::find()->where(['user_id' => $userid])->all();
                                        foreach ($recommendation as $recommended) {
                                            ?>
                                            <div class="pxp-single-candidate-timeline-item">
                                                <div class="pxp-single-candidate-timeline-dot"></div>
                                                <div class="pxp-single-candidate-timeline-info ms-3">
                                                    <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'>Recommended by : <?php $recomm = mdm\admin\models\searchs\User::findOne($recommended['who_recommended_id']); ?><?= (isset($recomm['username'])) ? $recomm['username'] : ''; ?>  </span>
                                                    </div><span class="badge rounded-pill"><a href="removeitem" onclick="document.test.action = encodeURIComponent(this.getAttribute('href')); document.forms['test'].submit(); return false;"><span class="fa fa-trash-o" title='Remove item'></span></a></span>
                                                    <form method="get" action="removeitem" name="test">
                                                        <input type='hidden' name='recommendationid' value='<?= $recommended['id']; ?>'> 
                                                    </form>
                                                    <div class="pxp-single-candidate-timeline-position mt-2"> Recommendation: <?= (isset($recommended->recommendation)) ? $recommended->recommendation : ''; ?></div>


                                                </div>
                                            </div><?php } ?>
                                        </table> 


                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-xxl-4">
                                <div class="pxp-single-candidate-side-panel mt-5 mt-lg-0">
                                    <table class='table table-responsive'>  
                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Names</div> <?php $fname = common\models\UserProfile::findOne($userid); ?>
                                                <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?>
                                                <?php $lname = common\models\UserProfile::findOne($userid); ?>
                                                <?= (isset($lname->lastname)) ? $lname->lastname : ''; ?> </td>
                                        </tr>
                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Email </div><?php $email = common\models\User::findone($userid) ?> <?= (isset($email->email)) ? $email->email : ''; ?></td>

                                        </tr>
                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Phone </div><?php $phone = common\models\User::findone($userid) ?><?= (isset($phone->phone)) ? $phone->phone : ''; ?></td></tr>
                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Gender </div><?php
                                                $gender = \common\models\UserProfile::findOne($userid)->gender;
                                                $ge = common\models\SGender::findone($gender);
                                                ?><?= (isset($ge->gender)) ? $ge->gender : ''; ?> </td>

                                        </tr>
                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Martial Status </div><?php
                                                $mstatus = \common\models\UserProfile::findOne($userid)->marital_status;
                                                $martial = \backend\models\SMaritalStatus::findOne($mstatus);
                                                ?><?= (isset($martial->status)) ? $martial->status : ''; ?></td></tr>

                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Birthday </div><?php $dob = \common\models\UserProfile::findOne($userid) ?><?= (isset($dob->dob)) ? $dob->dob : ''; ?></td>
                                            <td>  </td>

                                        </tr>
                                        <?php
                                        $address = JsAddress::find()->where(['user_id' => $userid])->all();
                                        foreach ($address as $addresses) {
                                            ?>
                                            <tr><td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Province</div><?php
                                                    $pro = backend\models\SDistrict::findOne($addresses['district_id'])->province_id;
                                                    $prov = backend\models\SProvince::findOne($pro);
                                                    ?><?= (isset($prov->province)) ? $prov->province : ''; ?></td></tr>
                                            <tr>
                                                <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">District</div> <?php $distr = backend\models\SDistrict::findOne($addresses['district_id']); ?><?= (isset($distr->district)) ? $distr->district : ''; ?></td></tr>
                                            <tr>
                                                <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Sector</div> <?php $sector = backend\models\SGeosector::findone($addresses['sector_id']); ?><?= (isset($sector->sector)) ? $sector->sector : ''; ?></td>


                                            </tr> 
                                        <?php } ?>
                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Country </div><?php
                                                $country = \common\models\UserProfile::findOne($userid)->nationality;
                                                $pays = backend\models\SCountrycodeIso3166::findOne($country);
                                                ?><?= (isset($pays->cc_description)) ? $pays->cc_description : ''; ?>  </td>

                                        </tr>
                                    </table>
                                </div>

                                <div class="pxp-single-candidate-side-panel mt-4 mt-lg-5">
                                    <h3>Contact <?php $fname = common\models\UserProfile::findOne($userid); ?>
                                        <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?></h3>
                                    <form class="mt-4">
                                        <div class="mb-3">
                                            <label for="contact-candidate-name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="contact-candidate-name" placeholder="Enter your name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="contact-candidate-email" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="contact-candidate-email" placeholder="Enter your email address">
                                        </div>
                                        <div class="mb-3">
                                            <label for="contact-candidate-message" class="form-label">Message</label>
                                            <textarea class="form-control" id="contact-candidate-message" placeholder="Type your message here..."></textarea>
                                        </div>
                                        <a href="#" class="btn rounded-pill pxp-section-cta d-block">Send Message</a>
                                    </form>
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
<div class="modal fade pxp-user-modal" id="logoupdate" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <h4>Update Picture</h4><br>
                <form action='logoupdate' class="form-horizontal form-label-left input_mask" method="get" id="add" name="add" enctype="multipart/form-data">
                    <div class="form-group"" >
                        <div class="col-md-9 col-sm-9 col-xs-12"  style="float: left; width:70px;">
                            <input type="file" name="uploadImage" id="uploadImage">
                        </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <button id="save_data" type="submit" class="btn btn-success">Save</button>
                    </div></form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade pxp-user-modal" id="experience" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <h4>Add new Experience</h4><br>
                <form action='newitem' class="form-horizontal form-label-left input_mask" method="get" id="add" name="add" enctype="multipart/form-data">
                    <div class="form-group"" >
                        <div class="col-md-9 col-sm-9 col-xs-12"  style="float: left; width:70px;">
                            <?= include('experience.php'); ?>
                        </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <button id="save_data" type="submit" class="btn btn-success">Save</button>
                    </div></form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade pxp-user-modal" id="skills" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <h4>Add new Skill</h4><br>
                <form action='newitem' class="form-horizontal form-label-left input_mask" method="get" id="add" name="add" enctype="multipart/form-data">
                    <div class="form-group"" >
                        <div class="col-md-9 col-sm-9 col-xs-12"  style="float: left; width:70px;">
                            <input type="file" name="uploadImage" id="uploadImage">
                        </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <button id="save_data" type="submit" class="btn btn-success">Save</button>
                    </div></form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade pxp-user-modal" id="summary" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <h4>Add new summary</h4><br>
                <form action='newitem' class="form-horizontal form-label-left input_mask" method="get" id="add" name="add" enctype="multipart/form-data">
                    <div class="form-group"" >
                        <div class="col-md-9 col-sm-9 col-xs-12"  style="float: left; width:70px;">
                        </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <button id="save_data" type="submit" class="btn btn-success">Save</button>
                    </div></form>

            </div>
        </div>
    </div>
</div>