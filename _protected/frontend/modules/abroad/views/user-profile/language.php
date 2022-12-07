<?php 
use common\models\JsLanguage;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
<div  class="col-sm-12">
<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-book"></i> Language</span>'),
'active' => false,// false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i> </div>",     // template content icon
'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i> </div>",   // template content icon
]);?>
  
	<div id="language" class="content-list content-menu responsive">
		   <table class='table table-bordered table-striped'>
		   	<?php if(!isset($_GET['idOtherProfile'])) { ?>
		   	<tr>
		   		<td colspan="6" style="text-align: left;">
					<?php
				   		$languageModel = new JsLanguage();
				   		Yii::$app->jobPortalModal
			   				 ->popup(
						   			$languageModel, 
						   			"Add language",
						   			"green",
						   			"plus", 
						   			"/js-language/_form", 
						   			"/jobseeker/js-language/create",
						   			"Add"	
				   			);
	                ?>
		   		</td>
		   	</tr>
		<?php } ?>
	  	<tr>
	  		<th>Language</th>
	  		<th>Reading</th>
	  		<th>Writing</th>
	  		<th>Listening</th>
	  		<th>Speaking</th>
	  		<?php if (Yii::$app->user->can('user')) { ?>
	  		<th>Action</th>
	  		<?php } ?>
	  	</tr>
	  	<?php
            $languages = $jobseeker->jsLanguages;			               
            foreach($languages as $language){
        ?>
           	<tr>
               <td><?= isset($language->language0->language) ? $language->language0->language : "-" ;?></td>
               <td><?= isset($language->reading0->languagerate) ? $language->reading0->languagerate : "-" ;?></td>               
               <td><?= isset($language->writing0->languagerate) ? $language->writing0->languagerate : "-";?></td>
               <td><?= isset($language->listening0->languagerate) ? $language->listening0->languagerate : "-";?></td>
               <td><?= isset($language->speaking0->languagerate) ? $language->speaking0->languagerate : "-";?></td>
               <?php if (Yii::$app->user->can('user')) { ?>
               <td>
               	<a href="#">
               		<?php
					   	$languageModel = JsLanguage::find()->where(['id' => $language->id])->one();
					   	Yii::$app->jobPortalModal->popup($languageModel, "View language","blue","eye-open","/js-language/_view");
		            ?>	
               	</a>
             	<?php if(!isset($_GET['idOtherProfile'])) { ?>
               	<a href="#">
               		<?php
					   	$languageModel = JsLanguage::find()->where(['id' => $language->id])->one();
					   	Yii::$app->jobPortalModal
			   				 ->popup(
						   			$languageModel, 
						   			"language",
						   			"green",
						   			"edit", 
						   			"/js-language/_form", 
						   			'/jobseeker/js-language/update?id='.$languageModel->id
				 		);
		                ?>	
               	</a>
               	<a href="#language" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $language->id?>", js-language","language")'>
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
	function hideAndShowLangage(){
	
	let column = "show_language";
	let variable = $("#input_language").val();
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