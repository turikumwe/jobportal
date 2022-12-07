<?php 
use common\models\JsTraining;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
<div  class="col-sm-12">
<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-book"></i> Training</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></div>",     // template content icon
'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i></div>",   // template content icon
]);?>
  
	<div id="training" class="content-list content-menu">
		<table class='table table-bordered table-striped'>
		   	<?php if(!isset($_GET['idOtherProfile'])) { ?>
		   	<tr>
		   		<td colspan="7" style="text-align: left;">
					<?php
				   		$trainingModel = new JsTraining();
				   		Yii::$app->jobPortalModal
				   				 ->popup(
							   			$trainingModel, 
							   			"Add training",
							   			"green",
							   			"plus", 
							   			"/js-training/_form", 
							   			"/jobseeker/js-training/create",
							   			"Add"	
				   			);
	                ?>
		   		</td>
		   	</tr>
		   	<?php } ?>
			<tr>
		  		<th>Training center</th>
		  		<th>Training title</th>
		  		<th>Certificate</th>
		  		<?php if (Yii::$app->user->can('user')) { ?>
		  		<th style="width: auto">Action</th>
		  		<?php } ?>
		  	</tr>
		  	<?php
	            $trainings = $jobseeker->jsTrainings;			               
	            foreach($trainings as $training){
	        ?>
	           	<tr>
					<td><?= $training->training_center;?></td>
					<td><?= $training->training_title;?></td>
					<td>
	               	<?= isset($training->certificate_path) ? '<a class="btn btn-success" target="_blank" href='.Yii::getAlias('@storageUrl') .'/source/'.$training->certificate_path.'><i class="fa glyphicon glyphicon-download"></i>Download</a>' : "<center><code>No Certificate</code></center>" ;?>
	               </td>    
					<?php if (Yii::$app->user->can('user')) { ?>         
					<td>
	               	<a href="#">
	               		<?php
						   	$trainingModel = JsTraining::find()->where(['id' => $training->id])->one();
						   	Yii::$app->jobPortalModal->popup($trainingModel, "View training","blue","eye-open","/js-training/_view");
	   					?>
	               	</a>
	             	<?php if(!isset($_GET['idOtherProfile'])) { ?>
	               	<a href="#">
	               		<?php				   	
						  	$trainingModel = JsTraining::find()->where(['id' => $training->id])->one();
						   	Yii::$app->jobPortalModal
				   				 ->popup(
							   			$trainingModel, 
							   			"training",
							   			"green",
							   			"edit", 
							   			"/js-training/_form", 
							   			'/jobseeker/js-training/update?id='.$trainingModel->id
					 		);
			            ?>
	               	</a>
	               	<a href="#training" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $training->id?>", js-training","training")'>
	               		<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
	               	</a>
	               	<?php } ?>
	               </td>
	               <?php } ?>
	       		</tr> 
	        <?php  } ?>	  	
	  	</table>
	</div>            
  
  <?php kak\widgets\fieldset\FieldSet::end(); ?>
</div>
</div>	
<script>
	function hideAndShowTraining(){
	
	let column = "show_training";
	let variable = $("#input_training").val();
	let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>"; 

	$.ajax({
	        type: "POST",
	        url: FRONTEND_BASE_URL+"/jobseeker/user-profile/hide-and-show?variable="+variable+"&column="+column,
	        dataType: "json",
	        success: function(data){ 
	           
	        }
	});

	}
</script>