<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\user\models\LoginForm;

$this->beginContent('@frontend/views/layouts/_clear_dashboards.php');

$this->title = "Jobportal";

$giz = Yii::$app->request->baseUrl . '/storage/source/1/gizlogo.png';

$model = new LoginForm();
?>
<?php include('header_styles.php'); ?>
<div class="pxp-preloader"><span>Loading...</span></div>

<?php echo $content ?>

<?php $this->endContent() ?>

<div class="modal fade pxp-user-modal" id="pxp-signin-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="pxp-user-modal-fig text-center">
                    <img src="<?= Yii::getAlias('@staticUrl') ?>/images/signin-fig.png" alt="Sign in">
                </div>
                <h5 class="modal-title text-center mt-4" id="signinModal">Welcome back!</h5>
                <form class="mt-4">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="pxp-signin-email" placeholder="Email address">
                        <label for="pxp-signin-email">Email address</label>
                        <span class="fa fa-envelope-o"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="pxp-signin-password" placeholder="Password">
                        <label for="pxp-signin-password">Password</label>
                        <span class="fa fa-lock"></span>
                    </div>
                    <a href="jobseeker-dashboard.html" class="btn rounded-pill pxp-modal-cta">Continue</a>
                    <div class="mt-4 text-center pxp-modal-small">
                        <a href="#" class="pxp-modal-link">Forgot password</a>
                    </div>
                    <div class="mt-4 text-center pxp-modal-small">
                        New to Kora? <a role="button" class="" data-bs-target="#pxp-signup-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Create an account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
