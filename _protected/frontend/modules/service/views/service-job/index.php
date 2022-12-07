<?php

use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\SOccupationGrouping;
use frontend\modules\service\models\search\ServiceJobSearch;

;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');

$params = Yii::$app->request->getQueryParams() != null ? Yii::$app->request->getQueryParams() : [];
$params[0] = Yii::$app->controller->getRoute();
unset($params['jt']); //Avoid parameters duplication
unset($params['ct']); //Avoid parameters duplication
$url_parameter = '&';
if (count($params) == 1) { //Just url only
    $url_parameter = '?';
}
?>
<style>
    .howapply-wrp .howapply__cont .howapply__xpla li {
        list-style-type: initial;
        margin-left: 15px;
    }
</style>
<?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
<section class="pxp-page-header-simple" style="background-color: var(--pxpMainColorLight);">
    <div class="pxp-container">
        <h1>Search for opportunities</h1>
        <div class="pxp-hero-subtitle pxp-text-light">Search your career opportunity through <strong><?= number_format($jobs_count, 0); ?></strong> opportunities</div>
        <div class="pxp-hero-form pxp-hero-form-round pxp-large mt-3 mt-lg-4">
            <!--<form class="row gx-3 align-items-center">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'row gx-3 align-items-center'], 'id' => 'job_search', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-job')]); ?>
            <div class="col-12 col-lg">
                <div class="input-group mb-3 mb-lg-0">
                    <span class="input-group-text"><span class="fa fa-search"></span></span>
                    <input type="text" class="form-control" placeholder="Job Title or Keyword" name="title" value="<?= $title ?>">
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
                                <option value="<?= $district['id'] ?>"><?= $district['district'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg pxp-has-left-border">
                <div class="input-group mb-3 mb-lg-0">
                    <span class="input-group-text"><span class="fa fa-folder-o"></span></span>
                    <select class="form-select" name="category">
                        <option value="0">All categories</option>
                        <?php
                        if (count($job_categories) > 0) {
                            foreach ($job_categories as $category) {
                                ?>
                                <option value="<?= $category['id'] ?>" <?= ($selected_category == $category['id']) ? 'selected' : '' ?>><?= $category['occupation_grouping'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-auto">
                <button>Find Jobs</button>
            </div>
            <?php ActiveForm::end(); ?>
            <!--</form>-->
        </div>
    </div>
</section>

<section class="mt-100">
    <div class="pxp-container">
        <div class="row">
            <div class="col-lg-5 col-xl-4 col-xxl-3">
                <div class="pxp-jobs-list-side-filter">
                    <div class="pxp-list-side-filter-header d-flex d-lg-none">
                        <div class="pxp-list-side-filter-header-label">Filter Jobs</div>
                        <a role="button"><span class="fa fa-sliders"></span></a>
                    </div>
                    <div class="mt-4 mt-lg-0 d-lg-block pxp-list-side-filter-panel">
                        <h2>Filter job</h2>
                        <h3 class="mt-3 mt-lg-4">Type of employment</h3>
                        <div class="list-group mt-2 mt-lg-3" id="JobTypeList">
                            <?php
                            $opportunities = common\models\SOpportunity::find()->firstType()->all();
                            if (count($opportunities) > 0) {
                                foreach ($opportunities as $opportunity) {
                                    ?>
                                    <label class="list-group-item d-flex justify-content-between align-items-center pxp-checked">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2 job_type" type="checkbox" value="<?= $opportunity['id'] ?>" <?= in_array($opportunity['id'], $selected_job_types) ? 'checked' : ''; ?>>
                                            <?= $opportunity['name']; ?>
                                        </span>
                                        <span class="badge rounded-pill"><?= ServiceJobSearch::countByJobType($opportunity['id'], $selected_location, $selected_category, $title); ?></span>
                                    </label>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                        <br />
                        <h3>Type of Contract</h3>
                        <div class="list-group mt-2 mt-lg-3" id="ContractTypeList">

                            <?php
                            $contracts_types = \backend\models\SJobType::find()->orderBy('job_type')->asArray()->all();

                            if (count($contracts_types) > 0) {
                                foreach ($contracts_types as $type) {
                                    ?>
                                    <label class="list-group-item d-flex justify-content-between align-items-center pxp-checked">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="<?= $type['id']; ?>" <?= in_array($type['id'], $selected_contract_types) ? 'checked' : ''; ?>>
                                            <?= $type['job_type']; ?>
                                        </span>
                                        <span class="badge rounded-pill"><?= ServiceJobSearch::countByContractType($type['id']); ?></span>
                                    </label>
                                    <?php
                                }
                            }
                            ?>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-8 col-xxl-9">
                <div class="pxp-jobs-list-top mt-4 mt-lg-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h2><span class="pxp-text-light">Showing</span> <?= number_format($jobs_count, 0); ?> <span class="pxp-text-light">opportunities</span></h2>
                        </div>
                        <div class="col-auto">
                            <?php $form = ActiveForm::begin(['id' => 'sort_by', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/service/service-job')]); ?>
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

                <div>

                    <?php
                    $counter = 1;
                    foreach ($jobs as $key => $job) {
                        ?>
                        <div class="pxp-jobs-card-3 pxp-has-border">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-xxl-auto">
                                    <a href="#" class="pxp-jobs-card-3-company-logo" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/images/company-logo-1.png);"></a>
                                </div>
                                <div class="col-sm-9 col-md-10 col-lg-9 col-xl-10 col-xxl-4">
                                    <a href="<?= Yii::$app->link->frontendUrl('/service/service-job/view?id=' . $job->id) ?>" class="pxp-jobs-card-3-title mt-3 mt-sm-0"><?= $job->jobtitle; ?></a>
                                    <div class="pxp-jobs-card-3-details">
                                        <a href="#" class="pxp-jobs-card-3-location">
                                            <span class="fa fa-globe"></span><?= isset($job->districts->district) ? $job->districts->district : 'Abroad' ?>
                                        </a>
                                        <div class="pxp-jobs-card-3-type"><b>
                                                <?php
                                                $jobtype = backend\models\SJobType::findOne($job->job_type_id);
                                                if (!empty($jobtype)) {
                                                    echo $jobtype['job_type'];
                                                } else {
                                                    echo '';
                                                }
                                                ?>
                                            </b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-xl-6 col-xxl-4 mt-3 mt-xxl-0">
                                    <a href="<?= Yii::$app->link->frontendUrl('/service/service-job?category=' . $job->occupation_grouping_id) ?>" class="pxp-jobs-card-3-category">
                                        <div class="pxp-jobs-card-3-category-label"><?= isset($job->occupation_grouping_id) ? SOccupationGrouping::findOne($job->occupation_grouping_id)->occupation_grouping : '' ?></div>
                                    </a>
                                    <div class="pxp-jobs-card-3-date-company">
                                        <span class="pxp-jobs-card-3-date pxp-text-light">
                                            <?= ceil((abs(strtotime(date("Y-m-d")) - strtotime($job->publication_date)) / (60 * 60 * 24))) ?> days ago by
                                        </span> <a href="#" class="pxp-jobs-card-3-company">
                                            <?php
                                            $employer = \common\models\EmplEmployer::findOne($job->employer);
                                            if (isset($employer->id)) {
                                                echo $employer->company_name;
                                            } else {
                                                echo $job->employer;
                                            }
                                            ?>
                                        </a><br /> <b><i>Application deadline:</i></b> <span style="color: green; font-weight: bold"><?= date_format(date_create($job->closure_date), "M d, Y"); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xl-2 col-xxl-auto mt-3 mt-xxl-0 pxp-text-right">
                                    <?php
                                    if (Yii::$app->user->isGuest) {

                                        if ($job->apply_through_kora_flag == 0) {
                                            ?>
                                            <a href="#pxp-signin-modal" data-bs-toggle="modal" class="btn rounded-pill pxp-card-btn">Apply</a>
                                            <?php
                                        }
                                    } else {
                                        if (Yii::$app->user->can('user')) {
                                            if ($job->apply_through_kora_flag == 0) {
                                                if (common\models\JsJobApplication::canApply($job->id)) {
                                                    ?>
                                                    <a href="<?= $job->link ?>" class="btn rounded-pill pxp-card-btn" target="_blank">Apply</a>
                                                    <?php
                                                } else {
                                                    if (\common\models\User::isAJobSeeker(Yii::$app->user->identity->id)) {
                                                        ?>
                                                        &nbsp;&nbsp;&nbsp;<span style="color: green; font-weight: bold">Applied</span>
                                                        <?php
                                                    }
                                                }
                                            } else {
                                                if (common\models\JsJobApplication::alreadyApplied($job->id)) {
                                                    ?>
                                                    &nbsp;&nbsp;&nbsp;<span style="color: green; font-weight: bold">Applied</span>
                                                    <?php
                                                } else if (common\models\JsJobApplication::canApply($job->id)) {
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
                        <?php
                        $counter++;
                    }
                    ?>


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
            </div>
        </div>
</section>

<script type="text/javascript">
    function sort_by_selected() {
        $('#sort_by').submit();
    }
    $(".job_type").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });

    $('#JobTypeList').change(function () {
        var values = [];
        {
            $('#JobTypeList :checked').each(function () {
                values.push($(this).val());
            });
            window.location.href = '<?= Yii::$app->urlManager->createUrl($params); ?>' + '<?= $url_parameter; ?>jt=' + values;
        }
    });
    $('#ContractTypeList').change(function () {
        var contact_values = [];
        {
            $('#ContractTypeList :checked').each(function () {
                contact_values.push($(this).val());
            });
            window.location.href = '<?= Yii::$app->urlManager->createUrl($params); ?>' + '<?= $url_parameter; ?>ct=' + contact_values;
        }
    });
</script>