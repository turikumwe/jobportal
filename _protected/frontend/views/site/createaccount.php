<?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
<section class="pxp-hero vh-50" style="background-color:#ffffff;  ">
    <div class="pxp-hero-caption">
        <div class="pxp-container"  >
            <div class="row pxp-pl-60 align-items-center "   > 
                <div class="col-xl-6 col-xxl-5">
                    <h2>Create Your Kora Account<br><span style="color: var(--pxpMainColor);"></h2>
                    <div class="pxp-hero-subtitle mt-3 mt-lg-4">Welcome to the Create Account page,
                        What account do you want to create?  </div>

                </div>
                <div style="width: 190px; height: 190px" class="col-4 col-md-4 col-lg-3 col-xxl-2 pxp-categories-card-1-container">
                    <a href="<?= Yii::$app->link->frontendUrl('/jobseeker/register') ?>" class="pxp-categories-card-1">
                        <div class="pxp-categories-card-1-icon-container">
                            <div style="background-color:#0000CD" class="pxp-categories-card-1-icon">
                                <span class="fa fa-bullhorn"></span>
                            </div>
                        </div>
                        <div class="pxp-categories-card-1-title" >Jobseeker </div>

                    </a>
                </div>
                <div style="width: 190px; height: 190px" class="col-4 col-md-4 col-lg-3 col-xxl-2 pxp-categories-card-1-container">
                    <a href="<?= Yii::$app->link->frontendUrl('/employer/register') ?>" class="pxp-categories-card-1">
                        <div class="pxp-categories-card-1-icon-container">
                            <div style="background-color:#0000CD" class="pxp-categories-card-1-icon">
                                <span class="fa fa-address-card-o"></span>
                            </div>
                        </div>
                        <div class="pxp-categories-card-1-title">Employer</div>

                    </a>
                </div>
                <div style="width: 190px; height: 190px"  class="col-4 col-md-4 col-lg-3 col-xxl-2 pxp-categories-card-1-container">
                    <a href="<?= Yii::$app->link->frontendUrl('/mediator/register') ?>" class="pxp-categories-card-1">
                        <div class="pxp-categories-card-1-icon-container">
                            <div style="background-color:#0000CD" class="pxp-categories-card-1-icon">
                                <span class="fa fa-calendar-o"></span>
                            </div>
                        </div>
                        <div class="pxp-categories-card-1-title">Job Agent</div>

                    </a>
                </div>

            </div>
        </div>
    </div>

</section>


