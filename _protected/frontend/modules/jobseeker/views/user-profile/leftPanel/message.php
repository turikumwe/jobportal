<?php 
use yii\helpers\Html;
use yii\bootstrap\Modal;
use common\models\JsMessage;
?>

<div class="panel widget light-widget panel-bd-top">
	<div class="panel-heading"><?= Yii::t("frontend","Messages") ?> </div>
	<div class="panel-body">
		<table class="table table-striped table-hover">
			<tbody>
				<!-- <tr>
					<th colspan="2"><center>Messages</center></th>
				</tr> -->
				<tr>
					<td style="width:40%;">
						Inbox 
					</td>
					<td align="center">
						<span><?= JsMessage::find()->received()->new()->count()?></span>
					</td>
				</tr>
				<tr>
					<td style="width:40%;">
						Sent 
					</td>
					<td align="center">
						<span><?= JsMessage::find()->sent()->count()?></span>
					</td>
				</tr>
				<tr>
					<td style="width:40%;">
						Trash 
					</td>
					<td align="center">
						<span><?= JsMessage::find()->sent()->deleted()->count()?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php if(!isset($_GET['js'])) { 
					   		 include('recommandationButton.php');
					    } ?> 
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>