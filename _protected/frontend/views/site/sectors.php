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

<section tabindex="0">
    <div class="kora-container">
        <div class="sec__header">
            <div class="sec__header__title" tabindex="0">
                <h2 tabindex="0">Muraho,</h2>
                <p font-size="1.3rem" font-family="sansBold" tabindex="0">
                    My name is
                    <b style="color: #1d1d1f;font-family: sansBold;">Kora</b>
                    and I am a job agent,<br> how about you?
                </p>
                <div class="sec__header-btns">
                    <?= Html::a(
                        'I am a Jobseeker',
                        ['site/jobseeker']
                    )
                    ?>
                    <?= Html::a(
                        'I am an Employer',
                        ['site/employer']
                    )
                    ?>
                    <?= Html::a(
                        'I am a Job Agent',
                        ['site/jobagent']
                    )
                    ?>
                </div>
                <div class="sec__header-search" tabindex="0">
                    <?php $form = ActiveForm::begin([
                        'action' => ['service/service-job/index'],
                        'method' => 'get',
                        'options' => [
                            'class' => 'form-inline'
                        ],
                    ]); ?>
                    <div class="form-group">
                        <?= $form->field($model, 'jobtitle')
                            ->textInput(
                                [
                                    'placeholder' => Yii::t('frontend', 'Search Opportunity......'),
                                    'class' => '',
                                ]
                            )
                            ->label(false) ?>
                    </div>
                    <div class="form-group">
                        <?=
                            $form->field($model, 'district_id')->dropDownList(
                                ArrayHelper::map(backend\models\SDistrict::find()->all(), 'id', 'district'),
                                ['prompt' => 'Select District']
                            )->label(false);
                        ?>
                    </div>
                    <?= Html::submitButton(Yii::t('frontend', 'Search')) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="sec__header__slider">
                <div class="slider__wrp">
                    <div class="bd-example">
                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                                <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
                                <li data-target="#carouselExampleCaptions" data-slide-to="4"></li>
                                <li data-target="#carouselExampleCaptions" data-slide-to="5"></li>
                                <li data-target="#carouselExampleCaptions" data-slide-to="6"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/homepage.png", ['class' => 'd-block w-100', 'alt' => 'Two men are working on building site']); ?>
                                    <div class="carousel-caption d-none d-md-block">
                                    </div>
                                </div>
                                <div class="item">
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/employers.png", ['class' => 'd-block w-100', 'alt' => 'A woman and man employer interviewing a woman job seeker']); ?>
                                    <div class="carousel-caption d-none d-md-block">
                                    </div>
                                </div>
                                <div class="item">
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/opportunities.png", ['class' => 'd-block w-100', 'alt' => 'A man and two women, one has disability sitting in front of computer, searching for opportunities']); ?>
                                    <div class="carousel-caption d-none d-md-block">
                                    </div>
                                </div>
                                <div class="item">
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/howtoapply.png", ['class' => 'd-block w-100', 'alt' => 'A person ticking a checklist on a paper with a pencil']); ?>
                                    <div class="carousel-caption d-none d-md-block">
                                    </div>
                                </div>
                                <div class="item">
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/nep.png", ['class' => 'd-block w-100', 'alt' => 'A man instructor assists a tailor woman to develop her career']); ?>
                                    <div class="carousel-caption d-none d-md-block">
                                    </div>
                                </div>
                                <div class="item">
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerguidance.png", ['class' => 'd-block w-100', 'alt' => 'Woman thinking about career choice: officer, photographer, programmer….']); ?>
                                    <div class="carousel-caption d-none d-md-block">
                                    </div>
                                </div>
                                <div class="item">
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/employmentservicecentre.png", ['class' => 'd-block w-100', 'alt' => 'A young man entering the office of Employment Service Center']); ?>
                                    <div class="carousel-caption d-none d-md-block">
                                    </div>
                                </div>
                            </div>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                <span class="icon-prev" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carouselExampleCaptions" role="button" data-slide="next">
                                <span class="icon-next" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div><br>
    </div>
</section>

