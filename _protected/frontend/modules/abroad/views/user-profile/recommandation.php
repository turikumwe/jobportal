<?php 
use common\models\JsRecommendation;
use yii\bootstrap\modal;
use yii\helpers\Html;
?>
<div class="row profile">
<div  class="col-sm-12">
<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-envelope"></i> Recommandation</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></div>",     // template content icon
'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i></div>",   // template content icon
]);
?>
  	
	<div id="recommendation" class="content-list content-menu responsive">
		<table class='table table-bordered table-striped'>
		   	<?php if(Yii::$app->user->can('mediator') || Yii::$app->user->can('employer')) { ?>
		   	<tr>
		   		<td colspan="3" style="text-align: left;">
		   			<?php
					   	$recommendationModel = new JsRecommendation();
					   	 	Modal::begin([
					   			'options' => [
							        'tabindex' => false // important for Select2 to work properly
							    ],
		                          'header' => 'Add recommendation',
		                          "class" => "vd_bg-green", 
		                          'toggleButton' => [
		                          	'class' => 'btn vd_btn btn-xs vd_bg-green',
		                          	'label' => 'Add <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>'
		                          ],
		                          'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
		                                //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
		                      ]);
			                     echo $this->render('/js-recommendation/_form', [
			                            'model' => $recommendationModel,
			                            'url'   => Yii::$app->link->frontendUrl('/jobseeker/js-recommendation/create'),
			                            'user_id' => (isset($_GET['idOtherProfile'])) ? $_GET['idOtherProfile'] : 0
			                        ]);  
		                    Modal::end(); 
		                ?>
		   		</td>
		   		
		   	</tr>
		<?php } else { ?>
			<tr>
				<td colspan="3" style="text-align: left;"><?php include('leftPanel/recommandationButton.php');?> </td>
			</tr>
		<?php } ?>

	  	<tr>
	  		<th>Recommendation</th>
	  		<th>Recommended by</th>
	  		<th>Action</th>
	  	</tr>
	  	<?php
            $recommendations = $jobseeker->jsRecommendations;			               
            foreach($recommendations as $recommendation){
        ?>
           	<tr>
               <td><?= $recommendation->recommendation?></td>
               <td>
               	<?php
               		if (isset($recommendation->whoRecommended->mediatorProfile->madiator_name) ) {
               			echo $recommendation->whoRecommended->mediatorProfile->madiator_name;
           			} 

           			if (isset($recommendation->whoRecommended->userProfile->fullName) ) {
               			echo $recommendation->whoRecommended->userProfile->fullName;
           			} 

           			if (isset($recommendation->whoRecommended->employerProfile->company_name) ) {
               			echo $recommendation->whoRecommended->employerProfile->company_name;
           			}  
           			?>
               </td>
               <td width="20%">
               	<center>
               	<a href="#">
               		<?php
					   	$recommendationModel = JsRecommendation::find()->where(['id' => $recommendation->id])->one();
					    Yii::$app->jobPortalModal->popup($recommendationModel, "Recommendation","blue","eye-open","/js-recommendation/_view");
		                ?>
               		
               	</a>
               	<?php if(!isset($_GET['idOtherProfile'])) { ?>
               	<a href="#recommendation" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $recommendation->id?>", js-recommendation","recommendation")'>
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
	function hideAndShowRecommandation(){
	
	let column = "show_recommendation";
	let variable = $("#input_recommandation").val();
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