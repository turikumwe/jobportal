<?php 
use common\models\MdSummary;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row well">

<a href="#" onClick="hideAndShowSummary()"class="mgbt-xs-15 font-semibold pull-right">
	<input 
		type="checkbox" 
		id="input_summary" 
		value="<?= ($mediator->mediatorProfile->show_summary) ? 0 : 1?>" 
		<?= ($mediator->mediatorProfile->show_summary) ? 'checked' : ''?>
	>

	<span id="label_summary"><?= ($mediator->mediatorProfile->show_summary) ? 'Show' : 'Hide'?></span>
</a>

<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-list-alt"></i> SUMMARY</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
]);?>
  <div class="col-sm-12 mgbt-xs-20">
 				
	<div id="summary" class="content-list content-menu responsive">
	  <table class='table table-striped'>
	  	<?php if(!isset($_GET['idOtherProfile']) && MdSummary::find()->where(['mediator_id' => Yii::$app->user->id,'deleted_by' => 0])->count() == 0) { ?>
	  	<tr>
	  		<td colspan="5" style="text-align: left">
	  				<?php
			   		$summaryModel = new MdSummary();
			   		Yii::$app->jobPortalModal
			   				 ->popup(
						   			$summaryModel, 
						   			"Add Summary",
						   			"green",
						   			"plus", 
						   			"/md-summary/_form", 
						   			"/mediator/md-summary/create",
						   			"Add"
						   			
			   			);
                ?>
	  		</td>
	  	</tr>
	<?php } ?>

	  	<?php
            $summaries = $mediator->mdSummary;			               
            foreach($summaries as $summary){
        ?>
        <tr>
        	<td colspan="2" class="pull-right">
        			<a href="#">
               		<?php
					   	$summaryModel = MdSummary::find()->where(['id' => $summary->id])->one();
					   	Yii::$app->jobPortalModal->popup($summaryModel, "View mediator Summary","blue","eye-open","/md-summary/view");
		            ?>
               	</a>
               	<?php if(!isset($_GET['idOtherProfile'])) { ?>
               	<a href="#">
               		<?php
					   	$addressModel = MdSummary::find()->where(['id' => $summary->id])->one();
					   	Yii::$app->jobPortalModal
			   				 ->popup(
						   			$summaryModel, 
						   			"summary",
						   			"green",
						   			"edit", 
						   			"/md-summary/_form", 
						   			'/mediator/md-summary/update?id='.$summaryModel->id
						   			
			   			);
		                ?>
               	</a>
               	&nbsp;&nbsp;
               	<!-- delete to be added -->
               	<a href="#" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $summary->id?>,"empl-summary","summary")'>
               		<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
               	</a>
               	<?php } ?>			
        	</td>
        </tr>
           	<tr>
               <td>
               	<h3>Professional profile</h3>
               	<?= $summary->professional_profile?>
               </td>
            </tr>
            <tr>
              	<td>
              		<h3>Specialty</h3>
              		<?= $summary->specialty;?>		
              	</td>               
       		</tr> 
        <?php  } ?>
	  </table>
	</div>
  </div>
  <?php kak\widgets\fieldset\FieldSet::end(); ?>

</div>	
	
<script>
	function hideAndShowSummary(){
	
	let column = "show_summary";
	let variable = $("#input_summary").val();

	if($("#label_summary").html() == 'Show'){
			$("#label_summary").html('Hide');
		}else{
			$("#label_summary").html('Show');
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