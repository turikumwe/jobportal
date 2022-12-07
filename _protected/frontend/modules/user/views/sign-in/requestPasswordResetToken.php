<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\PasswordResetRequestForm */

$this->title = Yii::t('frontend', 'Request password reset by email');
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
                    <div class="site-request-password-reset login">
                        <?php if (Yii::$app->getSession()->hasFlash('alert')) { ?>
                            <div class="<?= Yii::$app->getSession()->getFlash('alert')["options"]["class"] ?>">
                                <center><?= Yii::$app->getSession()->getFlash('alert')['body'] ?></center>
                            </div>
                        <?php } ?> 
                        <b><?php echo Html::encode($this->title) ?></b>

                        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?><br>
                        <div class="row">
                            <div class="col-lg-5"><?= $form->field($model, 'email') ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"></div>
                        </div>
                        <br />
                        <div class="form-group">
                            <?php echo Html::submitButton(Yii::t('frontend', 'Send'), ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>