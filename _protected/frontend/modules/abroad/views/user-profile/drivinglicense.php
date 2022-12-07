<?php 
use common\models\JsDrivingLicense;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use common\models\JsDrivingLicenseCategory;
?>
<div class="row profile">
<div  class="col-sm-12">
	<?php kak\widgets\fieldset\FieldSet::begin([
	'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-certificate"></i> Driving License</span>'),
	'active' => false,// false - hide content, default true
	'speed'  => 0, // animation speed default value 300
	'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></div>",     // template content icon
	'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i></div>",   // template content icon
	]);?>
	  	<div id="license" class="content-list content-menu responsive">
			   <table class='table table-bordered table-striped'>
			   	<?php if(!isset($_GET['idOtherProfile'])) { ?>
			   	<tr>					   		
			   		<td colspan="6" style="text-align: left;">
					<?php
				   		$licenseModel = new JsDrivingLicense();
				   		Yii::$app->jobPortalModal
			   				 ->popup(
						   			$licenseModel, 
						   			"Add Driving License",
						   			"green",
						   			"plus", 
						   			"/js-driving-license/_form", 
						   			"/jobseeker/js-driving-license/store",
						   			"Add",
						   			['categories' => [new JsDrivingLicenseCategory]]
			   			);
					?>		   			

			   		</td>
			   	</tr>
			<?php } ?>

		  	<tr>
		  		<th>Driving license</th>
		  		<th>Type</th>
		  		<?php if (Yii::$app->user->can('user')) { ?>
		  		<th style="width: ">Action</th>
		  		<?php } ?>
		  	</tr>
		  	<?php
	            $licenses = $jobseeker->jsDrivingLicenses;			               
                foreach($licenses as $license){
            ?>
               	<tr>
	               <td><?= isset($license->havingLicense->noyes) ? $license->havingLicense->noyes: "-";?></td>
	               <td><?= isset($license->licenseType->type) ? $license->licenseType->type: "-";?></td>
	               <?php if (Yii::$app->user->can('user')) { ?>
	               <td>
	               		<a href="#">
		               		<?php
							   	$licenseModel = JsDrivingLicense::find()->where(['id' => $license->id])->one();
								Yii::$app->jobPortalModal->popup($licenseModel, "View Driving License","blue","eye-open","/js-driving-license/_view");
		               		?>
		               	</a>
					<?php if(!isset($_GET['idOtherProfile'])) { ?>
	               	<a href="#">
		                <?php				   	
						  	$licenseModel = JsDrivingLicense::find()->where(['id' => $license->id])->one();
						   	Yii::$app->jobPortalModal
				   				 ->popup(
							   			$licenseModel, 
							   			"Driving License",
							   			"green",
							   			"edit", 
							   			"/js-driving-license/_update", 
							   			'/jobseeker/js-driving-license/update?id='.$licenseModel->id
					 		);
		            	?>
	               	</a>
	               	<a href="#license" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $license->id?>,"js-driving-license","license")'>
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
	function hideAndShowLicense(){
	
	let column = "show_drivinglicense";
	let variable = $("#input_license").val();
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