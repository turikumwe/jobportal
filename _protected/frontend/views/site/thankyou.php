<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en" class="pxp-root">
    <head>


        <title>Jobportal - Account Created</title>
    </head>
    <body>
        <div class="pxp-preloader"><span>Loading...</span></div>

        <header class="pxp-header fixed-top">
            <div class="pxp-container">
                <div class="pxp-header-container">
                    <?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
                </div>
            </div>
        </header>
        <section class="pxp-hero vh-100" style="background-color: var(--pxpMainColorLight);">
            <div class="row align-items-center pxp-sign-hero-container">
                <div class="col-xl-6 pxp-column">
                    <div class="pxp-sign-hero-fig text-center pb-100 pt-100">
                        <h5 class="text-center">Dear</h5>
                        <h1 class="mt-4">Rugamba</h1>
                    </div>
                </div>
                <div class="col-xl-6 pxp-column pxp-is-light">

                    <div class="pxp-sign-hero-form pb-100 pt-100">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-xl-7 col-xxl-5">
                                <div class="pxp-sign-hero-form-content">
                                    <h5 class="text-justify">Your account has been successfully created. After its review, you will be notified on account activation</h5>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>





    </body>
</html>