<?php

use common\models\SOccupationGrouping;
use yii\helpers\Html;

$k = 0;
if (count($jobs) != 0) {
?>
    <div class="more_crds">
        <?php foreach ($jobs as $key => $job) { ?>
            <?php
            if ($job->occupation_grouping_id == '')
                $job->occupation_grouping_id = 99;
            $grouping = SOccupationGrouping::findOne($job->occupation_grouping_id);
            ?>
            <div class="re-opp_cards" style="color: #053eff; text-align: center">
                <div class="cards__icon">
                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => 'Opportunity icon']); ?>
                </div>
                <div class="cards__title">
                    <h3 style="color: #053eff;"><?= $grouping->occupation_grouping ?></h3>
                    <h4><?= $job->id ?></h4>
                    <center>
                        <?= Html::a(
                            'Learn More',
                            ['service/service-job', 'id' => $job->occupation_grouping_id],
                            ['tabindex' => -1]
                        )
                        ?>
                    </center>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class='row well jobtype'>
            <center><code><?= Yii::t("frontend", "No specialised opportunities found ...") ?></code></center>
        </div>
    <?php } ?>
    </div>