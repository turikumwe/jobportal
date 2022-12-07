<?php 
use yii\helpers\Html;
?>

<div class="panel widget light-widget panel-bd-top">
<div class="panel-heading no-title"> </div>
	<div class="panel-body">
		<table class="table table-striped table-hover">
		<tbody>
			<tr>
				<td>
					CV
				</td>
				<td>
					<?= (isset($jobseeker->jsSummaries[0]->cv_base_url)) 
					? '<a href='.$jobseeker->jsSummaries[0]->cv_base_url.'/'.$jobseeker->jsSummaries[0]->cv_base_url.'>Download</a>' 
					: '<center><code>No CV</code></center>' 
					?>
				</td>
			</tr>
			<tr>
				<td>
					Genarated CV
				</td>
				<td>
					<?=              
					Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . Yii::t('app', 'PDF'),  
					['pdf', 'id' => Yii::$app->user->id], 
					[ 
					'class' => 'btn btn-sm btn-danger', 
					'target' => '_blank', 
					'data-toggle' => 'tooltip', 
					'title' => Yii::t('app', 'Will open the generated PDF file in a new window') 
					] 
					)?>
				</td>
			</tr>
		</tbody>
		</table>
</div>
</div>