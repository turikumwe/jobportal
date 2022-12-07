<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = "Rwandan Abroad";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\SOccupationGrouping;

?>

<?php //echo $model->body; 
?>
<div class="row">
    <div class="col-md-3 clpadding">
        <div id="displayAll" class="panel widget light-widget panel-bd-top">
            <div class="panel-heading">
                <a href="#" class="blue-heading">
                    Opportunities
                    <!-- Country: -->
                    <?php
                    // $ip = Yii::$app->geoip->ip($ip);
                    // echo $ip->country;
                    ?>
                </a>
            </div>
            <div class="panel-body tags" id="district" style="display:block">
                <table class="table table-condensed">
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                <div class="side-link">
                                    Are you looking for job opportunities in Rwanda?
                                </div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                <div class="side-link">
                                    Are you willing to do consultancy work in Rwanda?
                                </div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                <div class="side-link">
                                    Are you studying abroad and willing to do internship in Rwanda?
                                </div>
                            </a>
                        </td>
                        </a>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tabs widget">
            <ul class="nav nav-tabs widget" style="color: #fff;">
                <li>&nbsp;</li>
                <li style="border-right: 0px">Rwandan Abroad</li>
            </ul><br>
            As Rwanda is moving towards a knowledge-based economy, the need for specialized skills is
            rapidly increasing. Therefore, the development of the country requires the support of
            its nationals wherever they are around the world. <br>
            If you are Rwandan living abroad, willing to contribute to the development of your
            country you can register with Kora Job Portal to have access to information about
            employment opportunities, internship opportunities and consultancy services. This portal
            will also help to link Rwandans living abroad with potential employers in Rwanda who are
            looking for brilliant minds.
        </div>
        <div class="panel-group" id="accordion">
            <div class="panel panel-default noborder">
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body div-padding-left-0">
                        <p>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Are you looking for job opportunities in Rwanda?</h3>
                                    <hr>
                                    By registering with Kora Job Portal you will find available
                                    job opportunities both in public and private institutions in
                                    Rwanda.<br><br>

                                    <iframe width="100%" height="56.25%" src="https://www.youtube.com/embed/25sunsmG4q0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                    </iframe>
                                    <br>
                                    <h3>Available Specialised Opportunities</h3>
                                    <hr>

                                    <?php
                                    $k = 0;
                                    if (count($jobs) != 0) {
                                        ?>
                                        <div class="row">
                                            <?php foreach ($jobs as $key => $job) { ?>
                                                <?php
                                                        if ($job->occupation_grouping_id == '')
                                                            $job->occupation_grouping_id = 99;
                                                        $grouping = SOccupationGrouping::findOne($job->occupation_grouping_id);
                                                        ?>
                                                <?= Html::a(
                                                            '
                                                <div class="col col-md-4">
                                                    <div class="well jobtype text-center" style="color: #053EFF;">
                                                        <div class="row">
                                                            <div class="col col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                                                <i class="fas fa-' . $grouping->icon . ' i-size i-padding"></i><br>
                                                                ' . $grouping->occupation_grouping . ' (' . $job->id . ')
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>',
                                                            ['service/service-job', 'id' => $job->occupation_grouping_id],
                                                            ['style' => 'color: #053EFF;']
                                                        ); ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class='row well jobtype'>
                                                <center><code><?= Yii::t("frontend", "No specialised opportunities found ...") ?></code></center>
                                            </div>
                                        <?php } ?>
                                        </div>

                                </div>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body div-padding-left-0">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Are you willing to do work consultancy in Rwanda?</h3>

                                If you are willing to offer consultancy services in Rwanda, you can
                                register with Kora Job Portal to access different consultancy
                                opportunities in Rwanda. <br><br>

                                <iframe width="100%" height="56.25%" src="https://www.youtube.com/embed/lrwxQO2vTdw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                </iframe><br><br>

                                <?= Html::a('Click here to view public tenders', Url::to('http://umucyo.gov.rw', true), ["target" => "_blank", "class" => "btn btn-primary"]) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-body div-padding-left-0">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Are you studying abroad and willing to do internship in Rwanda?</h3>

                                By registering on Kora Job Portal, you will be able to access the
                                internship opportunities in Rwanda. <br>
                                RDB has developed an internship database where you can register and
                                get an opportunity for internships. <br><br>

                                <iframe width="100%" height="56.25%" src="https://www.youtube.com/embed/u6dXpqFKAmY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                </iframe><br><br>

                                <?= Html::a('Click here to apply for internship', Url::to('https://197.243.50.38/RDB_internship/', true), ["target" => "_blank", "class" => "btn btn-primary"]) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="panel panel-default noborder">
        <div id="collapse5" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Are you an entrepreneur?</h3>

                        If you are an entrepreneur willing to start your business in
                        Rwanda and you don’t have startup Capital, with NEP-Kora
                        wigire interventions like leasing, guarantee loan facility,
                        Agribusiness Investment facility that can help you have
                        access to finance and start a business of your choice.

                    </div>
                </div>
            </div>
        </div>
    </div> -->
        </div>
    </div>
</div>