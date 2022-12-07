<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('frontend', 'Mediator institution registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vd_content-section clearfix">
    
    
    <div class="row">
        <div class="col-sm-12">
        <div class="panel widget light-widget panel-bd-top">
        <div class="panel-heading no-title"> </div>
        <div class="panel-body">
        <div class="text-left vd_info-parent"> 
        <div class="site-register">
            <div class="well"> <h3><?php echo Html::encode($this->title) ?></h3></div>

            <div class="row">
                <div class="col-lg-12">
                        <?php $form = ActiveForm::begin(
                            [
                                'id' => 'form-register-jobseeker',
                                'enableClientValidation' => false,
                                'enableAjaxValidation'   => true,
                            ]); 
                        ?>

                        <div class="well"><?php include('userForm.php');?></div>

                        <div class="well"><?php include('identificationForm.php');?></div>

                        <div class="well"><?php include('mediatorAddressForm.php');?></div>

                        <div class="form-group">
                            <?php echo Html::submitButton(Yii::t('frontend', 'Register'), ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                        </div>
                        
                       
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        </div>
        </div>
        </div>
        </div>
        </div>
</div>

