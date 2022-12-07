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
<!--========-->
<?php if (!Yii::$app->user->isGuest) { ?>
<!--======-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    width: 1200px;
    /*height: 270px;*/
  }
  </style>
<!--=======================-->
<!--========================================-->
<!--=====-->
<section class="welcome__note" tabindex="0">
            <div class="kora-container recent__oppp-wrp"><h2>Educational Institutions</h2><br></div>
    <div class="kora-container welcome__note-wrp" id="wlm_note">


                <div id="demo" class="carousel slide" data-ride="carousel"><br>
                 

                 <!-- The slideshow -->
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                  <!--  <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>   -->      
                  <div class="col-md-2" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/vatel_rwanda.png"); ?>
                             </div>
                  </div>
                 
                  <div class="col-md-10" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">
                      Vatel Hotel and Tourism Business School is an International Hotel and Tourism Management school on a mission to prepare the younger generation for a successful career in the Hospitality and Tourism Industry. Vatel has over 55 Schools, 9,000 students and 35,000 alumni across Europe, the Americas, Asia and Africa.</p>
                      <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">

                      At Vatel Rwanda, you will be immersed in Rwanda's tourism and hospitality industry and learn directly from leading experts in the field who use interactive and innovative teaching methods with a focus on practical skills for the workplace. Vatel Rwanda offers a three-year, full-time bachelor's degree in International Hotel Management with a proven international curriculum that balances theory and practical applications.</p>
                      <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">

                      Over the course of their studies, students complete over 10 months of professional internships at our partner hospitality and tourism establishments, where they are immersed in real management contexts. During the academic term, students alternate between 3 weeks of theory and 3 weeks of practical applications in these establishments. Students also have the opportunity to spend their second year at a different Vatel Campus studying the same courses but in a different linguistic and cultural context under the Marco Polo program.</p>
                      <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">

                      Vatel, in partnership with Mastercard Foundation, also delivers professional short courses to youths with little or no experience in the hospitality sector, equipping them with the skills required to fill executive-level positions."</p><p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">  Want to know more? Visit us: <a href="http://www.vatel.rw" style="text-decoration: none;"> <b>www.vatel.rw</b></a> or contact us: <a href="mailto:info@vatel.rw" style="text-decoration: none;"> <b>info@vatel.rw</b></a></b>
                    </p>
                </div>
             
            </div>
                    </div>
                    <div class="carousel-item">
                         <div class="row">
                  <!--  <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>   -->      
                  <div class="col-md-2" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/3. Cornell logo.png"); ?>
                             </div>
                  </div>
                 
                  <div class="col-md-10" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">     Cornell University, located in Ithaca, New York, USA is the largest of the Ivy-League Universities. Cornell's School of Hotel Administration, founded in 1922, is the world's first four-year intercollegiate school devoted to hospitality management. The school has consistently ranked number 1 in the world. </p>
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">

                    Cornell, as a part of the Mastercard Foundation Hanga Ahazaza Initiative, is providing educational training to hospitality professionals in Rwanda via eCornell online courses, virtual events, and executive education courses.</p>
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">

                    Our 10-month program in Hospitality Management includes 7 online courses and one 3 hours interactive virtual class facilitated by our faculty in the USA. Courses are facilitated by our Rwandan-based Instructor. Upon completion of the program you will earn a Recognition of Achievement in Service Excellence, a Certificate in Hospitality Management and a Specialization Certificate in Hotel Revenue Management, Restaurant Revenue Management, Marketing, Financial Management, Tourism, or Food and Beverage. </p>
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">

                    For more information, visit us at: <a href="https://business.cornell.edu/hanga-ahazaza/" style="text-decoration: none;"> <b>https://business.cornell.edu/hanga-ahazaza/</b></a>
                    </p>
                  </div>
             
             </div>
                    </div>
                    <div class="carousel-item">
               <div class="row">
                  <!--  <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>   -->      
                  <div class="col-md-2" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/question_coffee.png"); ?>
                             </div>
                  </div>
                 
                  <div class="col-md-10" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">Question Coffee Cafe is a state-of-the-art specialty coffee cafe located in Kigali. We source exceptional coffees from farmers throughout Rwanda, honoring their to dedication quality through our expert roasting and brewing techniques. By working with farmers in-country, we're able to have unparalleled insight into their farming practices and livelihoods and use this proximity to the source to elevate our coffee quality and sustainability impact.</p><p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">
                    Along with different kinds of experiences, we also offer the Barista Training that will bring a true specialty coffee experience to your business. A talented barista is key to bringing the amazing flavors found in Question Coffee to life. Our barista instructors are ready to train your or your staff on the ins-and-outs of coffee brewing, latte art, espresso machine operation, and the story behind our coffees so that you can create a great customer experience. 
                    </p>
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">
                    Want to know more? Visit us at:<a href="http://www.questioncoffee.com" style="text-decoration: none;"> <b> www.questioncoffee.com </b></a>
                  </div>
             
             </div>
                    </div>
                    <div class="carousel-item">
                         <div class="row">
                  <!--  <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>   -->      
                  <div class="col-md-2" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/rwanda_polytechnic.png"); ?>
                             </div>
                  </div>
                 
                  <div class="col-md-10" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">     Rwanda Polytechnic envisions to provide quality education that complies with applicable standards through vocational education that enables beneficiaries to acquire skills required to create jobs and compete in the labour market. </p>
                    <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">

                      There are 8 IPRC colleges within RP, and amongst them, IPRC Musanze, IPRC Ngoma and IPRC Karongi offer education programme in Hospitality management, and IPRC Kitabi provides the academic curriculum in Tourism. </p>
                      <p style="border: 0px solid #053eff; font-size: 15px;text-align: justify;">

                      Want to know more: Visit:<a href="https://www.rp.ac.rw " style="text-decoration: none;"> <b>  www.rp.ac.rw </b></a> 
                    </p>
                  </div>
             
             </div>
                    </div>
                    
                  </div>
                  
                  <!-- Left and right controls -->
                  <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </a>
                </div>
                    </div>
