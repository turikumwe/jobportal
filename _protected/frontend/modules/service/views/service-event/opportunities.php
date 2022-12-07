<?php

use \yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<?php if (count($opportunities) != 0) { ?>
    <?php foreach ($opportunities as $key => $get) { ?>
        <?php if ($get->action_id == 2) continue; ?>
        <div class='col col-md-12'>
            <div class="well jobtype">
                <div class="row">
                    <div class="col col-xl-12 col-lg-12 col-md-12 col-xs-12" style="font-size: 12px">
                        <a href="<?= Yii::$app->link->frontendUrl('/service/service-event/view?id=' . $get->id) ?>">
                            <h4 class="mgbt-xs-15 mgtp-10 font-semibold">
                                <?= $key + 1; ?>. <u><?= $get->event_title; ?></u>
                                <?php if (!Yii::$app->user->can('user') && !Yii::$app->user->isGuest) { ?>
                                    <span class="label label-success" style="font-size: 0.5em">Published</span>
        <?php } ?>
                            </h4>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><b>Start Date:</b></div>
                    <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><?= $get->start_date ?></div>
                    <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><b>End Date:</b></div>
                    <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><?= $get->end_date ?></div>
                </div>
                <div class="row">
                    <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><b>Location:</b></div>
                    <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><?= $get->location->sector ?></div>
                    <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><b>Venue:</b></div>
                    <div class="col col-xl-3 col-lg-3 col-md-3 col-xs-6" style="font-size: 14px"><?= $get->venue ?></div>
                </div>
                <div class="row">
                    <div class="col col-xl-6 col-lg-6 col-md-6 col-xs-6" style="font-size: 14px"><b>Number of participants:</b></div>
                    <div class="col col-xl-6 col-lg-6 col-md-6 col-xs-6" style="font-size: 14px"><?= $get->number_participant ?></div>
                </div>
                <div class="dg-label">
        <?= isset($get->opportunity->name) ? $get->opportunity->name : '-'; ?>
                </div>
                <span class="pull-right">
                        <?php if (Yii::$app->user->can('user')) { ?>
                        <span class="pull-right">
                            <?php
                            Modal::begin([
                                'header' => 'Share:' . $get->event_title,
                                "class" => "vd_bg-red",
                                'toggleButton' => [
                                    'class' => 'btn vd_btn btn-xs vd_bg-blue',
                                    'label' => '<i class="glyphicon glyphicon-share" aria-hidden="true"></i>'
                                ],
                                'footer' => ''
                            ]);
                            $request = \Yii::$app->request;
                            echo $this->render('opportunity/_share', [
                                'model' => new \common\models\ServiceEventSharing(),
                                'get' => $get,
                                'opportunity' => $get->opportunity->id
                            ]);
                            Modal::end();
                            ?>
                        </span>
                        <span class="pull-right">&nbsp;</span>
                        <span class="pull-right">
                            <?php if ($share->saved($get->id) == 0) { ?>
                                <?php
                                Modal::begin([
                                    'header' => 'Save:' . $get->event_title,
                                    "class" => "vd_sm-red",
                                    'toggleButton' => [
                                        'class' => 'btn vd_btn btn-xs vd_bg-green',
                                        'label' => '<i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i>'
                                    ],
                                        //'footer'=> ''
                                ]);
                                $request = \Yii::$app->request;
                                echo $this->render('opportunity/_save', [
                                    'model' => new \common\models\ServiceEventSharing(),
                                    'get' => $get,
                                    'opportunity' => $get->opportunity->id
                                ]);
                                Modal::end();
                            } else {
                                echo "<span class='btn vd_btn btn-xs vd_bg-default'><i class='glyphicon glyphicon-floppy-saved'aria-hidden='true'></i></span>";
                            }
                            ?>
                        </span><span class="pull-right">&nbsp;</span>
                    <?php } else { ?>
            <?php if (!Yii::$app->user->isGuest) { ?>
                            <span class="pull-right">&nbsp;</span>
                            <span class="pull-right btn vd_btn btn-xs vd_bg-blue">
                                <a href="<?= Yii::$app->link->frontendUrl('/service/service-event/update-opportunity?id=' . $get->id) ?>">
                                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                                </a>
                            </span>
                        <?php } ?>
                    <?php } ?>
                    <?php if (Yii::$app->user->can('user')) { ?>
                        <?php if ($apply->eventApplied($get->id) == 0 && $get->apply_through_kora_flag == 1) { ?> 
                            <?php
                            Modal::begin([
                                'header' => 'Apply Now:' . $get->event_title,
                                "class" => "vd_bg-red",
                                'toggleButton' => [
                                    'class' => 'btn vd_btn btn-xs vd_bg-green',
                                    'label' => 'Apply Now <i class="glyphicon glyphicon-apply" aria-hidden="true"></i>'
                                ],
                                'footer' => ''
                            ]);
                            $request = \Yii::$app->request;
                            echo $this->render('opportunity/_apply', [
                                'model' => $apply,
                                'get' => $get,
                                'opportunity' => $get->opportunity->id
                            ]);
                            Modal::end();
                        } else if ($apply->eventApplied($get->id) != 0 && $get->apply_through_kora_flag == 1) {
                            echo "<span class='label label-default'>Applied </span>";
                        }
                    }
                    ?>
                </span>
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

<?php } else { ?>
    <div class='row well jobtype'>
        <center><code>No Found ...</code></center>
    </div>
<?php } ?>
