<?php 
use common\models\MdManagers;
use yii\bootstrap\Modal;
use yii\helpers\Html;
$managerModel = new MdManagers();
?>
<div class="row well">
<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-duplicate"></i>Contact person</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
]);?>
  <div class="col-sm-12 mgbt-xs-20">

	<div id="manager" class="content-list content-menu responsive">
	  <table class='table table-bordered table-striped'>
	  	<?php if(!isset($_GET['idOtherProfile'])) { ?>
	  	<tr>
	  		<td colspan="6" style="text-align: left;">
	  				<?php
			   		$managerModel = new MdManagers();
			   		Yii::$app->jobPortalModal
			   				 ->popup(
						   			$managerModel, 
						   			"Add Contact person",
						   			"green",
						   			"plus", 
						   			"/md-managers/_form", 
						   			"/mediator/md-managers/create",
						   			"Add"
						   			
			   			);
                ?>
	  		</td>
	  	</tr>
	  	<?php } ?>
	  	<tr>
	  		<th><?= $managerModel->getAttributeLabel('person_id')?></th>
	  		<th>Position</th>
	  		<th>Phone number</th>
	  		<th>Email address</th>
	  		<th><?= $managerModel->getAttributeLabel('start_date')?></th>
	  		<th>Action</th>
	  	</tr>
	  	<?php
            $manageres = $mediator->mdManagers;			               
            foreach($manageres as $manager){
        ?>
           	<tr>
               <td><?= $manager->person->fullName?></td>
               <td><?= $manager->position?></td>
               <td><?= $manager->person->phone?></td>
               <td><?= $manager->person->email?></td>
               <td><?= $manager->start_date?></td>
               
               <td>
               		<a href="#">
               		<?php
					   	$managerModel = MdManagers::find()->where(['id' => $manager->id])->one();
					   	Yii::$app->jobPortalModal->popup($managerModel, "Update manager","blue","eye-open","/md-managers/view");
		                ?>
               		
               	</a>
             	<?php if(!isset($_GET['idOtherProfile'])) { ?>
               	<a href="#">
               		<?php
					   	$managerModel = MdManagers::find()->where(['id' => $manager->id])->one();
					   	Yii::$app->jobPortalModal
			   				 ->popup(
						   			$managerModel, 
						   			"manager",
						   			"green",
						   			"edit", 
						   			"/md-managers/_form", 
						   			'/mediator/md-managers/update?id='.$managerModel->id
						   			
			   			);
		                ?>
               		
               	</a>

               	<a href="#" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $manager->id?>,"md-managers","manager")'>
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
	function hideAndShowmanager(){
	
	let column = "show_manager";
	let variable = $("#input_manager").val();

	if($("#label_manager").html() == 'Show'){
			$("#label_manager").html('Hide');
		}else{
			$("#label_manager").html('Show');
		}

		$.ajax({
		        type: "POST",
		        url: "/mediator/md-mediator/hide-and-show?variable="+variable+"&column="+column,
		        dataType: "json",
		        success: function(data){ 
		           
		        }
		});

	}
</script>