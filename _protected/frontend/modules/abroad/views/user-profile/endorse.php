<?php 
use common\models\JsEndorse;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
<div  class="col-sm-12">
<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-lock"></i> Endorsement</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></div> ",     // template content icon
'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i> </div>",   // template content icon

]);?>
  	
	<div id="endorse" class="content-list content-menu responsive">
		   <table class='table table-bordered table-striped'>
		   	<?php if(isset($_GET['idOtherProfile'])) { ?>
		   	<tr>
		   		<td colspan="3" style="text-align: left;">
		   			<?php
				   	$endorseModel = new JsEndorse();
				   	 	Modal::begin([
				   	 		  	'options' => [
							        'tabindex' => false // important for Select2 to work properly
							    ],
	                          'header' => 'Add endorsement',
	                          "class" => "vd_bg-green", 
	                          'toggleButton' => [
	                          	'class' => 'btn vd_btn btn-xs vd_bg-green',
	                          	'label' => 'Add <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>'
	                          ],
	                          'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
	                                //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
	                      ]);
		                     echo $this->render('/js-endorse/_form', [
		                            'model' => $endorseModel,
		                            'url'   => Yii::$app->link->frontendUrl('/jobseeker/js-endorse/create'),
		                            'user_id' => (isset($_GET['idOtherProfile'])) ? $_GET['idOtherProfile'] : 0
		                        ]);  
	                    Modal::end(); 
	                ?>
		   		</td>
		   	</tr>
		<?php } ?>
	  	<tr>
	  		<th>Skills</th>
	  		<th>Endorsed by</th>
	  		<th>Action</th>
	  	</tr>
	  	<?php
            $endorses = $jobseeker->jsEndorses;			               
            foreach($endorses as $endorse){
        ?>
           	<tr>
               <td><?= isset($endorse->skill->skill) ? $endorse->skill->skill : '-' ?></td>
               <td>

               	<?php 
               		if (isset($endorse->whoEndorsed->mediatorProfile->madiator_name) ) {
               			echo $endorse->whoEndorsed->mediatorProfile->madiator_name;
           			} 

           			if (isset($endorse->whoEndorsed->userProfile->fullName) ) {
               			echo $endorse->whoEndorsed->userProfile->fullName;
           			} 

           			if (isset($endorse->whoEndorsed->employerProfile->company_name) ) {
               			echo $endorse->whoEndorsed->employerProfile->company_name;
           			} 
           		?>
               	
               </td>
               <td>
               	<center>
               		<a href="#">
               		<?php
					   	$endorseModel = JsEndorse::find()->where(['id' => $endorse->id])->one(); 
		                Yii::$app->jobPortalModal->popup($endorseModel, "Endorse","blue","eye-open","/js-endorse/_view");
		            ?>
               		
               	</a>
             	<?php if(!isset($_GET['idOtherProfile'])) { ?>
               	<a href="#endorse" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $endorse->id?>", js-endorse","endorse")'>
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
	function hideAndShowEndorse(){
	
	let column = "show_endorsement";
	let variable = $("#input_endorse").val();
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