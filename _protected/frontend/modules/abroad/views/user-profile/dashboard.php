<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;
use kartik\ipinfo\IpInfo;

if ($addresses == NULL || $addresses->country_id == 183) {
    $divsize = 9;
} else $divsize = 6;
?>
<section class="howapply__s">
    <div class="kora-container howapply-wrp">
        <div class="howapply__cont">
            <div class='row'>
                <div id='search'>
                    <div class="row">
                        <div class="col-md-3">
                            <!-- <div class="panel widget light-widget panel-bd-top">
                    <div class="panel-heading no-title">Profile completeness</div>
                    <div class="panel-body">
                        <?php
                        // echo IpInfo::widget();
                        // echo Highcharts::widget([
                        //     'options' => [
                        //        'title' => [
                        //            'text' => 'Fruit Consumption'
                        //         ],
                        //        'xAxis' => [
                        //           'categories' => [
                        //                 'Apples', 
                        //                 'Bananas', 
                        //                 'Oranges'
                        //               ]
                        //        ],
                        //        'yAxis' => [
                        //             'title' => [
                        //                 'text' => 'Fruit eaten'
                        //             ]
                        //        ],
                        //        'series' => [
                        //             [
                        //                 'type' => 'line',
                        //                 'name' => 'Jane', 
                        //                 'data' => [
                        //                     1, 
                        //                     0, 
                        //                     4
                        //                 ]
                        //             ],
                        //             [
                        //                 'type' => 'line',
                        //                 'name' => 'John', 
                        //                 'data' => [
                        //                     5, 
                        //                     7, 
                        //                     3
                        //                 ]
                        //             ]
                        //         ]
                        //     ]
                        //  ]);
                        ?>
                        <table class="table table-condensed">
                            <tr>
                                <th>Identification</th>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <th>Summary</th>
                                <td>Not yet</td>
                            </tr>
                            <tr>
                                <th>Skills</th>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <th>Training</th>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <th>Language</th>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <th>Education</th>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <th>Professional experience</th>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <th>Endorsement</th>
                                <td>No yet</td>
                            </tr>
                            <tr>
                                <th>Recommendation</th>
                                <td>Not yet</td>
                            </tr>
                            <tr>
                                <th>Case Management</th>
                                <td>Not yet</td>
                            </tr>
                        </table>
                    </div>
                </div> -->
                            <div class="panel widget light-widget panel-bd-top">
                                <div class="panel-heading no-title">Profile</div>
                                <div class="panel-body">
                                    <div class="col col-md-12">
                                        <b>Completed %</b><br>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?= number_format($profile, 1) ?>%">
                                                <?= number_format($profile, 1) ?>%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-md-12">
                                        <b>Completed sections</b><br>
                                        <?php
                                        echo '<table class="table table-condensed">';
                                        foreach ($completed as $completed) {
                                            echo '<tr><td>' . $completed . '</td></tr>';
                                        }
                                        echo '</table>';
                                        ?>
                                    </div>
                                    <div class="col col-md-12">
                                        <b>Missing sections</b><br>
                                        <?php
                                        echo '<table class="table table-condensed">';
                                        foreach ($missing as $missing) {
                                            echo '<tr><td>' . $missing . '</td></tr>';
                                        }
                                        echo '</table>';
                                        ?>
                                    </div>
                                    <?= Html::a("Update profile", Yii::getAlias('@web') . '/jobseeker/user-profile', ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-<?= $divsize ?>">
                            <div class="panel widget light-widget panel-bd-top">
                                <h2>News headlines</h2>
                                <div class="panel-body">
                                    <?php \yii\widgets\Pjax::begin() ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if ($dataProvider->count > 0) : ?>
                                                <ul class="timeline">
                                                    <?php foreach ($dataProvider->getModels() as $model) : ?>
                                                        <?php if (!isset($date) || $date != Yii::$app->formatter->asDate($model->created_on)) : ?>
                                                            <!-- timeline time label -->
                                                            <li class="time-label">
                                                                <span style="background-color: #053efe; color: #ffffff">
                                                                    <?php echo Yii::$app->formatter->asDate($model->created_on) ?>
                                                                </span>
                                                            </li>
                                                            <?php $date = Yii::$app->formatter->asDate($model->created_on) ?>
                                                        <?php endif; ?>
                                                        <li>
                                                            <?php
                                                                    try {
                                                                        $viewFile = sprintf('%s/%s', $model->headline, $model->link);
                                                                        echo $this->render($viewFile, ['model' => $model]);
                                                                    } catch (\yii\base\InvalidArgumentException $e) {
                                                                        echo $this->render('_item', ['model' => $model]);
                                                                    }
                                                                    ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                    <li>
                                                        <i class="fa fa-clock-o">
                                                        </i>
                                                    </li>
                                                </ul>
                                            <?php else : ?>
                                                <?php echo Yii::t('backend', 'No news found') ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <?php echo \yii\widgets\LinkPager::widget([
                                                'pagination' => $dataProvider->pagination,
                                                'options' => ['class' => 'pagination']
                                            ]) ?>
                                        </div>
                                    </div>
                                    <?php \yii\widgets\Pjax::end() ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php if ($addresses != NULL && $addresses->country_id != 183) { ?>
                                <div class="panel widget light-widget panel-bd-top">
                                    <div class="panel-heading no-title">Opportunities</div>
                                    <div class="panel-body">
                                        <div class="col col-md-12">
                                            <div class="inner">
                                                <?php if (isset($oppforabroad)) echo $oppforabroad; ?> open opportunities for specialised skills<br><br>
                                                <center>
                                                    <?= Html::a("Specialised opportunities", Yii::getAlias('@web') . '/service/service-job/abroad', ['class' => 'btn btn-primary']) ?>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- <div class="panel widget light-widget panel-bd-top">
                    <div class="panel-heading no-title">LinkedIn page</div>
                    <div class="panel-body">
                        <div class="col col-md-12">
                            <div class="inner">
                                Please visit LinkedIn Page of Rwandan Living Abroad<br><br>
                                <center>
                                    <?= Html::a("Visit", '#', ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
                                </center>
                            </div>
                        </div>
                    </div>
                </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>