<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

// $this->title = Yii::t('frontend', 'Job seeker registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kora-modal-content">
    <div class="login__wrp">
        <div class="login">
            <h2>Job seeker registration</h2>

            <?php if (Yii::$app->getSession()->hasFlash('alert')) { ?>
                <div class="<?= Yii::$app->getSession()->getFlash('alert')["options"]["class"] ?>">
                    <p><?= Yii::$app->getSession()->getFlash('alert')['body'] ?></p>
                </div>
            <?php } ?>

            <?php
            $form = ActiveForm::begin([
                'id' => 'form-register-jobseeker',
                'options' => ['enctype' => 'multipart/form-data']
            ])
            ?>

            <?php include('userForm.php'); ?>

            <?php include('identificationForm.php'); ?>

            <?php include('educationForm.php'); ?>

            <?php include('employmentForm.php'); ?>

            <?php echo Html::submitButton(Yii::t('frontend', 'Register'), ['class' => 'button', 'name' => 'register-button']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>