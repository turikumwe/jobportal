<?php 
use common\models\JsExperience;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
<div  class="col-sm-12">

<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-duplicate"></i> Professional Experience</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i> </div>",     // template content icon
'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i> </div>",   // template content icon
]);?>

	<div id="experience" class="content-list content-menu responsive">
	  <table class='table table-bordered table-striped'>
	  	<?php if(!isset($_GET['idOtherProfile'])) { ?>
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
               <td>
               	<a href="#">
               		<?php
					   	$experienceModel = JsExperience::find()->where(['id' => $experience->id])->one();
					   	Yii::$app->jobPortalModal->popup($experienceModel, "Experience","blue","eye-open","/js-experience/_view");
		            ?>	
               	</a>
             	<?php if(!isset($_GET['idOtherProfile'])) { ?>
               	<a href="#">
               		<?php
					   	$experienceModel = JsExperience::find()->where(['id' => $experience->id])->one();
					   	Yii::$app->jobPortalModal
			   				 ->popup(
						   			$experienceModel, 
						   			"Experience",
						   			"green",
						   			"edit", 
						   			"/js-experience/_form", 
						   			'/jobseeker/js-experience/update?id='.$experienceModel->id   			
			   			);
		                ?>	
               	</a>
               	<a href="#experience" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $experience->id?>", js-experience","experience")'>
               		<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
               	</a>
               	<?php } ?>
               </td>
           		<?php  } ?>
       		</tr> 
        <?php  } ?>
	  </table>
	</div>
  
  <?php kak\widgets\fieldset\FieldSet::end(); ?>
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