<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\JsEJobApplication */
?>
<style>
	.modal-header {
		background-color: #e3e3e3;
	}

	 .modal-footer {
        position:absolute;
        bottom:10;
        left:0;
        right:0;
        background-color: #e3e3e3;
        height: 50px;
    }

    .modal-dialog {
        position:absolute;
        top:40% !important;
        transform: translate(0, -50%) !important;
        -ms-transform: translate(0, -50%) !important;
        -webkit-transform: translate(0, -50%) !important;
        margin:auto 20%;
        width:60%;
        height: 500px;

    }

</style>
<div class="js-job-application-update">
    <div class="well">
        <?= $this->render('_placement', [
            'application_id' => $application_id,
            'applicationjob' => $applicationjob,
            'applicationevent' => $applicationevent,
            'user_id' => $user_id,
            'model' => $model,
            'get'   => $get,
            'url' => $url
        ]) ?>
    </div>
    <br>

</div>