</section><br><br>
<!--=====-->
<!--======================-->

<!--========================================-->
<!--=====-->

<section class="welcome__note" tabindex="0">
            <div class="kora-container recent__oppp-wrp"><h2>Chamber of Tourism Services</h2></div><br>
    <div class="kora-container welcome__note-wrp" id="wlm_note">
      <div class="col-md-3" style="background-color: light;  border: 0px solid #458cfe; width: 270px;">
                          <div><br>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/3Chamber_of_Tourism.png"); ?></div>
                             
                  </div>
                  <div class="col-md-9" background-color="red" style="background-color: light;  " align="center">
                   <p style="border: 0px solid #458cfe; font-size: 15px;text-align: justify;" >
                      Chamber of Tourism – The Rwanda Chamber of Tourism is the apex body for all private sector tourism establishments in Rwanda. It  is one of the 10 professional chambers that currently exist under the umbrella of the Private Sector Federation (PSF). It was established in 2006 with the mandate of enhancing business opportunities through effective lobbying and advocacy for tourism and hospitality in Rwanda. </p><p style="border: 0px solid #458cfe; font-size: 15px;text-align: justify;" >

                      It consists of Rwanda Safari Guides Association(RSGA), Rwanda Hospitality Association(RHA), Rwanda Tour and Travel agencies(RTTA), Rwanda Association of Tour Agencies (RATA),and Rwanda Tourism and Hospitality Educators Association (RTHEA).</p><p style="border: 0px solid #458cfe; font-size: 15px;text-align: left;" >

                      Want to know more? Contact us:<a href="mailto:rwandatourismchamber@gmail.com" style="text-decoration: none;"> <b>  rwandatourismchamber@gmail.com</b></a> 
                       |<a href="tel:+250 788 332 220" style="text-decoration: none;"> <b> +250 788 332 220</b></a>
                    </p>
                </div>

    </div>
