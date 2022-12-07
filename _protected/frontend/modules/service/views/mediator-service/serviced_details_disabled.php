<?php

use frontend\assets\FrontendAsset;
use backend\models\SDistrict;
use frontend\modules\jobseeker\models\search\JsAddressSearch;
use frontend\modules\service\models\search\ServiceJobSearch;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\JsSummary;
use common\models\JsExperience;
use common\models\JsLanguage;
use common\models\JsSkill;
use common\models\JsTraining;
use common\models\ServiceJob;
use common\models\JsEducation;
use common\models\JsAddress;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php") ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <h1>Service beneficiaries</h1>
        <div class="col-auto order-2 order-sm-1">
            <div class="pxp-company-dashboard-jobs-bulk-actions mb-3 col-md-4">
                <table class="table table-hover align-middle">
                    <tr>
                        <th>Service name </th>
                        <td><?= isset($selected_service->name) ? $selected_service->name : 'All'; ?></td>
                    </tr>
                    <tr>
                        <th>Disability</th>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <th>Service from</th>
                        <td><?= $from ?></td>
                    </tr>
                    <tr>
                        <th>Service to</th>
                        <td><?= $to ?></td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="mt-4">

            <?php if (count($applicants) > 0) { ?>
                <h1>Beneficiaries</h1>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="pxp-is-checkbox" style="width: 1%;">#</th>
                                <th colspan="2" style="width: 25%;">Name</th>
                                <th style="width: 10%;">Gender</th>
                                <th>Phone</th>
                                <th >Disability</th>
                                <th>Profile completion</th>
                                <th>Education level</th>
                                <th>Qualification</th>
                            </tr>
                        </thead>
                        <tbody id="TableItems">
                            <?php
                            $gender = array(1 => 'Male', 2 => 'Female', '' => '');
                            $counter = 1;
                            foreach ($applicants as $key => $candidate) {
                                $current_user = common\models\UserProfile::findOne($candidate->user_id);
                                $current_job = ServiceJobSearch::findOne($candidate->user_id);
                                $user_address = JsAddressSearch::getJobSeekerFirstAddress($candidate->user_id);
                                ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="<?= Yii::$app->link->frontendUrl('/site/seeker-profile?idOtherProfile=' . $candidate->user_id) ?>">
                                            <div class="pxp-company-dashboard-job-title"><?= $current_user->lastname . ' ' . $current_user->firstname; ?></div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span><?= isset($user_address->district_id) ? SDistrict::findOne($user_address->district_id)->district : '-'; ?></div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category"><?= $gender[$current_user->gender]; ?></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">
                                            <?= $current_user->phone_number; ?>
                                        </div>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-status"><?= backend\models\SDisability::findOne($current_user->disability_id)->disability; ?></div></td>

                                    <td>
                                        <div class="pxp-company-dashboard-job-date">
                                            <?php
                                            // $summary = New JsSummary();
                                            $summary = JsSummary::find()->where(['user_id' => $candidate->user_id])->count();
                                            $experience = JsExperience::find()->where(['user_id' => $candidate->user_id])->count();
                                            $education = JsEducation::find()->where(['user_id' => $candidate->user_id])->count();
                                            $training = JsTraining::find()->where(['user_id' => $candidate->user_id])->count();
                                            $language = JsLanguage::find()->where(['user_id' => $candidate->user_id])->count();
                                            $skill = JsSkill::find()->where(['user_id' => $candidate->user_id])->count();
                                            $address = JsAddress::find()->where(['user_id' => $candidate->user_id])->count();

                                            $oppforabroad = ServiceJob::find()
                                                    ->where(['competency_level_id' => 2])
                                                    ->andWhere(['action_id' => 1])
                                                    ->andWhere(['>=', 'closure_date', date('Y-m-d')])
                                                    ->count();

                                            $completed = array();
                                            if ($summary >= 1)
                                                $completed[] = "Summary <span class='glyphicon glyphicon-ok'></span>";
                                            if ($experience >= 1)
                                                $completed[] = "Professional experience ($experience) <span class='glyphicon glyphicon-ok'></span>";
                                            if ($education >= 1)
                                                $completed[] = "Education ($education) <span class='glyphicon glyphicon-ok'></span>";
                                            if ($training >= 1)
                                                $completed[] = "Training ($training) <span class='glyphicon glyphicon-ok'></span>";
                                            if ($language >= 1)
                                                $completed[] = "Language ($language) <span class='glyphicon glyphicon-ok'></span>";
                                            if ($skill >= 1)
                                                $completed[] = "Skill ($skill) <span class='glyphicon glyphicon-ok'></span>";

                                            if ($address >= 1) {
                                                $completed[] = "Address <span class='glyphicon glyphicon-ok'></span>";
                                                $addresses = JsAddress::find()->where(['user_id' => $candidate->user_id])->one();
                                            }

                                            $profile = count($completed);
                                            ?>
                                            <?= number_format(($profile * 100 / 7), 1) ?>%

                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $highest_education = JsEducation::find()->where(['user_id' => $candidate->user_id])->orderBy(['education_level_id' => SORT_DESC])->one();
                                        if (isset($highest_education->education_level_id) && $highest_education->education_level_id > 0) {
                                            echo backend\models\SEducationLevel::find()->where(['id' => $highest_education->education_level_id])->one()->level;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($highest_education->education_level_id) && $highest_education->education_level_id > 0) {
                                            echo $highest_education->exact_quali;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php $form = ActiveForm::begin(['id' => 'change_application_status', 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/service/service-job/bulk-change-application-status')]); ?>
                    <input type="hidden" id="selected_application" name="selected_application" value="" />
                    <input type="hidden" id="selected_status" name="selected_status" value="" />
                    <?php ActiveForm::end(); ?>
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
            <?php } ?>
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
<div class="modal fade pxp-user-modal" id="pxp-signin-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="pxp-single-candidate-side-panel">
                    <h3>Contact David</h3>
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

<script type="text/javascript">
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });

    function change_status() {
        var selected = new Array();
        $("#TableItems input[type=checkbox]:checked").each(function () {
            selected.push(this.value);
        });
        if (parseInt($('#status :selected').val()) && selected.length > 0) {

            if (confirm("Are sure you want to change the application Status?")) {
                $('#selected_application').val(selected.join(","));
                $('#selected_status').val($('#status :selected').val());
                $("#change_application_status").submit();
            }

        } else {
            alert("Please make valid selections");
        }

    }
    function confirm_status_update() {
        if (confirm("Are sure you want to change the application Status?")) {
            return true;
        } else {
            return false;
        }
    }
    function filter_by_opportunity() {
        if (parseInt($('#opportunity_type :selected').val()) > 0) {
            window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-job/my-jobs'); ?>' + '?type=' + $('#opportunity_type :selected').val();
        } else {
            alert("Please make valid selections")
        }

    }
    function search_job() {
        if (parseInt($('#opportunity_type :selected').val()) > 0) {
            window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-job/my-jobs'); ?>' + '?type=0&' + $('#opportunity_type :selected').val();
        } else {
            alert("Please make valid selections")
        }

    }
    function confirm_delete() {
        if (confirm("Are you sure want to delete this? No undo")) {
            return true;
        } else {
            return false;
        }

    }
</script>

