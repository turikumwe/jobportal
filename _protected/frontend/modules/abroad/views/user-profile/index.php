<?php

use kartik\typeahead\TypeaheadBasic;
use common\models\JsRecommendation;
use frontend\assets\FrontendAsset;
use trntv\filekit\widget\Upload;
use common\models\JsExperience;
use kartik\typeahead\Typeahead;
use kartik\widgets\SwitchInput;
use common\models\UserProfile;
use common\models\JsEducation;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\JsEndorse;
use common\models\JsAddress;
use common\models\JsSkill;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Profile');

$side = (Yii::$app->user->can('employer') || Yii::$app->user->can('mediator')) ? 'admin' : '';
?>
<div class="kora-container vd_content-section clearfix">
	<div id='search'>
		<div class="row">
			<div class="col-sm-3">
				<?= Yii::$app->jobSeeker->profile($jobseeker); ?>
				<?php include("leftPanel/message.php") ?>
				<?= Yii::$app->jobSeeker->menu(); ?>
			</div>

			<div class="col-sm-6">
				<div class="tabs widget">
					<ul class="nav nav-tabs widget">
						<li>
							<a href="<?= Yii::$app->link->frontendUrl('/jobseeker/user-profile/' . $side) ?>">
								<i class="glyphicon glyphicon-home"></i>
							</a>
						</li>
						<li class="active">
							<a data-toggle="tab" href="#profile-tab"> Profile
								<span class="menu-active">
									<i class="glyphicon glyphicon-triangle-top"></i>
								</span>
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#message-tab"> Messages <span class="menu-active"><i class="glyphicon glyphicon-triangle-top"></i></span> </a>
						</li>
					</ul>

					<div class="tab-content">
						<div id="profile-tab" class="tab-pane active">
							<div class="pd-20">

								<?php
								include('identification.php');

								if (isset($_GET['idOtherProfile'])) {
									if ($jobseeker->userProfile->show_profile_summary) {
										include('summary.php');
									}

									if ($jobseeker->userProfile->show_experience) {
										include('experience.php');
									}

									if ($jobseeker->userProfile->show_education) {
										include('education.php');
									}

									if ($jobseeker->userProfile->show_training) {
										include('training.php');
									}

									if ($jobseeker->userProfile->show_language) {
										include('language.php');
									}

									if ($jobseeker->userProfile->show_skill) {
										include('skills.php');
									}

									if ($jobseeker->userProfile->show_contact) {
										include('address.php');
									}

									if ($jobseeker->userProfile->show_drivinglicense) {
										include('drivinglicense.php');
									}

									if ($jobseeker->userProfile->show_endorsement) {
										include('endorse.php');
									}

									if ($jobseeker->userProfile->show_recommendation) {
										include('recommandation.php');
									}
									if (Yii::$app->user->can('mediator')) {
										include('casemanagement.php');
									}
								} else {
									include('summary.php');
									include('skills.php');
									include('address.php');
									include('training.php');
									include('language.php');
									include('education.php');
									include('experience.php');
									include('drivinglicense.php');
									include('endorse.php');
									include('recommandation.php');
									//include('casemanagement.php');
								}

								?>
							</div>
						</div>
						<div id="message-tab" class="tab-pane">
							<?php include('message.php'); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-3">
				<?php if (Yii::$app->getSession()->hasFlash('recommendationAlert')) { ?>
					<div class="well <?= Yii::$app->getSession()->getFlash('recommendationAlert')["options"]["class"] ?>">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>&nbsp;&nbsp;
						</button>
						<center><b><?= Yii::$app->getSession()->getFlash('recommendationAlert')['body'] ?></b></center>
					</div>
				<?php } ?>
				<?= Yii::$app->jobSeeker->search(); ?>
				<?php include("leftPanel/document.php") ?>
				<?php include("notification.php") ?>
				<?php include("visibility.php") ?>
			</div>
		</div>
	</div>
</div>
<script>
	function remove(id, url, div) {

		let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

		if (confirm("Are you sure?.")) {
			$.ajax({
				type: "POST",
				url: FRONTEND_BASE_URL + "/jobseeker/" + url + "/delete?id=" + id,
				dataType: "json",
				success: function(data) {
					$("#" + div).load(" #" + div);
				}
			});
		}
	}

	function search(idOtherProfile) {

		let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";
		window.location.href = FRONTEND_BASE_URL + "/jobseeker/user-profile/index?idOtherProfile=" + idOtherProfile;

		//window.history.pushState("Profile", "Title", "/jobseeker/user-profile/index?idOtherProfile="+idOtherProfile);
		//$("#search").load(" #search");
	}
</script>