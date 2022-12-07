<?php

use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\SOccupationGrouping;
use common\models\JsSavedEvent;
use frontend\modules\service\models\search\ServiceJobSearch;
use \yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<style>
    .howapply-wrp .howapply__cont .howapply__xpla li {
        list-style-type: initial;
        margin-left: 15px;
    }
</style>
<?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
<section class="pxp-page-header-simple">
    <div class="pxp-container">
        <h1>Search events</h1>
        <div class="pxp-hero-subtitle pxp-text-light">Search in <strong><?= $event_count; ?></strong> active events</div>

        <div class="pxp-hero-form pxp-hero-form-round pxp-large pxp-has-border mt-3 mt-lg-4">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'row gx-3 align-items-center'], 'id' => 'event_search', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-event')]); ?>
            <div class="col-12 col-lg">
                <div class="input-group mb-3 mb-lg-0">
                    <span class="input-group-text"><span class="fa fa-search"></span></span>
                    <input type="text" class="form-control" placeholder="Event Title" name="title">
                </div>
            </div>
            <div class="col-12 col-lg pxp-has-left-border">
                <div class="input-group mb-3 mb-lg-0">
                    <span class="input-group-text"><span class="fa fa-globe"></span></span>
                    <select class="form-select" name="location">
                        <option value="0">Location</option>
                        <?php
                        $districts = backend\models\SDistrict::find()->asArray()->all();
                        if (count($districts) > 0) {
                            foreach ($districts as $district) {
                                ?>
                                <option value="<?= $district['id'] ?>" <?= ($location == $district['id']) ? 'selected' : '' ?>><?= $district['district'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-12 col-lg-auto">
                <button>Find events</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
<section class="mt-4" style="background-color: var(--pxpSecondaryColorLight);">
    <div class="pxp-container">
        <div class="pxp-jobs-list-top">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h2><span class="pxp-text-light">Showing</span> <?= $event_count; ?> <span class="pxp-text-light">events</span></h2>
                </div>
                <div class="col-auto">
                    <?php $form = ActiveForm::begin(['id' => 'sort_by', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-event')]); ?>
                    <select class="form-select" id="sort" name="sort" onchange="sort_by_selected();">
                        <?php
                        if (count($sorting) > 0) {
                            foreach ($sorting as $key => $value) {
                                ?>
                                <option value="<?= $key; ?>" <?= ($key == $selected_sorting) ? 'selected' : ''; ?>><?= $value; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            if (count($events) > 0) {
                foreach ($events as $key => $event) {
                    ?>
                    <div class="col-md-6 col-xl-4 col-xxl-6 pxp-jobs-card-1-container">
                        <div class="pxp-jobs-card-1 pxp-has-shadow">
                            <div class="pxp-jobs-card-1-top">
                                <a href="<?= Yii::$app->link->frontendUrl('/service/service-event/view?id=' . $event->id) ?>" class="pxp-jobs-card-1-category">
                                    <div class="pxp-jobs-card-1-category-icon"><span class="fa fa-bullhorn"></span></div>
                                    <div class="pxp-jobs-card-1-category-label" style="font-size:18px;font-weight:bold"><?= $event->event_title; ?></div>
                                </a>
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-6 col-xl-4 col-xxl-3">
                                        <span style="font-size:18px;font-weight:bold;">Start date</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-3">
                                        <?= $event->start_date ?>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-3">
                                        <span style="font-size:18px;font-weight:bold;">End date</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-3">
                                        <?= $event->end_date ?>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-6 col-xl-4 col-xxl-2">
                                        <span style="font-size:18px;font-weight:bold;">Location</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <a href="#" class="pxp-jobs-card-1-location">
                                            <span class="fa fa-globe"></span><?php
                                            $event_sector = \backend\models\SGeosector::findOne($event->location);
                                            if (isset($event_sector)) {
                                                $sector_district = \backend\models\SDistrict::findOne($event_sector->district_id);
                                                if (isset($sector_district)) {
                                                    echo $sector_district->district . ', ' . $event_sector->sector;
                                                }
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-2">
                                        <span style="font-size:18px;font-weight:bold;">Venue</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <a href="#" class="pxp-jobs-card-1-location">
                                            <?= $event->venue ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-6 col-xl-4 col-xxl-6">
                                        <span style="font-size:18px;font-weight:bold;">Number of participants:</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-3">
                                        58
                                    </div>
                                </div>
                            </div>
                            <div class="pxp-jobs-card-1-bottom" style="margin-top: 10px;">
                                <div class="pxp-jobs-card-1-bottom-left">
                                    <a href="#" class="pxp-jobs-card-1-company">Application deadline</a>
                                    <div class="pxp-jobs-card-1-date pxp-text-light"><span style="color: green; font-weight: bold"><?= $event->closure_date ?></span> - <?= ceil((abs(strtotime(date("Y-m-d")) - strtotime($event->closure_date)) / (60 * 60 * 24))) ?> days remaining</div>
                                </div>
                                <div class="pxp-single-job-options mt-4 col-xl-0">
                                    <?php
                                    if (!Yii::$app->user->isGuest) {
                                        $class = 'btn pxp-single-job-save-btn';
                                    } else {
                                        $class = 'btn pxp-single-job-save-btn login-required';
                                    }

                                    if (!Yii::$app->user->isGuest) {
                                        if (\common\models\User::isAJobSeeker(Yii::$app->user->identity->id)) {
                                            if (!Yii::$app->user->isGuest) {
                                                if (JsSavedEvent::isSaved($event->id, Yii::$app->user->identity->id)) {
                                                    $class .= ' disabled';
                                                }
                                            }
                                            ?>
                                            <?php
                                            Modal::begin([
                                                'header' => 'Save:' . $event->event_title,
                                                "class" => "vd_sm-red",
                                                'toggleButton' => [
                                                    'class' => $class,
                                                    'label' => '<i class="fa fa-save" aria-hidden="true"></i>'
                                                ],
                                                    //'footer'=> ''
                                            ]);
                                            $request = \Yii::$app->request;
                                            echo $this->render('opportunity/_save', [
                                                'model' => new \common\models\JsSavedEvent(),
                                                'get' => $event,
                                                'opportunity' => $event->opportunity->id
                                            ]);
                                            Modal::end();
                                        } else {
                                            //Don't display anything
                                        }
                                    } else {
                                        echo '<button type="button" class="btn pxp-single-job-save-btn login-required"><i class="fa fa-save" aria-hidden="true"></i></button>';
                                    }
                                    ?>
                                    <div class="dropdown ms-2">
                                        <?php
                                        if (!Yii::$app->user->isGuest) {
                                            $class_share = 'btn pxp-single-job-share-btn dropdown-toggle';
                                        } else {
                                            $class_share = 'btn pxp-single-job-share-btn dropdown-toggle login-required';
                                        }
                                        if (!Yii::$app->user->isGuest) {
                                            if (\common\models\User::isAJobSeeker(Yii::$app->user->identity->id)) {
                                                Modal::begin([
                                                    'header' => 'Share:' . $event->event_title,
                                                    "class" => "vd_bg-red",
                                                    'toggleButton' => [
                                                        'class' => $class_share,
                                                        'label' => '<i class="fa fa-share-alt" aria-hidden="true"></i>'
                                                    ],
                                                    'footer' => ''
                                                ]);
                                                $request = \Yii::$app->request;
                                                echo $this->render('opportunity/_share', [
                                                    'model' => new \common\models\ServiceEventSharing(),
                                                    'get' => $event,
                                                    'opportunity' => $event->opportunity->id
                                                ]);
                                                Modal::end();
                                            }
                                        } else {
                                            echo '<button type="button" class="btn pxp-single-job-share-btn dropdown-toggle login-required"><i class="fa fa-share-alt" aria-hidden="true"></i></button>';
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if (Yii::$app->user->isGuest) {
                                            if ($event->apply_through_kora_flag == 1) {
                                                ?>
                                                <a href="#pxp-signin-modal" data-bs-toggle="modal" class="btn rounded-pill pxp-card-btn">Apply now</a>
                                                <?php
                                            }
                                    } else {
                                        if (Yii::$app->user->can('user')) {
                                            if (common\models\JsEventApplication::canApply($event->id)) {
                                                ?>
                                                <?php
                                                Modal::begin([
                                                    'header' => 'Apply Now:' . $event->event_title,
                                                    "class" => "vd_bg-red",
                                                    'toggleButton' => [
                                                        'class' => 'btn ms-2 pxp-single-job-apply-btn rounded-pill',
                                                        'label' => 'Apply Now <i class="glyphicon glyphicon-apply" aria-hidden="true"></i>'
                                                    ],
                                                    'footer' => ''
                                                ]);
                                                $request = \Yii::$app->request;
                                                echo $this->render('opportunity/_apply', [
                                                    'model' => $apply,
                                                    'get' => $event,
                                                    'opportunity' => $event->opportunity->id
                                                ]);
                                                Modal::end();
                                                ?>
                                                <?php
                                            } else {
                                                ?>
                                                &nbsp;&nbsp;&nbsp;<span style="color: green; font-weight: bold">Applied</span>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>

                                </div>


                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <div class="row mt-4 justify-content-between align-items-center">
            <div class="col-auto">
                <nav class="mt-3 mt-sm-0" aria-label="Jobs list pagination">
                    <?php
                    echo CustomLinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                    ?>
                </nav>
            </div>

        </div>
    </div>
</section>

<script type="text/javascript">
    function sort_by_selected() {
        $('#sort_by').submit();
    }
    $(".login-required").click(function () {
        alert("Please login to complete action")
    });
</script>
