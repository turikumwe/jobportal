<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\user\models\LoginForm;
use common\models\JsJobApplication;

$this->beginContent('@frontend/views/layouts/_clear.php');

$this->title = "Jobportal";

$giz = Yii::$app->request->baseUrl . '/storage/source/1/gizlogo.png';

$model = new LoginForm();
$job_application_model = new JsJobApplication();
?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <?= $this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@storageUrl') . "/source/1/kora.png"]); ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@staticUrl') ?>/images/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/animate.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/style.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/step.css">

    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/jquery-3.4.1.min.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/owl.carousel.min.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/nav.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/main.js"></script>

</head>
<div class="pxp-preloader"><span>Loading...</span></div>

<?php echo $content ?>

<?php include('footer.php'); ?>
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

                <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => Yii::getAlias('@frontendUrl') . "/user/sign-in/login", 'class' => 'mt-4']); ?>
                <div class="form-floating mb-3">
                    <div class="form-floating mb-3">
                        <?php echo $form->field($model, 'identity') ?>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <?php echo $form->field($model, 'password')->passwordInput(); ?>
                </div>
                <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn rounded-pill pxp-card-btn', 'name' => 'login-button']) ?>
                <div class="mt-4 text-center pxp-modal-small">
                    <a href="<?= yii\helpers\Url::to(['/user/sign-in/request-password-reset']); ?>" class="pxp-modal-link">Forgot password</a>
                </div>
                <div class="mt-4 text-center pxp-modal-small">
                    New to Kora? <a role="button" class="" data-bs-target="#pxp-signup-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Create an account</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade pxp-user-modal" id="application-modal" aria-hidden="true" aria-labelledby="ApplicationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title mt-4" id="signinModal">Submit your job application</h5>

                <?php $application_form = ActiveForm::begin(['id' => 'login-form', 'action' => Yii::getAlias('@frontendUrl') . "/service/service-job/apply", 'class' => 'mt-4']); ?>
                <input type="hidden" id="selected_job_id" name="job_id" value="" />
                <input type="hidden" id="user_id" name="user_id" value="<?= Yii::$app->user->id ?>" />
                <div class="form-floating mb-3">
                    <div class="form-floating mb-3">
                        <div class="form-group field-jsjobapplication-motivation">
                            <label class="control-label" for="jsjobapplication-motivation">Cover letter</label>
                            <textarea id="jsjobapplication-motivation" class="form-control" name="motivation" rows="6"></textarea>

                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <?php echo Html::submitButton(Yii::t('frontend', 'Submit application'), ['class' => 'button btn-success', 'name' => 'login-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade pxp-user-modal" id="incomplete-profile-modal" aria-hidden="true" aria-labelledby="IncompleteProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title mt-4" id="signinModal">Incomplete profile</h5>
                <br />
                Your account profile is incomplete. <a href="<?= Yii::getAlias('@frontendUrl') . '/jobseeker/user-profile'; ?>">Click here</a> to complete your profile
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function set_selected_job(job_id) {
        $('#selected_job_id').val(job_id);
    }
</script>