<section class="welcome__note" tabindex="0">
    <div class="kora-container welcome__note-wrp" id="wlm_note">
        <div class="Welc_note" tabindex="0">
            <!-- <h2>Muraho,</h2> -->
            <p>Welcome to the Kora jobportal. The Kora jobportal is a matching platform established by the Rwanda
                Development
                Board with the aim of linking jobseekers with potential employers. On this portal, you will find
                different jobs,
                internships and training opportunities as well as information on Career Guidance and the National
                Employment
                Programme (NEP Kora Wigire). The Kora jobportal is also a client management tool for the Public
                Employment Service Centres.
            </p>
        </div>
        <div class="Welc_opportunities" tabindex="0">
            <h2>Opportunities</h2>
            <div class="opp_cardsholder">
                <?= Html::a('
                    <div class="opp_cards">
                        <div class="cards__icon">' .
                    Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => 'Opportunity icon'])
                    . '</div>
                        <div class="cards__title" tabindex="0">
                            <h3>Jobs</h3>
                        </div>
                    </div>', ['service/service-job', 'opportunity' => 1])
                ?>
                <?= Html::a('
                    <div class="opp_cards">
                        <div class="cards__icon">' .
                    Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => ''])
                    . '</div>
                        <div class="cards__title" tabindex="0">
                            <h3>Apprenticeship</h3>
                        </div>
                    </div>', ['service/service-job', 'opportunity' => 4])
                ?>
                <?= Html::a('
                <div class="opp_cards">
                    <div class="cards__icon">' .
                    Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => 'Opportunity icon'])
                    . '</div>
                    <div class="cards__title" tabindex="0">
                        <h3>Internship</h3>
                    </div>
                </div>', ['service/service-job', 'opportunity' => 3])
                ?>

                <?= Html::a('
                    <div class="opp_cards">
                        <div class="cards__icon">' .
                    Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => 'Opportunity icon'])
                    . '</div>
                        <div class="cards__title" tabindex="0">
                            <h3>Freelancers</h3>
                        </div>
                    </div>', ['service/ussd-jobseeker'])
                ?>

                <?= Html::a('
                <div class="opp_cards">
                    <div class="cards__icon">' .
                    Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => 'Opportunity icon'])
                    . '</div>
                    <div class="cards__title" tabindex="0">
                        <h3>Events</h3>
                    </div>
                </div>', ['service/service-job', 'opportunity' => 2])
                ?>

                <?= Html::a('
                    <div class="opp_cards">
                        <div class="cards__icon">' .
                    Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => 'Opportunity icon'])
                    . '</div>
                        <div class="cards__title" tabindex="0">
                            <h3>Training</h3>
                        </div>
                    </div>', ['service/service-job', 'opportunity' => 5])
                ?>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($high)) { ?>
    <section class="recent__opp" tabindex="0" id="recent_opportunities">
        <div class="kora-container recent__oppp-wrp">
            <h2>Recent opportunities</h2>
            <div class="re-opp__cardsholder">
                <div class="main_crd">
                    <h2  style="background-color:#fb1828;">Sectors</h2>
                    <div class="re-opp_cards">
                        <div>
                            <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/07.png", ['alt' => 'Opportunity icon']); ?>
                        </div>
                         <div class="cards__title">
                            <h3 tabindex="0">Tourism and Hospitality sector</h3>
                            <!-- <p tabindex="0">Occupation grouping with highest number of opportunities</p> -->
                            <br><center>
                                <?php
                                echo Html::a(
                                    'Learn More',
                                    ['site/careersectors'],
                                    ['tabindex' => -1]
                                )
                                ?>
                            </center>
                        </div>
                    </div><br>

                </div>
                <div class="more_crds">
                                    <!--=========-->
                    <div class="re-opp_cards">
                        <?php
                        $grp = SOccupationGrouping::findOne($high->occupation_grouping_id);
                        ?>
                        <div class="cards__title"><br><br>
                            <h3 tabindex="0"><?= $grp->occupation_grouping ?></h3><br>
                            <h4 tabindex="0"><?= $grp->id ?></h4>
<!--                             <p tabindex="0">Occupation grouping with highest number of opportunities</p> -->
                            <center>
                                <?php
                                echo Html::a(
                                    'Learn More',
                                    ['service/service-job', 'id' => $high->occupation_grouping_id],
                                    ['tabindex' => -1]
                                )
                                ?>
                            </center>
                        </div>
                    </div>
                                    <!--=========-->

                    <?php foreach ($jobs as $key => $job) { ?>
                        <?php
                        if ($job->occupation_grouping_id == '')
                            $job->occupation_grouping_id = 99;
                        $grouping = SOccupationGrouping::findOne($job->occupation_grouping_id);
                        ?>
                        <div class="re-opp_cards">
                            <div class="cards__icon">
                                <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => 'Opportunity icon']); ?>
                            </div>
                            <div class="cards__title">
                                <h3 tabindex="0"><?= $grouping->occupation_grouping ?></h3>
                                <h4 tabindex="0"><?= $job->id ?></h4>
                                <!-- <button type="submit" tabindex="-1">Learn More</button> -->
                                <center>
                                    <?php
                                    echo Html::a(
                                        'Learn More',
                                        ['service/service-job', 'id' => $job->occupation_grouping_id],
                                        ['tabindex' => -1]
                                    )
                                    ?>
                                </center>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
