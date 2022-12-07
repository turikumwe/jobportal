<?php 
use common\models\JsDrivingLicense;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use common\models\JsDrivingLicenseCategory;
?>
 
<div class="row profile">
<div  class="col-sm-12">
	 
	  	<div id="license" class="content-list content-menu responsive">
			   <table class='table table-bordered table-striped'>
			   	<?php if(!isset($_GET['js'])) { ?>
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
	               <td  class="pxp-dashboard-table-options">
	               		<a href="#">
		               		<?php
							   	$licenseModel = JsDrivingLicense::find()->where(['id' => $license->id])->one();
								Yii::$app->jobPortalModal->popup($licenseModel, "View Driving License","blue","fa fa-eye","/js-driving-license/_view");
		               		?>
		               	</a>
					<?php if(!isset($_GET['js'])) { ?>
	               	<a href="#">
		                <?php				   	
						  	$licenseModel = JsDrivingLicense::find()->where(['id' => $license->id])->one();
						   	Yii::$app->jobPortalModal
				   				 ->popup(
							   			$licenseModel, 
							   			"Driving License",
							   			"green",
							   			"fa fa-edit", 
							   			"/js-driving-license/_update", 
							   			'/jobseeker/js-driving-license/update?id='.$licenseModel->id
					 		);
		            	?>
	               	</a>
	               <a href="#" style="background-color: #e9e9e9"  type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?')) window.location.href='removeitem?licenseid=<?=$licenseModel->id?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true"  ></button>
						</a>
	               	<?php } ?>
	               </td>
	               <?php } ?>
           		</tr> 
            <?php  } ?>
		  </table>
		</div> 
	   
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