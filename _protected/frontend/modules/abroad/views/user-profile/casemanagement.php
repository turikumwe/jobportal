<?php 
use common\models\JsCaseManagement;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
<div  class="col-sm-12">
<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-envelope"></i> Case Management</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></div> ",     // template content icon
'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i></div> ",   // template content icon
]);
?>
  <div class="col-sm-12">
  	
	<div id="casemanagement" class="content-list content-menu responsive">
		   <table class='table table-bordered table-striped'>
		   	<?php if(isset($_GET['idOtherProfile'])) { ?>
		   	<tr>
		   		<td colspan="6" style="text-align: left;">
		   			<?php
					   	$casemanagementModel = new JsCaseManagement();
					   	 	Modal::begin([
					   			'options' => [
							        'tabindex' => false // important for Select2 to work properly
							    ],
		                          'header' => 'Add Case Management',
		                          "class" => "vd_bg-green", 
		                          'toggleButton' => [
		                          	'class' => 'btn vd_btn btn-xs vd_bg-green',
		                          	'label' => 'Add <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>'
		                          ],
		                          //'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
		                                //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
		                      ]);
			                     echo $this->render('/js-case-management/_formService', [
			                            'model' => $casemanagementModel,
			                            'url'   => Yii::$app->link->frontendUrl('/jobseeker/js-case-management/create'),
			                            'user_id' => (isset($_GET['idOtherProfile'])) ? $_GET['idOtherProfile'] : 0,
			                            'get' => $jobseeker
			                        ]);  
		                    Modal::end(); 
		                ?>
		   		</td>
		   	</tr>
		<?php } ?>
	  	<tr>
	  		<th>Given Service</th>
	  		<th>Submitted On</th>
	  		<th>Submitted by</th>
	  		<th>Action</th>
	  	</tr>
	  	<?php
            $casemanagements = $jobseeker->jsCaseManagements;			               
            foreach($casemanagements as $casemanagement){
        ?>
           	<tr>
				<td><?= $casemanagement->services->name?></td>
				<td><?= $casemanagement->created_at?></td>
				<td>
					<?=
						isset($casemanagement->mediotor->employeeProfile)?
						$casemanagement->mediotor->employeeProfile->fullName : $casemanagement->mediotor->mediatorProfile->madiator_name
					?>
				</td>
				<td width="20%">
               	<center>
               	<a href="#">
               		<?php
					   	$casemanagementModel = JsCaseManagement::find()->where(['id' => $casemanagement->id])->one();
					   	Yii::$app->jobPortalModal->popup($casemanagementModel, "CaseManagement","blue","eye-open","/js-case-management/_view");
		            ?>	
               	</a>
               	<?php if(!isset($_GET['idOtherProfile'])) { ?>
               	<a href="#casemanagement" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $casemanagement->id?>,"js-casemanagement","casemanagement")'>
               		<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
               	</a>
               	<?php } ?>
               </center>
               </td>
       		</tr> 
        <?php  } ?>
	  </table>
	</div>            
  
  <?php kak\widgets\fieldset\FieldSet::end(); ?>
</div>
</div>	
<script>
	function hideAndShowCaseManagement(){
	
	let column = "show_casemanagement";
	let variable = $("#input_casemanagement").val();

	$.ajax({
	        type: "POST",
	        url: "/jobseeker/user-profile/hide-and-show?variable="+variable+"&column="+column,
	        dataType: "json",
	        success: function(data){ 
	           
	        }
	});

	}
</script>