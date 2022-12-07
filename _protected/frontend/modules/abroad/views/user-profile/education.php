<?php 
use common\models\JsEducation;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
<div  class="col-sm-12">
	<?php kak\widgets\fieldset\FieldSet::begin([
	'legend' => Yii::t('app-dash', '<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-book"></i> Education</span>'),
	'active' => false,// false - hide content, default true
	'speed'  => 0, // animation speed default value 300
	'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></div>",     // template content icon
	'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i></div>",   // template content icon
	]);?>
	<div id="education" class="responsive">
		<table class='table  table-bordered table-striped'>
			<?php if(!isset($_GET['idOtherProfile'])) { ?>
			   	<tr>
			   		<td colspan="6" style="text-align: left;">
			   		<?php
				   		$educationModel = new JsEducation();
				   		Yii::$app->jobPortalModal
				   				 ->popup(
							   			$educationModel, 
							   			"Add Education",
							   			"green",
							   			"plus", 
							   			"/js-education/_form", 
							   			"/jobseeker/js-education/create",
							   			"Add"	
				   			);
	                ?>
			   		</td>
			   	</tr>
			<?php } ?>
		  	<tr>
		  		<th>School</th>
		  		<th>Education field</th>
		  		<th>Degree</th>
		  		<?php if (Yii::$app->user->can('user')) { ?>
		  		<th>Action</th>
		  		<?php } ?>
		  	</tr>
		  	<?php
	            $educations = $jobseeker->jsEducations;		               
	            foreach($educations as $education){
	        ?>
	           	<tr>
	               <td><?= $education->school;?></td>
	               <td><?= isset($education->educationField->field) ? $education->educationField->field : "-" ;?></td>
	               <td>
	               	<?= isset($education->certificate_path) ? '<a class="btn btn-success" target="_blank" href='.Yii::getAlias('@storageUrl') .'/source/'.$education->certificate_path.'><i class="fa glyphicon glyphicon-download"></i>Download</a>' : "<center><code>No Degree</code></center>" ;?>
	               </td>
	               <?php if (Yii::$app->user->can('user')) { ?>
	               <td>
	               	
	               	<a href="#">
	               		<?php
						   	$educationModel = JsEducation::find()->where(['id' => $education->id])->one();
						   	Yii::$app->jobPortalModal->popup($educationModel, "View Education","blue","eye-open","/js-education/_view");
			            ?>
	               	</a>
	             	<?php if(!isset($_GET['idOtherProfile'])) { ?>
	               	<a href="#">
	               		<?php				   	
						  	$educationModel = JsEducation::find()->where(['id' => $education->id])->one();
						   	Yii::$app->jobPortalModal
				   				 ->popup(
							   			$educationModel, 
							   			"education",
							   			"green",
							   			"edit", 
							   			"/js-education/_form", 
							   			'/jobseeker/js-education/update?id='.$educationModel->id
					 		);
		            	?>	
	               	</a>
	               	<a href="#education" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $education->id?>"js-education","education")'>
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
	function hideAndShowEducation(){
	
	let column = "show_education";
	let variable = $("#input_education").val();
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