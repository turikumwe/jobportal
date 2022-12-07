<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\JsEventApplication */
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
        margin:auto 30%;
        width:40%;

    }

</style>
<div class="js-event-application-update">
    <div class="well">
    <?= $this->render('_formUpdateApplication', [
        'model' => $model,
    ]) ?>
    </div>
    <br>
</div>
