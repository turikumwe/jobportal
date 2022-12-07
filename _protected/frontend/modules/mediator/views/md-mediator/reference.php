<?php 
use common\models\EmplReference;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row well">
<a href="#" onClick="hideAndShowReference()"class="mgbt-xs-15 font-semibold pull-right">
	<input 
		type="checkbox" 
		id="input_reference" 
		value="<?= ($employer->employerProfile->show_reference) ? 0 : 1?>" 
		<?= ($employer->employerProfile->show_reference) ? 'checked' : ''?>
	>

	<span id="label_experience"><?= ($employer->employerProfile->show_reference) ? 'Show' : 'Hide'?></span>
</a>
<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-duplicate"></i> Reference</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
]);?>
  <div class="col-sm-12 mgbt-xs-20">

	<div id="reference" class="content-list content-menu responsive">
	  <table class='table table-bordered table-striped'>
	  	<?php if(!isset($_GET['idOtherProfile'])) { ?>
	  	<tr>
	  		<td colspan="5" style="text-align: left;">
	  				<?php
			   		$referenceModel = new EmplReference();
			   		Yii::$app->jobPortalModal
			   				 ->popup(
						   			$referenceModel, 
						   			"Add Reference",
						   			"green",
						   			"plus", 
						   			"/empl-reference/_form", 
						   			"/employer/empl-reference/create",
						   			"Add"
						   			
			   			);
                ?>
	  		</td>
	  	</tr>
	  	<?php } ?>
	  	<tr>
	  		<th>Employer</th>
	  		<th>Phone Number</th>
	  		<th>Website</th>
	  		<th>PhysicalReference</th>
	  		<th>Action</th>
	  	</tr>
	  	<?php
            $references = $employer->emplReference;			               
            foreach($references as $reference){
        ?>
           	<tr>
               <td><?= $reference->email_address?></td>
               <td><?= $reference->phone_number?></td>
               <td><?= $reference->website?></td>
               <td><?= $reference->physical_address?></td>
               <td>
               		<a href="#">
               		<?php
					   	$referenceModel = EmplReference::find()->where(['id' => $reference->id])->one();
					   	Yii::$app->jobPortalModal->popup($referenceModel, "Update Reference","blue","eye-open","/empl-reference/view");
		                ?>
               		
               	</a>
             	<?php if(!isset($_GET['idOtherProfile'])) { ?>
               	<a href="#">
               		<?php
					   	$referenceModel = EmplReference::find()->where(['id' => $reference->id])->one();
					   	Yii::$app->jobPortalModal
			   				 ->popup(
						   			$referenceModel, 
						   			"reference",
						   			"green",
						   			"edit", 
						   			"/empl-reference/_form", 
						   			'/employer/empl-reference/update?id='.$referenceModel->id  			
			   			);
		                ?>
               		
               	</a>
               	&nbsp;&nbsp;
               	<a href="#" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $reference->id?>,"empl-reference","reference")'>
               		<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
               	</a>
               	<?php } ?>
               </td>
       		</tr> 
        <?php  } ?>
	  </table>
	</div>
  </div>
  <?php kak\widgets\fieldset\FieldSet::end(); ?>
</div>

<script>
	function hideAndShowReference(){
	
	let column = "show_reference";
	let variable = $("#input_reference").val();

	if($("#label_reference").html() == 'Show'){
			$("#label_reference").html('Hide');
		}else{
			$("#label_reference").html('Show');
		}

		$.ajax({
		        type: "POST",
		        url: "/employer/empl-employer/hide-and-show?variable="+variable+"&column="+column,
		        dataType: "json",
		        success: function(data){ 
		           
		        }
		});

	}
</script>