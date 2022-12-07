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
<!--========================================-->
<!--=====-->
<!--========-->
<?php if (!Yii::$app->user->isGuest) { ?>
<!--======-->
<section class="welcome__note" tabindex="0">
            <div class="kora-container recent__oppp-wrp"><h2>Career Guidance in the Tourism and Hospitality</h2></div><br>
    <div class="kora-container welcome__note-wrp" id="wlm_note">

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
                <div id="demo" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
<!--                   <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                  </ul> -->

                 <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                           <div class="row">
                                      <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/_07kFQ8U3cQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Front Office</b></p>           
                                       <p align="Left" style="padding-right: 30px;padding-left: 30px;">
                                      Meet Zephaline Mujawamariya, and hear about her journey in the Hospitality industry

                                        </p>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/6Usc4Am9BDw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 25px;padding-left: 25px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in F&B Services</b></p>           
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                            
                                          Meet Victor Mberinkindi, F&B Supervisor, as he shares his story of working in the Hospitality industry

                                          </p>
        
                                      </div>
                                    </div>
                                    <div class="col-sm-4 bg-light">
                                         <iframe width="350" height="215" src="https://www.youtube.com/embed/DSvF4QLCqm8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 25px;padding-left: 25px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>           
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                           Meet Joan Umwiza, as she shares her story of working as a Tour Guide-Driver
                                        </p>
        
                                       </div>
                                      </div>
                            </div><br>
                            <div class="row">
                                        <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/-nngTK27gLY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 25px;padding-left: 25px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Hospitality </b></p>           
                                        <p align="Left" style="padding-right: 25px;padding-left: 25px;"> 
                                          
                                          Meet Darlene Umwiza, an Entrepreneur and Aspiring Chef, who shares her journey in the Hospitality Industry.

                                         </p>
        
                                       </div>
                                      </div>
                                      <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/ZGPadCQE3mQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 20px;padding-left: 20px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Housekeeping</b></p>           
                                        <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Alphonse Muhire, who tells us about his experience in Housekeeping Operations.
                                        </p>
                                            
                                       </div>
                                      </div>
                                      <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/fp2lSnRPW3I" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                            Meet Christian and learn about his journey in Toursim and Hospitality industry

                                          </p>
        
                                      </div>
                                      </div>
                            </div>
                    </div>
                    <div class="carousel-item">
                            <div class="row">
                                      <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/M471uqQ4W7c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Gisele and learn about her journey
                                          </p>
        
                                      </div>
                                      </div>
                                      <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/YtwulK9KnzI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>           
                                       <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Jean Remy and learn about his journey

                                        </p>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/sBOhzt_Gw9A" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                            Meet Perpetue and learn about her journey
                                          </p>
        
                                      </div>
                                    </div>
                                    
                            </div><br>
                            <div class="row">
                                        <div class="col-sm-4 bg-light">
                                         <iframe width="350" height="215" src="https://www.youtube.com/embed/XfcDFF_iSa8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Darius and learn about his journey              
                                        </p><br>
        
                                       </div>
                                      </div>
                                        <div class="col-sm-4 bg-light">
                                         <iframe width="350" height="215" src="https://www.youtube.com/embed/8EDFMwYzNCs" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Bonita Mutoni, who shares her journey and insights into the Rwandan Hospitality Industry.
                                        </p>
        
                                       </div>
                                      </div>
                                        <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/s1zP3H4wah4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Emmanuel as he shares his story about how he ensures that he learns continuously. 
                                          </p>
        
                                      </div>
                                      </div>                                      
                            </div>
                    </div>
                    <div class="carousel-item">
                            <div class="row">
                                      <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/gP1A5Tycj3k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                       <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Gaddy Habumugisha, and know why enhancing your skills is essential.
                                        </p><br><br><br>
                                      </div>
                                    </div>

                                    <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/-Ch_O9Gfe6c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                       <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Ingrid Ishimirwe as she shares the story of her journey in the Tourism industry.
                                        </p><br><br>
                                      </div>
                                    </div>
                                        <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/dAw1Ev7OOOo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Andrew Gatera, as he shares his journey and insights of the Rwandan Tourism Industry, and the benefits of being a member of the Rwanda Chamber of Tourism. 
                                          </p>
        
                                      </div>
                                      </div>                                      
                            </div><br>


                            <div class="row">
                                    <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/aKlpqsCYl-w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>
                                       <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Theodore Nzabonimpa, as he shares his journey and insights of the Rwandan Tourism Industry, and the benefits of being a member of the Rwanda Chamber of Tourism.
                                        </p><br>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/KxTLK5xZsTc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                            Learn about how Tourism is a vehicle for empowerment, income-generation and integration from Young Women Destination, an organization that offers Community Based Tourism Experience.
                                          </p>
        
                                      </div>
                                    </div>
                                    <div class="col-sm-4 bg-light">
                                         <iframe width="350" height="215" src="https://www.youtube.com/embed/bEgHTcfpUHg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                           Meet Sandrine Uwayezu, Rwanda’s first professional female bicycle mechanic at an international level, as she shares the story of her journey in the Tourism industry.
                                        </p><br>
        
                                       </div>
                                      </div>
                            </div>                            
                    </div>
                    <!--============================-->
                    <div class="carousel-item">
                            <div class="row">
                                      <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/Bbr07-T0t3c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                       <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Cesar Niyonkuru, as he shares his insights about how Tourism supports in rural development.
                                        </p><br>
                                      </div>
                                    </div>

                                    <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/52jPjfMCaZA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>#UbakaEjoHaweHeza in Tourism</b></p>          
                                       <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Meet Kenny, as he shares his insights about why excellent customer service is essential for a thriving tourism and hospitality industry.
                                        </p>
                                      </div>
                                    </div>
                                        <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/c0B-fE00EVc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>Nature Tour Guide</b></p>           
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Learn more about working as a Nature Tour Guide 
                                          </p><br><br>
        
                                      </div>
                                      </div>                                      
                            </div><br>


                            <div class="row">
                                    <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/p6bcbVDDfXY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>Tour Operator</b></p>           
                                       <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Learn more about how to be a Tour Operator
                                        </p>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/IIp1DAd5qD4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>Hotel Manager</b></p>           
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                            Learn more about how you can be a Hotel Manager
                                          </p>
        
                                      </div>
                                    </div>
                                    <div class="col-sm-4 bg-light">
                                         <iframe width="350" height="215" src="https://www.youtube.com/embed/exPZ-8Dop-s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                      <div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>House Keeping </b></p>           
                                         <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                           Learn about Housekeeping Operations
                                        </p>
        
                                       </div>
                                      </div>
<!--                                         <div class="col-sm-4 bg-light">
                                        <iframe width="350" height="215" src="https://www.youtube.com/embed/kyna3TOW-WM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><div style="border: solid #1147ff;border-bottom-width:1px;border-left-width:1px;border-right-width:1px;border-top-width: 0px;width: 350px;margin-top: -7px;">
                                        <p style="color: #053eff;padding-right: 30px;padding-left: 30px;padding-top: 5px;"><b>Cook</b></p>           
                                        <p align="Left" style="padding-right: 30px;padding-left: 30px;"> 
                                          Learn about Culinary Arts<br> 
                                         </p>
        
                                       </div>
                                      </div> -->
                                    
                            </div>                            
                    </div>
                    <!--============================-->
                </div>
                  
                  <!-- Left and right controls -->
                  <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </a>
                </div>
                    </div><br>
</section>
<!--=====-->

<!--========================================-->
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
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/alphonse_muhire.jpg"); ?>
                             </div>
                  </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <br><br><p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "Housekeepers are the heart of the hotel. The job does not look at your gender, but the quality of your work. Youths need to change their mindset about gender roles. A man can be a Housekeeper and a woman can be a Chef."<br><br><b> – Alphonse Muhire, Room Attendant</b>
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
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/joan_umwiza.jpg"); ?>
                             </div>
                  </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <br><br><p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "My work and the opportunities I grasp cannot undermine me or change my value as a woman. If you know your potentials, take your opportunity because this industry deserves more women."<br><br><b> – Joan Umwiza, Tour Guide-Driver</b>
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
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/zephaline_mujawamariya.jpg"); ?>
                             </div>
                  </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <br><br><p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "You can be confident and join the tourism and hospitality sector. It has so much to offer to you professionally and personally."<br><br><b> – Zephaline Mujawamariya, Front Office Manager</b>
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
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/eric_rukundo.jpg"); ?>
                             </div>
                  </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                  <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <br><br><p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      "The Hospitality industry can positively change your life if you have a passion for it. The moment you decide to join this industry, be eager to learn, heighten your skills continuously and have a mindset for growth."<br><br><b> – Eric Rukondo, Senior Supervisor Food & Beverages</b>
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
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/darlene_umwiza.jpg"); ?>
                             </div>
                    </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                    <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <br><br><p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      “As young women, we can create our own platforms in this industry. When you work with passion, you will see long term and tangible benefits.”<br><br><b> – Darlene Umwiza, Aspiring Chef/Entrepreneur</b>
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
                              <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/careerfair/Darius_Nyirigango.jpg"); ?>
                             </div>
                    </div>
                   <div class="col-md-1" style="background-color: light;  border: 0px solid #053eff;">
                                                      
                        </div>
                    <div class="col-md-5" background-color="red" style="background-color: light; border: px solid #053eff;" align="center">
                    <br><br><p style="padding: 10px;border: 0px solid #053eff; font-size: 15px;text-align: left;" >
                      “The Barista Training provided by Question Coffee has equipped me with excellent Barista skills, knowledge, passion and focus. I also realized that Rwanda is among the countries with the best coffee, but we do not have a coffee culture. This inspired me to be an entrepreneur and share my knowledge with people who may not know much about coffee.”<br><br><b>– Darius Nyirigango, Barista Trainee & Co-founder at Coffee Box</b>
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
            <div class="opp_cardsholder">
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
<!-- <section class="welcome__note" tabindex="0">
            <div class="kora-container recent__oppp-wrp"><h2>Opportunities</h2></div>
    <div class="kora-container welcome__note-wrp" id="wlm_note">
    <div class="Welc_opportunities">
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
            </div>
    </div>
        <div class="Welc_opportunities">
           
            <div class="opp_cardsholder">
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
            </div>
    </div>
        <div class="Welc_opportunities">
           
            <div class="opp_cardsholder">
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
            </div>
    </div>
        <div class="Welc_opportunities">
           
            <div class="opp_cardsholder">
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
</section> -->
<!--=====-->
<!--======================-->
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