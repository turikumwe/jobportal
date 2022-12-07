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
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php") ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_top_header.php") ?>
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
                                    <h1><?= isset($mediator->madiator_name) ? $mediator->madiator_name : '-'; ?><br />
                                        <?= $account_person->first_name . ' ' . $account_person->last_name ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-7 col-xxl-8">
                            <div class="pxp-single-company-content">
                                <div class="row justify-content-center">
                                    <div>
                                        <div class="accordion pxp-faqs-accordion" id="pxpFAQsAccordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="pxpFAQsHeader1">
                                                    <button class="accordion-button collapsed" type="button" style="color: var(--pxpMainColor);" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs1" aria-expanded="true" aria-controls="pxpCollapseFAQs1">
                                                        Institution identification
                                                    </button>
                                                </h2>
                                                <div id="pxpCollapseFAQs1" class="accordion-collapse collapse show" aria-labelledby="pxpFAQsHeader1" data-bs-parent="#pxpFAQsAccordion">
                                                    <div class="accordion-body">
                                                        <?php
                                                        include('identification.php');
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="pxpFAQsHeader2">
                                                    <button class="accordion-button collapsed" style="color: var(--pxpMainColor);" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs2" aria-expanded="false" aria-controls="pxpCollapseFAQs2">
                                                        Address and Contact
                                                    </button>
                                                </h2>
                                                <div id="pxpCollapseFAQs2" class="accordion-collapse collapse show" aria-labelledby="pxpFAQsHeader2" data-bs-parent="#pxpFAQsAccordion">
                                                    <div class="accordion-body">
                                                        <?php
                                                        include('address.php');
                                                        ?>
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
                                    <div class="pxp-single-company-side-info-label pxp-text-light">First name:</div>
                                    <div class="pxp-single-company-side-info-data"><?= $account_person->first_name ?></div>
                                </div>

                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Last name:</div>
                                    <div class="pxp-single-company-side-info-data"><?= $account_person->last_name ?></div>
                                </div>

                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Phone:</div>
                                    <div class="pxp-single-company-side-info-data"><?= $account_person->phone ?></div>
                                </div>

                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">Email:</div>
                                    <div class="pxp-single-company-side-info-data"><?= $account_person->email ?></div>
                                </div>

                                <div class="mt-4">
                                    <div class="pxp-single-company-side-info-label pxp-text-light">First name:</div>
                                    <div class="pxp-single-company-side-info-data"><?= $account_person->first_name ?></div>
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