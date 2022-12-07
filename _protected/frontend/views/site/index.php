<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\service\models\search\ServiceJobSearch;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use common\models\SOccupationGrouping;
use yii\helpers\ArrayHelper;

$model = new ServiceJobSearch();
?>

<?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
<section class="pxp-hero vh-50" style="background-color: var(--pxpMainColorLight); height:450px">
    <div class="pxp-hero-caption">
        <div class="pxp-container">
            <div class="row pxp-pl-80 align-items-center justify-content-between">
                <div class="col-12 col-xl-6 col-xxl-5">
                    <h1>Muraho,<br><span style="color: var(--pxpMainColor);"></h1>
                    <div class="pxp-hero-subtitle mt-3 mt-lg-4">My name is Kora and I am a job agent,
                        how about you? </div>

                    <div class="pxp-hero-form pxp-hero-form-round mt-3 mt-lg-4">
                        <?php $form = ActiveForm::begin(['options' => ['class' => 'row gx-3 align-items-center'], 'id' => 'job_search', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-job')]); ?>
                        <form class="row gx-3 align-items-center" action="#">
                            <div class="col-12 col-sm">
                                <div class="mb-3 mb-sm-0">
                                    <input type="text" class="form-control" placeholder="Job Title or Keyword" name="title">
                                </div>
                            </div>
                            <div class="col-12 col-sm pxp-has-left-border">
                                <div class="input-group mb-3 mb-lg-0">
                                    <span class="input-group-text"><span class="fa fa-folder-o"></span></span>
                                    <select class="form-select" name="category">
                                        <option value="0">All job categories</option>
                                        <?php
                                        $job_categories = \common\models\SOccupationGrouping::find()->asArray()->all();
                                        if (count($job_categories) > 0) {
                                            foreach ($job_categories as $category) {
                                                ?>
                                                <option value="<?= $category['id'] ?>" ><?= $category['occupation_grouping'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-auto">
                                <button><span class="fa fa-search"></span></button>
                            </div>
                        </form>
                        <?php ActiveForm::end(); ?>
                    </div>


                </div>
                <div class="d-none d-xl-block col-xl-5 position-relative">
                    <div  class="pxp-hero-cards-container pxp-animate-cards pxp-mouse-move" data-speed="160">
                        <div  class="pxp-hero-card pxp-cover pxp-cover-top" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/images/slide.png); min-height: 320px"></div>
                        <div class="pxp-hero-card-dark"></div>
                        <div class="pxp-hero-card-light"></div>
                    </div>
                    <div class="pxp-hero-card-info-container pxp-mouse-move" data-speed="60">
                        <div class="pxp-hero-card-info pxp-animate-bounce">
                            <?php foreach ($jobs as $key => $job) { ?>
                                <?php
                                if (!in_array($job->occupation_grouping_id, array(7, 13, 8, 10))) {
                                    $grouping = SOccupationGrouping::findOne($job->occupation_grouping_id);
                                    ?>
                                    <div class="pxp-hero-card-info-item">
                                        <a href="service/service-job?category=<?= $grouping->occupation_grouping ?>"><div class="pxp-hero-card-info-item-number"><?= $job->id ?><span>job offers</span></div></a>
                                        <div class="pxp-hero-card-info-item-description"><?= $grouping->occupation_grouping ?></div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mt-100">
    <div class="pxp-container">
        <h2 class="pxp-section-h2 text-center">Opportunities</h2>
        <p class="pxp-text-light text-center">Welcome to the Kora jobportal. The Kora jobportal is a matching platform established by the Rwanda 
            Development Board with the aim of linking jobseekers with potential employers. On this portal, you will find different jobs, 
            internships and training opportunities as well as information on Career Guidance and the National Employment Programme (NEP Kora Wigire).
            The Kora jobportal is also a client management tool for the Public Employment Service Centres. </p>

        <div class="row mt-4 mt-md-5 pxp-animate-in pxp-animate-in-top">
            <?php foreach ($jobs as $key => $job) { ?>
                <?php
                if ($job->occupation_grouping_id == '')
                    $job->occupation_grouping_id = 99;
                $grouping = SOccupationGrouping::findOne($job->occupation_grouping_id);
                ?>

                <div class="col-12 col-md-4 col-lg-3 col-xxl-2 pxp-categories-card-1-container">
                    <a href="service/service-job?category=<?= $job->occupation_grouping_id ?>" class="pxp-categories-card-1">
                        <div class="pxp-categories-card-1-icon-container">
                            <div class="pxp-categories-card-1-icon">
                                <span class="fa fa-<?= $grouping->icon ?>"></span>
                            </div>
                        </div>
                        <div class="pxp-categories-card-1-title">
                            <?= $grouping->occupation_grouping ?>
                        </div>
                        <div class="pxp-categories-card-1-subtitle"><?= $job->id ?> open positions</div>
                    </a>
                </div>
            <?php } ?>

        </div>


    </div>
</section>