<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\ResetPasswordForm */

$this->title = Yii::t('frontend', 'Reset password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password login">
    <?php if (Yii::$app->getSession()->hasFlash('alert')) { ?>
        <div class="<?= Yii::$app->getSession()->getFlash('alert')["options"]["class"] ?>">
            <center><?= Yii::$app->getSession()->getFlash('alert')['body'] ?></center>
        </div>
    <?php } ?>
    
    <b><?php echo Html::encode($this->title) ?></b>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
            <br>
            <?php echo $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>