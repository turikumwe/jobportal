<?php

use common\models\ServiceJobSharing;
use yii\bootstrap\Modal;
use yii\widgets\LinkPager;
?>
<?php if (count($jobs) != 0) { ?>
    <?php //$k=0; for($i=0;$i<COUNT($jobs)/2;$i++) {
    ?>
    <div class="row veparate">
        <?php foreach ($jobs as $key => $job) { ?>
            <?php if ($job->action_id == 2) continue; ?>
            <div class="col col-md-12">
                <div class="well jobtype">
                    <div class="row veparate">
                        <div class="col col-xl-12 col-lg-12 col-md-12 col-xs-12">
                            <span class="pull-right label label-primary">
                                Viewed&nbsp;:&nbsp;<?= Yii::$app->jobSeeker->numberViewedApportunity($job->id) ?>
                            </span>
                            <span class="pull-left">
                                <a href="<?= Yii::$app->link->frontendUrl('/service/service-job/view?id=' . $job->id) ?>">
                                    <h4 class="mgbt-xs-15 mgtp-10 font-semibold">
                                        <?= $key + 1 ?>. <u><?= $job->jobtitle; ?></u>
                                        <?php if (!Yii::$app->user->can('user') && !Yii::$app->user->isGuest) { ?>
                                            <span class="label label-success" style="font-size: 0.6rem">Published</span>
                                        <?php } ?>
                                    </h4>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="row veparate">
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px">
                            <strong><span class="glyphicon glyphicon-play"></span> Employer:</strong></div>
                        <div class="col col-xl-9 col-lg-9 col-md-9 col-xs-6"><?= $job->employer ?></div>
                    </div>
                    <div class="row veparate">
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px">
                            <strong><span class="glyphicon glyphicon-map-marker"></span> Location</strong>
                        </div>
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6">
                            <?= isset($job->districts->district) ? $job->districts->district : '-' ?>
                        </div>
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px">
                            <strong><span class="glyphicon glyphicon-briefcase"></span> Contract:</strong>
                        </div>
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6">
                            <?= isset($job->jobType->job_type) ? $job->jobType->job_type : 'Not applicable'; ?>
                        </div>
                    </div>
                    <div class="row veparate">
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><strong><span class="glyphicon glyphicon-calendar"></span> Posted on:</strong></div>
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6"><?= date('Y-m-d', strtotime($job->posting_date)) ?></div>
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><strong><span class="glyphicon glyphicon-calendar"></span> Deadline: </strong></div>
                        <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6"><?= date('Y-m-d', strtotime($job->closure_date)) ?></div>
                    </div>
                    <div class="dg-label">
                        <?= isset($job->opportunity->name) ? $job->opportunity->name : '-'; ?>
                    </div>&nbsp;
                    <span class="pull-right">
                        <?php if (Yii::$app->user->can('user')) { ?>
                            <?php if ($apply->applied($job->id) == 0 && $job->apply_through_kora_flag == 1) { ?>
                                <?php
                                Modal::begin([
                                    'header' => 'Apply Now:' . $job->jobtitle,
                                    "class" => "vd_bg-red",
                                    'toggleButton' => [
                                        'class' => 'btn vd_btn btn-xs vd_bg-green',
                                        'label' => 'Apply Now <i class="glyphicon glyphicon-apply" aria-hidden="true"></i>'
                                    ],
                                    'footer' => ''
                                ]);
                                $request = Yii::$app->request;
                                echo $this->render('opportunity/_apply', [
                                    'model' => $apply,
                                    'job' => $job,
                                    'summary' => $summary,
                                    'opportunity' => $job->opportunity->id
                                ]);
                                Modal::end();
                            } else if ($apply->applied($job->id) != 0 && $job->apply_through_kora_flag == 1) {
                                echo "<span class='label label-default'>Applied </span>";
                            }
                        }
                        ?>
                    </span>
                    <span class="pull-right">&nbsp;</span>
                    <?php if (Yii::$app->user->can('user')) { ?>
                        <span class="pull-right">
                            <?php
                            Modal::begin([
                                'header' => 'Share:' . $job->jobtitle,
                                "class" => "vd_bg-red",
                                'toggleButton' => [
                                    'class' => 'btn vd_btn btn-xs vd_bg-blue',
                                    'label' => '<i class="glyphicon glyphicon-share" aria-hidden="true"></i>'
                                ],
                                'footer' => ''
                            ]);
                            $request = Yii::$app->request;
                            echo $this->render('opportunity/_share', [
                                'model' => new ServiceJobSharing(),
                                'job' => $job,
                                'opportunity' => $job->opportunity->id
                            ]);
                            Modal::end();
                            ?>
                        </span>
                        <span class="pull-right">&nbsp;</span>
                        <span class="pull-right">
                            <?php if ($share->saved($job->id) == 0) { ?>
                                <?php
                                Modal::begin([
                                    'header' => 'Save:' . $job->jobtitle,
                                    "class" => "vd_sm-red",
                                    'toggleButton' => [
                                        'class' => 'btn vd_btn btn-xs vd_bg-green',
                                        'label' => '<i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i>'
                                    ],
                                        //'footer'=> ''
                                ]);
                                $request = Yii::$app->request;
                                echo $this->render('opportunity/_save', [
                                    'model' => new ServiceJobSharing(),
                                    'job' => $job,
                                    'opportunity' => $job->opportunity->id
                                ]);
                                Modal::end();
                            } else {
                                echo "<span class='btn vd_btn btn-xs vd_bg-default'><i class='glyphicon glyphicon-floppy-saved'aria-hidden='true'></i></span>";
                            }
                            ?>
                        </span>
                    <?php } else { ?>

                        <?php if (!Yii::$app->user->isGuest) { ?>
                            <span class="pull-right">&nbsp;</span>
                            <span class="pull-right btn vd_btn btn-xs vd_bg-blue">
                                <a href="<?= Yii::$app->link->frontendUrl('/service/service-job/update-opportunity?id=' . $job->id) ?>">
                                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                                </a>
                            </span>
                        <?php } ?>
                    <?php } ?>
                    <div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div>
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
            ]);
            ?>
        </div>
    </div>

<?php } else { ?>
    <div class='row well jobtype'>
        <center><code><?= Yii::t("frontend", "No Found ...") ?></code></center>
    </div>
<?php } ?>