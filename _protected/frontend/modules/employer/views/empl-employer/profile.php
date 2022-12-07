<?php

use kartik\typeahead\TypeaheadBasic;
use frontend\assets\FrontendAsset;
use common\models\EmplEmployer;
use trntv\filekit\widget\Upload;
use kartik\typeahead\Typeahead;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Service Job');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});";

$this->registerJs($search);

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */
$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Profile');
$admin = (isset($_GET['visitor'])) ? "admin" : "";
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php") ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <div class="pxp-single-company-container"  style="margin-top:0px;">
            <div class="row justify-content-center">
                <div class="col-xl-9" style="width:100%">
                    <div class="pxp-single-company-hero pxp-cover pxp-boxed" style="background-image: url(images/ph-big.jpg); height: 260px;">
                        <div class="pxp-hero-opacity"></div>
                        <div class="pxp-single-company-hero-caption">
                            <div class="pxp-single-company-hero-content d-block text-center">
                                <div class="pxp-single-company-hero-logo d-inline-block" style="background-image: url(images/company-logo-3.png);"></div>
                                <div class="pxp-single-company-hero-title ms-0 mt-3">
                                    <h1><?= $employer->employerProfile->company_name; ?><br />
                                        (<?= $employer->employerProfile->company_name_abbraviatio; ?>)</h1>
                                    <div class="pxp-single-company-hero-location"><span class="fa fa-globe"></span><?= (isset($employer->employerProfile->employerType->type)) ? $employer->employerProfile->employerType->type : '-'; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-7 col-xxl-8">
                            <div class="pxp-single-company-content">
                                <h2>About <?= $employer->employerProfile->company_name; ?></h2>
                                <p><span style="color: red;"><b>Pending Implementation</b></span>Illuminate Studio, Inc. is an American multinational corporation that is engaged in the design, development, manufacturing, and worldwide marketing and sales of footwear, apparel, equipment, accessories, and services.</p>
                                <p>The company is headquartered near Beaverton, Oregon, in the Portland metropolitan area.[3] It is the world's largest supplier of athletic shoes and apparel and a major manufacturer of sports equipment, with revenue in excess of US$37.4 billion in its fiscal year 2020 (ending May 31, 2020).[4] As of 2020, it employed 76,700 people worldwide.[5] In 2020 the brand alone was valued in excess of $32 billion, making it the most valuable brand among sports businesses.[6] Previously, in 2017, the Illuminate Studio brand was valued at $29.6 billion.[7] Illuminate Studio ranked 89th in the 2018 Fortune 500 list of the largest United States corporations by total revenue.[8]</p>

                                <div class="row justify-content-center">
                                    <div>
                                        <div class="accordion pxp-faqs-accordion" id="pxpFAQsAccordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="pxpFAQsHeader1">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs1" aria-expanded="true" aria-controls="pxpCollapseFAQs1">
                                                        Summary
                                                    </button>
                                                </h2>
                                                <div id="pxpCollapseFAQs1" class="accordion-collapse collapse show" aria-labelledby="pxpFAQsHeader1" data-bs-parent="#pxpFAQsAccordion">
                                                    <div class="accordion-body">
                                                        <?php include('summary.php'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="pxpFAQsHeader2">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs2" aria-expanded="false" aria-controls="pxpCollapseFAQs2">
                                                        Address and Contact
                                                    </button>
                                                </h2>
                                                <div id="pxpCollapseFAQs2" class="accordion-collapse collapse show" aria-labelledby="pxpFAQsHeader2" data-bs-parent="#pxpFAQsAccordion">
                                                    <div class="accordion-body">
                                                        <?php include('address.php'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="pxpFAQsHeader3">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs3" aria-expanded="false" aria-controls="pxpCollapseFAQs3">
                                                        Economic Sector
                                                    </button>
                                                </h2>
                                                <div id="pxpCollapseFAQs3" class="accordion-collapse collapse show" aria-labelledby="pxpFAQsHeader3" data-bs-parent="#pxpFAQsAccordion">
                                                    <div class="accordion-body">
                                                        <?php include('economic_sector.php'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="pxpFAQsHeader4">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs4" aria-expanded="false" aria-controls="pxpCollapseFAQs4">
                                                        Status
                                                    </button>
                                                </h2>
                                                <div id="pxpCollapseFAQs4" class="accordion-collapse collapse show" aria-labelledby="pxpFAQsHeader4" data-bs-parent="#pxpFAQsAccordion">
                                                    <div class="accordion-body">
                                                        <?php include('status.php'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="pxpFAQsHeader5">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs5" aria-expanded="false" aria-controls="pxpCollapseFAQs5">
                                                        Manager
                                                    </button>
                                                </h2>
                                                <div id="pxpCollapseFAQs5" class="accordion-collapse collapse show" aria-labelledby="pxpFAQsHeader5" data-bs-parent="#pxpFAQsAccordion">
                                                    <div class="accordion-body">
                                                        <?php include('manager.php'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-5 col-xxl-4">
                            <div class="pxp-single-company-side-panel mt-5 mt-lg-0">
                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">TIN:</div>
                                    <div class="pxp-single-company-side-info-data"><?= $employer->employerProfile->tin ?></div>
                                </div>
                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Opening Date:</div>
                                    <div class="pxp-single-company-side-info-data"><?= date('M d,Y', strtotime($employer->employerProfile->opening_date)); ?></div>
                                </div>
                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Employer Type :</div>
                                    <div class="pxp-single-company-side-info-data"><?= (isset($employer->employerProfile->employerType->type)) ? $employer->employerProfile->employerType->type : '-'; ?></div>
                                </div>
                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Email</div>
                                    <div class="pxp-single-company-side-info-data"><?= $employer->email; ?></div>
                                </div>
                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Phone</div>
                                    <div class="pxp-single-company-side-info-data"><?= $employer->phone; ?></div>
                                </div>
                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Location</div>
                                    <div class="pxp-single-company-side-info-data"><span style="color: red;"><b>Pending</b></span></div>
                                </div>
                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Website</div>
                                    <div class="pxp-single-company-side-info-data"><a href="#"><span style="color: red;"><b>Pending</b></span></a></div>
                                </div>
                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-data">
                                        <ul class="list-unstyled pxp-single-company-side-info-social">
                                            <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                                            <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                                            <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                                            <li><a href="#"><span class="fa fa-linkedin"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="pxp-single-company-side-panel mt-3 mt-lg-4">
                                <h3>Contact Company</h3>
                                <form class="mt-4">
                                    <div class="mb-3">
                                        <label for="contact-company-name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="contact-company-name" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact-company-email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="contact-company-email" placeholder="Enter your email address">
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact-company-message" class="form-label">Message</label>
                                        <textarea class="form-control" id="contact-company-message" placeholder="Type your message here..."></textarea>
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
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>

<script>
    function remove(id, url, div) {
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";
        if (confirm("Are you sure?.")) {
            $.ajax({
                type: "POST",
                url: FRONTEND_BASE_URL + "/employer/" + url + "/delete?id=" + id,
                dataType: "json",
                success: function (data) {
                    $("#" + div).load(" #" + div);
                }
            });
        }
    }

    function searchEmployer(idOtherProfile) {
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";
        window.location.href = FRONTEND_BASE_URL + "/employer/empl-employer/index?idOtherProfile=" + idOtherProfile;
    }
</script>