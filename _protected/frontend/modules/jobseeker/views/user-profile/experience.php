<?php 
use common\models\JsExperience;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
 
<div class="row profile">
<div  class="col-sm-12">

 

	<div id="experience" class="content-list content-menu responsive">
	  <table class='table table-bordered table-striped'>
	  	<?php if(!isset($_GET['js'])) { ?>
	  	<tr>
	  		<td colspan="5" style="text-align: left;">
	  				<?php
			   		$experienceModel = new JsExperience();
			   		Yii::$app->jobPortalModal
		   				 ->popup(
					   			$experienceModel, 
					   			"Experience",
					   			"green",
					   			"plus", 
					   			"/js-experience/_form", 
					   			"/jobseeker/js-experience/create",
					   			"Add" 			
		   			);
                ?>
	  		</td>
	  	</tr>
	  	<?php } ?>
	  	<tr>
	  		<th>Occupation</th>
	  		<th>Position</th>
	  		<th>startDate</th>
	  		<?php if (Yii::$app->user->can('user')) { ?>
	  		<th style="width: auto">Action</th>
	  		<?php } ?>
	  	</tr>
	  	<?php
            $experiences = $jobseeker->jsExperiences;			               
            foreach($experiences as $experience){
        ?>
           	<tr>
               <td><?= isset($experience->occupation->occupation) ? $experience->occupation->occupation: "-" ?></td>
               <td><?= $experience->exact_position;?></td>
               <td><?= $experience->start_date?></td>
               <?php if (Yii::$app->user->can('user')) { ?>
               <td  class="pxp-dashboard-table-options">
               	<a href="#">
               		<?php
					   	$experienceModel = JsExperience::find()->where(['id' => $experience->id])->one();
					   	Yii::$app->jobPortalModal->popup($experienceModel, "Experience","blue","fa fa-eye","/js-experience/_view");
		            ?>	
               	</a>
             	<?php if(!isset($_GET['js'])) { ?>
               	<a href="#">
               		<?php
					   	$experienceModel = JsExperience::find()->where(['id' => $experience->id])->one();
					   	Yii::$app->jobPortalModal
			   				 ->popup(
						   			$experienceModel, 
						   			"Experience",
						   			"green",
						   			"fa fa-edit", 
						   			"/js-experience/_form", 
						   			'/jobseeker/js-experience/update?id='.$experienceModel->id   			
			   			);
		                ?>	
               	</a>
               		<a href="#" style="background-color: #e9e9e9"  type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?')) window.location.href='removeitem?experienceid=<?=$experienceModel->id?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true"  ></button>
						</a>
               	<?php } ?>
               </td>
           		<?php  } ?>
       		</tr> 
        <?php  } ?>
	  </table>
	</div>
  
   
</div>
</div>
<script>
	function hideAndShowExperience(){
	
	let column = "show_experience";
	let variable = $("#input_experience").val();
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