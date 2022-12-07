<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .howapply-wrp .howapply__cont .howapply__xpla li {
        list-style-type: initial;
        margin-left: 15px;
    }
</style>
<?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>


<section class="mt-100">
    <div class="pxp-container">
        <div class="row mt-4 justify-content-center">
            <div class="col-xxl-12">
                <div class="accordion pxp-faqs-accordion" id="pxpFAQsAccordion">
                    <div class="site-login login">

                        <div class="row">
                            <div class="col-lg-12" style="margin-top:100px">
                                <?php if (Yii::$app->getSession()->hasFlash('success')) { ?>
                                    <div class="alert alert-success fade in alert-dismissible show" style="margin-top:18px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="float: right;">
                                            <span aria-hidden="true" style="font-size:20px">×</span>
                                        </button>    
                                        <?= Yii::$app->getSession()->getFlash('success') ?>
                                    </div>
                                <?php } ?>
                                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                                <?php echo $form->field($model, 'identity') ?>
                                <?php echo $form->field($model, 'password')->passwordInput() ?>
                                <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                                <div style="color:#999;margin:1em 0">
                                    <?php
                                    echo Yii::t(
                                            'frontend',
                                            'If you forgot your password you can reset it <a href="{link}">here</a>',
                                            [
                                                'link' => yii\helpers\Url::to(['sign-in/request-password-reset'])
                                            ]
                                    )
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                </div>
                                <!-- <div class="form-group">
                                <?php //echo Html::a(Yii::t('frontend', 'Need an account? Sign up.'), ['signup']) 
                                ?>
                        </div> -->
                                <!-- <h2><?php echo Yii::t('frontend', 'Log in with') ?>:</h2>
                        <div class="form-group">
                                <?php
                                //echo yii\authclient\widgets\AuthChoice::widget([
                                //'baseAuthUrl' => ['/user/sign-in/oauth']
                                //]) 
                                ?>
                        </div> -->
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>