 <?php
 use kartik\grid\GridView;
 ?>
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

	 
             	<?php if(!isset($_GET['js'])) { ?>
               	<a href="#">
               		<?php
                        $experienceid=7093;
					   	$experienceModel = JsExperience::find()->where(['id' =>  $experienceid])->one();
					   	Yii::$app->jobPortalModal
			   				 ->popup(
						   			$experienceModel, 
						   			"Experience",
						   			"green",
						   			"edit", 
						   			"/js-experience/_form", 
						   			'/jobseeker/js-experience/update?id='. $experienceid   			
			   			);
		                ?>	
               	</a>
               	<a href="#experience" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?=$experienceid?>", js-experience","experience")'>
               		<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
               	</a>
               	<?php } ?>
                
	  
	</div>
  
  <?php kak\widgets\fieldset\FieldSet::end(); ?>
</div>
</div>