</section>
<!--=====-->
<!--======================-->
<!--========================================-->
<!--=====-->
<!--=====-->
<section class="welcome__note" tabindex="0">
            <div class="kora-container recent__oppp-wrp"><h2>Testimonials</h2><br></div>
    <div class="kora-container welcome__note-wrp" id="wlm_note">


                <div id="demo" class="carousel slide" data-ride="carousel"><br>
                 

                 <!-- The slideshow -->
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                          <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-4" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/ellie.jpg"); ?>
                             </div>
                  </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "When young people choose Tourism as part of their educational curricula, they make the right choice. As this industry becomes more and more professional, there is opportunity everywhere. Rwanda invests heavily to promote Tourism, which means that the numbers of visitors will increase steadily. So the young people who grasp this opportunity and receive formal trainings in TVET and other institutions that provide Tourism curricula will benefit tremendously in the long run."<br><br><b> – Elie Niyitega, Assistant Lecturer, IPRC Kitabi</b>
                    </p>
                </div>
              <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
            </div>
                    </div>
                    <div class="carousel-item">
                         <div class="row">
                          <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-4" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/gisele.jpg"); ?>
                             </div>
                  </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "Vatel offers both theoretical and practical opportunities for students to learn. So this helps us to gain knowledge and industrial skills at the same time. I have interned with some of the top hotels and an event company in Rwanda. And this was possible because of Vatel."<br><br><b> – Gisele Ikuzwe, Student, Vatel Rwanda</b>
                    </p>
                </div>
              <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
            </div>
                    </div>
                    <div class="carousel-item">
                         <div class="row">
                          <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-4" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/scovia.jpg"); ?>
                             </div>
                  </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "I have been able to gain more knowledge about this industry through the Hospitality Management course offered by Cornell. This has also resulted in me being able to elevate my company."<br><br><b> – Scovia Mutoni, Co-Founder of Transinvest Tours & Travel Ltd</b>
                    </p>
                </div>
              <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
            </div>
                    </div>
                    <div class="carousel-item">
                         <div class="row">
                          <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-4" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/immaculate.jpg"); ?>
                             </div>
                  </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "When you decide to join this industry, you need to have the passion and eagerness. When you love what you do, you can offer high-quality service to your clients."<br><br><b> – Immaculate Kobusingye, Trainer in Housekeeping Operations</b>
                    </p>
                </div>
              <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
            </div>
                    </div>

                  <div class="carousel-item">
                         <div class="row">
                          <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                        <div class="col-md-4" style="background-color: light;  border: 0px solid #053eff;">
                          
                              <div>
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/Perpetue_Mukamusinga.jpg"); ?>
                             </div>
                        </div>
                        <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                        <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "To be a Barista, you need skills and practical experience to ensure that coffee retains its quality in the cup. That is why training is essential. The training that Question Coffee offers improve the skills level of youth in Rwanda in the preparation of coffee from foundation to a professional level."<br><br><b> – Perpetue Mukamusinga, SCA Certified Barista Trainer</b>
                    </p>
                    </div>
                    <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                      </div>
                </div>

                  </div>
                  
                  <!-- Left and right controls -->
                  <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </a>
                </div>
                    </div>
</section><br><br>
<!--=====-->
<!--======================-->
<!--=====-->
<section class="welcome__note" tabindex="0">
    <div class="kora-container welcome__note-wrp" id="wlm_note">
        <div class="Welc_opportunities" tabindex="0">
            <h2>Career Guidance in the Tourism and Hospitality</h2>
        <!-- <div class="Welc_note" tabindex="0" > -->
            <div class="opp_cardsholder">
              
                
               <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/1CG1.jpg", ['alt' => 'Opportunity icon']); ?>
        <br>
        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;">  
        <p align="Left" style="padding-right: 30px;padding-left: 30px;"><br>   
    Do you want to know about the educational institutions and the private sector in Rwanda offering Tourism and Hospitality opportunities?
            </p>
        <p align="center" style="background-color: transparent;border: none;border-radius: 3px;font-size: .75rem;font-family: sansRegular;color: #053eff;border: 1px solid #97a4ff;padding: 6px 12px;width: 100px;margin: 0 auto;transition: all 200ms ease-in-out;">
                    <?= Html::a(
                        'Learn More',
                        ['site/careerchoice']
                    )
                    ?>
        </p>
        <br>
    </div>
        </div>
      </div>
        <!-- </div> -->
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
<!--================-->
<?php } else { ?><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <div class="modal" id="myModal">

        <div class="modal-dialog modal-lg"><br><br><br><br>

            <div class="modal-content">

               <div class="modal-body">

                    <p>If you have account on Kora please
                                <?php
                                echo Html::a(
                                    'LOGIN HERE',
                                    ['user/sign-in/login'],
                                    ['tabindex' => -1]
                                )
                                ?> to know more about Tourism and Hospitality Sector</p><br><br>

                        <p>If you don't have account please
                                <?php
                                echo Html::a(
                                    'CREATE ACCOUNT',
                                    ['site/createaccount'],
                                    ['tabindex' => -1]
                                )
                                ?></p>
                </div>

            </div>

        </div>

    </div>



</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

    $(document).ready(function() {

        $("#myModal").modal('show');

    });

</script>

<?php }?>
<!--================-->