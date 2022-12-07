

<?php
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
<section class="mt-4 mt-lg-5" style="background-color: var(--pxpSecondaryColorLight);">
    <div class="pxp-container">
        <div class="pxp-single-job-cover pxp-cover" style="background-image: url(../../static/images/ph-big.jpeg);"></div>

        <div class="pxp-single-job-content mt-4 mt-lg-5">
            <div class="row" style="background-color:#ffffff; border-radius: 25px; padding-top: 15px; padding-bottom: 15px; padding-left: 20px">

                <div class="col-lg-7 col-xl-8 col-xxl-9" > <div class="row justify-content-between align-items-center">
                        <div class="col-xl-8 col-xxl-6"> 
                            <h1><?= $model->event_title; ?></h1>

                        </div>
                        <div class="col-auto">
                            <div class="pxp-single-job-options mt-4 col-xl-0">

                                <?php
                                    if (Yii::$app->user->isGuest) {
                                        if ($model->apply_through_kora_flag == 1) {
                                            if ($model->apply_through_kora_flag == 1) {
                                                ?>
                                                <a href="#pxp-signin-modal" data-bs-toggle="modal" class="btn rounded-pill pxp-card-btn">Apply now</a>
                                                <?php
                                            }
                                        }
                                    } else {
                                        if (Yii::$app->user->can('user')) {
                                            if (common\models\JsEventApplication::canApply($model->id)) {
                                                ?>
                                                <?php
                                                Modal::begin([
                                                    'header' => 'Apply Now:' . $model->event_title,
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
                                                    'get' => $model,
                                                    'opportunity' => $model->opportunity->id
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
                            <br />
                            <div class="pxp-single-job-date pxp-text-light"><?php
                                echo 'Posted on: ' . $model->created_at;
                                ?></div>
                        </div>
                    </div>



                    <div class="pxp-single-job-content-details mt-4 mt-lg-5">
                        <?php if ($model->s_opportunity_id == 2) {
                            ?>
                            <div class="mt-4">
                                <h4>Description </h4>
                                <p><?= strip_tags($model->description_organiser) ?>  </p></div>

                            <div class="mt-4">
                                <h4>Venue</h4>
                                <ul>
                                    <li><?= $model->venue ?></li> </ul>
                            </div>




                            <?php
                            if (!empty($model->doc_path)) {
                                ?>
                                <div class="mt-4">
                                    <h4>Document Attached</h4>
                                    <a class="btn btn-success" target="_blank" href=<?= Yii::getAlias('@storageUrl') . '/source/1/' . $model->doc_path; ?>><i class="fa fa-eye"></i>View Document</a> 
                                </div>
                            <?php } ?>

                            <?php
                        }
                        if ($model->s_opportunity_id == 1) {
                            ?>
                            <div class="mt-4">
                                <h4>Description of Organizer </h4>
                                <p><?= strip_tags($model->description_organiser) ?>  </p>
                            </div>
                            <div class="mt-4">
                                <h4>Description of Training</h4>
                                <p><?= strip_tags($model->description_event) ?>  </p>
                            </div>

                            <div class="mt-4">
                                <h4>Venue</h4>
                                <p><?= $model->venue ?></p>
                            </div>




                            <?php
                            if (!empty($model->doc_path)) {
                                ?>
                                <div class="mt-4">
                                    <h4>Document Attached</h4>
                                    <a class="btn btn-success" target="_blank" href=<?= Yii::getAlias('@storageUrl') . '/source/1/' . $model->doc_path; ?>><i class="fa fa-eye"></i>View Document</a> 
                                </div>
                            <?php } ?>

                            <div class="mt-4 mt-lg-5">
                                <a  href="#pxp-signin-modal" data-bs-toggle="modal" class="btn rounded-pill pxp-section-cta">Apply Now</a>
                            </div>
                        <?php } ?>
                    </div>

                </div>
                <div class="col-lg-5 col-xl-4 col-xxl-3">
                    <?php
                    if ($model->s_opportunity_id == 2) {
                        ?>
                        <div class="pxp-single-job-side-panel mt-5 mt-lg-0">
                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light" style="color:red; font-weight: bold">Application Deadline</div>
                                <div class="pxp-single-job-side-info-data" style="color:red; font-weight: bold"><?= $model->closure_date; ?></div>
                            </div>


                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light">Start date</div>
                                <div class="pxp-single-job-side-info-data"><?= $model->start_date
                        ?></div>
                            </div>
                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light">End date</div>
                                <div class="pxp-single-job-side-info-data"><?= $model->end_date
                        ?></div>
                            </div>



                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light">Maximum Participant</div>
                                <div class="pxp-single-job-side-info-data"><?= $model->number_participant
                        ?></div>
                            </div>




                        </div>
                        <?php
                    }
                    if ($model->s_opportunity_id == 1) {
                        ?>
                        <div class="pxp-single-job-side-panel mt-5 mt-lg-0">
                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light" style="color:red; font-weight: bold">Application Deadline</div>
                                <div class="pxp-single-job-side-info-data" style="color:red; font-weight: bold"><?= $model->closure_date; ?></div>
                            </div>


                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light">Start date</div>
                                <div class="pxp-single-job-side-info-data"><?= $model->start_date
                        ?></div>
                            </div>
                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light">End date</div>
                                <div class="pxp-single-job-side-info-data"><?= $model->end_date
                        ?></div>
                            </div>



                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light">Maximum Participant</div>
                                <div class="pxp-single-job-side-info-data"><?= $model->number_participant
                        ?></div>
                            </div>
                            <div class="mt-4">
                                <div class="pxp-single-job-side-info-label pxp-text-light">Event Location</div>
                                <div class="pxp-single-job-side-info-data"><?php
                                    if (isset($model->event_location)) {
                                        echo backend\models\SGeosector::findOne($model->event_location)->sector;
                                    }
                                    ?></div>
                            </div>




                        </div>                  

                        <?php
                    }
                    ?>
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





