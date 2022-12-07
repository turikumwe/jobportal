<?php if(!isset($_GET['employer'])) { 
?>
	<div class="panel">
		<div class="panel-body">
			<center><a class="btn btn-success col-sm-12" 
				href="<?= Yii::$app->link->frontendUrl('/s-notifications')?>"><?= Yii::t("frontend","Notification Settings") ?></a></center>
		</div>
	</div>
<?php } ?>
