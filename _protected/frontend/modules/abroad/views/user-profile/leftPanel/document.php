<?php 
use yii\helpers\Html;
use yii\bootstrap\Modal;
$id = (isset($_GET['idOtherProfile'])) ? $_GET['idOtherProfile'] : Yii::$app->user->id;
?>

<div class="panel widget light-widget panel-bd-top">
<div class="panel-heading"> <?= Yii::t("frontend","Documents") ?></div>
	<div class="panel-body">
		<table class="table table-hover">
		<tbody>
			<tr style="background-color: #F1F5F8"><th colspan="2">CV</th></tr>
			<tr>
				<td>
					Uploaded
				</td>

				<td>
					<?php if (isset($jobseeker->jsSummaries[0]->id)){
						if(!isset($jobseeker->jsSummaries[0]->cv_path)){
					   	$summarModel = $jobseeker->jsSummaries[0];
					   	Modal::begin([
						   			'options' => [
								        'tabindex' => false // important for Select2 to work properly
								    ],
		                          'header' => 'Update CV',
		                          "class" => "vd_bg-green", 
		                          'toggleButton' => [
		                          	'class' => 'btn vd_btn btn-xs vd_bg-green',
		                          	'label' => '<i class="glyphicon glyphicon-edit" aria-hidden="true"></i> Upload CV'
		                          ],
		                          'footer'=> ''
		                                //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
		                      ]);
			                     echo $this->render('/js-summary/_formCV', [
			                            'model' => $summarModel,
			                            'url'   => '/jobseeker/js-summary/update?id='.$summaryModel->id
			                        ]);  
		                    Modal::end(); 
						} else { 
							echo '<a class="btn btn-success" target="_blank" href='.Yii::getAlias('@storageUrl') .'/source/'.$jobseeker->jsSummaries[0]->cv_path.'><i class="fa glyphicon glyphicon-download"></i> Download</a>' ;
						}
					
					}else {
						echo '<center><code>No CV</code></center>';
					}
		 
					?>
				</td>
			</tr>
			<tr>
				<td>
					Generated
				</td>
				<td>
					<?=              
					Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . Yii::t('app', 'PDF'),  
					['pdf', 'id' => $id], 
					[ 
					'class' => 'btn btn-sm btn-danger', 
					'target' => '_blank', 
					'data-toggle' => 'tooltip', 
					'title' => Yii::t('app', 'Will open the generated PDF file in a new window') 
					] 
					)?>
				</td>
			</tr>

			<tr>
				<td>
					Generated
				</td>
				<td>
					<?=              
					Html::a('<i class="fa glyphicon glyphicon-hand-down"></i> ' . Yii::t('app', 'HTML'),  
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
</div>