<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Recommendation');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
    <div class="col-sm-5 border border-primary" style="background: #fff; padding: 20px;">
        <div  style="background: #f3f3f3; padding: 20px">
            <div class="site-login login">
                <center><h4>If you have an account sign in first <i class="glyphicon glyphicon-arrow-down"></i></h4></center>
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <?php echo $form->field($model, 'identity') ?>
                        <?php echo $form->field($model, 'password')->passwordInput() ?>
                        <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                        <div style="color:#999;margin:1em 0">
                            <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                                'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>                          
                    <?php ActiveForm::end(); ?>  
            </div>
        </div>
    </div>

    <div class="col-sm-6"  style="background: #fff; padding: 20px">
        <div   style="background: #f3f3f3; padding: 20px">
            <div class="site-login login">
                <center><h4>If you don't have an account sign up first <i class="glyphicon glyphicon-arrow-down"></i></h4></center>
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <?= $form->field($signup, 'username') ?>
                        <?= $form->field($userProfile, 'firstname')->textInput() ?>
                        <?= $form->field($userProfile, 'lastname')->textInput() ?>
                        <?= $form->field($signup, 'email')->textInput(['value'=> $email]) ?>
                        <?= $form->field($signup, 'password')->passwordInput() ?>
                        <?= $form->field($signup, 'repeat_password')->passwordInput() ?> 
                        <?= $form->field($signup, 'phone')->textInput() ?>
                        <div class="form-group">
                            <?php echo Html::submitButton(Yii::t('frontend', 'Sign up'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>                          
                    <?php ActiveForm::end(); ?>  
            </div>
        </div>
    </div>
</div>

