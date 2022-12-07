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
<!-- =======================-->
    <div style="max-width: 1200px !important;margin: auto;">
                                    
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6" style="background-color: light;  border: 1px solid #053eff; ">

                           <br><div class="Welc_note" tabindex="0">
                                       <p style="color: #053eff;"><b>About Tourism and Hospitality sector</b></p>
                                   </div>           
                                <div class="Welc_note" tabindex="0">

                                    <!--====================Start read more====================-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="style.css">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">


<style>
    .module .collapse, .module .collapsing {
    height: 10rem;
}

.module .collapse {
    position: relative;
    display: block;
    overflow: hidden;
}

.module .collapse:before {
    content: ' ...';
    position: absolute;
    right: 0;
    bottom: 0;
}

.module .collapse.show {
    height: auto;
}

.module .collapse.show:before {
    display: none;
}

.module a.collapsed:after {
    content: '+ Read More';
}

.module a:not(.collapsed):after {
    content: ' '
}
</style>
    
                        <div class="container">
                            <div class="module">
                                    <p class="collapse" id="collapseExample" aria-expanded="false" align="justify">
                                    Rwanda’s Tourism and Hospitality industry is the fastest growing industry, and it is also the top foreign exchange earner. In 2017, the industry generated receipts of US$438 million and is expected to generate over US$800 million by 2024 according to figures and estimates provided by Rwanda Development Board (RDB, 2018) and NST1 projections. 
                                    <br><br>Did you know that in 2019, the contribution of Travel and Tourism to the total employment was 331,200 jobs? According to the World Travel and Tourism Council (2020), the contribution of the sector to the national GDP was 10.2% of the total economy.
                                    <br><br>The Tourism and Hospitality sector is recognised as one of the most important sector. There are several visible benefits in addition to economic growth and development and employment opportunities. The sector contributes to infrastructure development like hotels, conference facilities and entertainment venues. It also boosts other sectors such as accommodation services, food and beverages, retail trade-in souvenirs and transport services, thus offering local populations the opportunities to benefit from tourism growth and development directly. Moreover, to ensure that we benefit from this sector, the Government of Rwanda has several international campaigns such as Visit Rwanda, Arsenal, and PSG sponsorship deals, to attract more visitors. 
                                    <br><br>So, would you like to be a part of this dynamic industry? Here you can get a glimpse about different kinds of jobs that the industry offers, and also information about different educational institutions and short courses that you can enrol in.                 
                                    </p>
                                <a role="button" class="collapsed" data-toggle="collapse" href="#collapseExample" 
                                 aria-expanded="false" aria-controls="collapseExample"></a>
                            </div>
                        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
                                    <!--=====================End read more===================-->
                                </div>

            </div>
             <div class="col-md-6" background-color="red" style="background-color: light;" align="center">
                              
                        <div id="demo" class="carousel slide" data-ride="carousel">

                          <!-- Indicators -->
                          <!-- <ul class="carousel-indicators">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                            <li data-target="#demo" data-slide-to="1"></li>
                            <li data-target="#demo" data-slide-to="2"></li>
                          </ul> -->

                         <!-- The slideshow -->
                          <div class="carousel-inner">
                            <div class="carousel-item active">
                                <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/1T_H_Slide1.jpg", ['alt' => 'Two men are working on building site']); ?>
                            </div>
                            <div class="carousel-item">
                                <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/1T_H_Slide2.jpg", ['alt' => 'Two men are working on building site']); ?>
                            </div>
                            <div class="carousel-item">
                                <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/1T_H_Slide3.jpg", ['alt' => 'Two men are working on building site']); ?>
                            </div>
                            <div class="carousel-item">
                                <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/1T_HSlide4.jpg", ['alt' => 'chef']); ?>
                            </div>
                            <div class="carousel-item">
                                <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/1T_H_Slide5.jpg", ['alt' => 'Two men are working on building site']); ?>
                            </div>
                          </div>
                          
                          <!-- Left and right controls -->
                          <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                          </a>
                          <a class="carousel-control-next" href="#demo" data-slide="next" >
                            <span class="carousel-control-next-icon" ></span>
                          </a>
                        </div>

            </div>
        </div>
    </div>
    </div><br>
<!-- =======================-->
<section class="recent__opp" tabindex="0" id="recent_opportunities">
    <div class="kora-container recent__oppp-wrp">
        <h2>Career Guidance in the Tourism and Hospitality</h2>
        <br><div class="re-opp__cardsholder">

    <div class="kora-container welcome__note-wrp" id="wlm_note">
        <div class="Welc_note" tabindex="0" text-align="justify" style="">
            <div class="opp_cardsholder" style="">
               <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/1CG1.jpg", ['alt' => 'Opportunity icon']); ?>
                        <br>
                     <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;">           
                        <p align="Left" style="padding-right: 30px;padding-left: 30px;"><br>  
        Are you interested in knowing about the different career opportunities that you can have in the Rwandan Tourism and Hospitality industry?
            </p>
        <p align="center" style="background-color: transparent;border: none;border-radius: 3px;font-size: .75rem;font-family: sansRegular;color: #053eff;border: 1px solid #97a4ff;padding: 6px 12px;width: 100px;margin: 0 auto;transition: all 200ms ease-in-out;" >
                    <?= Html::a(
                        'Learn More',
                        ['site/careerchoice']
                    )
                    ?>
        </p><br>
    </div>
            </div>
        </div>
        <div class="Welc_note" tabindex="0" text-align="justify" style="">
            <div class="opp_cardsholder" style="">
               <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/1CG2.jpg", ['alt' => 'Opportunity icon']); ?>
        <br>
        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;">  
        <p align="Left" style="padding-right: 30px;padding-left: 30px;"><br>   
    Do you want to know about the educational institutions and the private sector in Rwanda offering Tourism and Hospitality opportunities?
            </p>
        <p align="center" style="background-color: transparent;border: none;border-radius: 3px;font-size: .75rem;font-family: sansRegular;color: #053eff;border: 1px solid #97a4ff;padding: 6px 12px;width: 100px;margin: 0 auto;transition: all 200ms ease-in-out;">
                    <?= Html::a(
                        'Learn More',
                        ['site/careeredu']
                    )
                    ?>
        </p>
        <br>
    </div>
            </div>
        </div>

    </div><br>
        </div>
    </div><br>
</section>

<?php if (!empty($high)) { ?>
    <section class="recent__opp" tabindex="0" id="recent_opportunities">
        <div class="kora-container recent__oppp-wrp">
            <h2>Recent Opportunities</h2>
            <div class="re-opp__cardsholder">
<!--                 <div class="main_crd">



                </div> -->
                <div class="more_crds">
                    <!--====-->
                    <div class="re-opp_cards">
                        <?php
                        $grp = SOccupationGrouping::findOne($high->occupation_grouping_id);
                        ?>
                        <div class="cards__title">
                            <h3 tabindex="0"><?= $grp->occupation_grouping ?></h3>
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
                    <!--====-->
                    <?php foreach ($jobs as $key => $job) { ?>
                        <?php
                        if ($job->occupation_grouping_id == '')
                            $job->occupation_grouping_id = 99;
                        $grouping = SOccupationGrouping::findOne($job->occupation_grouping_id);
                        ?>
                        <div class="re-opp_cards">
<!--                             <div class="cards__icon">
                                <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/icons/jobs.svg", ['alt' => 'Opportunity icon']); ?>
                            </div> -->
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