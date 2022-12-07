<?php 
use yii\helpers\Html;
use yii\bootstrap\Modal;
$id = (isset($_GET['js'])) ? $_GET['js'] : Yii::$app->user->id;
?>

 
 
	<div class="panel-body">
		<table >
		<tbody>
			  
			<tr>
				 
				<td>
					<?=              
					Html::a('<i class="fa fa-hand-up"></i> ' . Yii::t('app', 'PDF'),  
					['pdf', 'id' => $id], 
					[ 
					'class' => 'btn btn-sm btn-danger', 
					'target' => '_blank', 
					'data-toggle' => 'tooltip', 
					'title' => Yii::t('app', 'Will open the generated PDF file in a new window') 
					] 
					)?>
				</td>
                                <td>
					<?=              
					Html::a('<i class="fa fa-hand-down"></i> ' . Yii::t('app', 'HTML'),  
					['pdf', 'id' => $id, 'html' => true], 
					[ 
					'class' => 'btn btn-sm btn-success', 
					'target' => '_blank', 
					'data-toggle' => 'tooltip', 
					'title' => Yii::t('app', 'Will open the generated HTML page in a new window') 
					] 
					)?> 
				</td>
			</tr>

			 
		</tbody>
		</table>
</div>
 