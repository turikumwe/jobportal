<?php 
use common\models\JsSkill;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="row profile">
	<div  class="col-sm-12">
		<?php kak\widgets\fieldset\FieldSet::begin([
		'legend' => Yii::t('app-dash','<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-folder-open"></i> Skills</span>'),
		'active' => false,// false - hide content, default true
		'speed'  => 0, // animation speed default value 300
		'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i> </div>",     // template content icon
		'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i> </div>",   // template content icon
		]);?>
			<div id="skill" class="content-list content-menu responsive">
				<table class='table table-bordered table-striped'>
					<?php if(!isset($_GET['idOtherProfile'])) { ?>
					<tr>					   		
						<td colspan="3" style="text-align: left;">
						<?php
							$skillModel = new JsSkill();
							Yii::$app->jobPortalModal
								->popup(
										$skillModel, 
										"Add skill",
										"green",
										"plus", 
										"/js-skill/_form", 
										"/jobseeker/js-skill/add",
										"Add"	
							);
						?>		   			

						</td>
					</tr>
				<?php } ?>

				<tr>
					<th>Skills</th>
					<th>Skills level</th>
					<?php if (Yii::$app->user->can('user')) { ?>
					<th>Action</th>
					<?php } ?>
				</tr>
				<?php
					$skills = $jobseeker->jsSkills;			               
					foreach($skills as $skill){
				?>
					<tr>
					<td><?= isset($skill->skill->skill) ? $skill->skill->skill: "-";?></td>
					<td><?= isset($skill->skillLevel->level) ? $skill->skillLevel->level: "-";?></td>
					<?php if (Yii::$app->user->can('user')) { ?>
					<td>
							<a href="#">
								<?php
									$skillModel = JsSkill::find()->where(['id' => $skill->id])->one();
									Yii::$app->jobPortalModal->popup($skillModel, "View skills","blue","eye-open","/js-skill/_view");
								?>
							</a>
						<?php if(!isset($_GET['idOtherProfile'])) { ?>
						<a href="#">
							<?php				   	
								$skillmodel = JsSkill::find()->where(['id' => $skill->id])->one();
								Yii::$app->jobPortalModal
									->popup(
											$skillmodel, 
											"skill",
											"green",
											"edit", 
											"/js-skill/_form", 
											'/jobseeker/js-skill/update?id='.$skillmodel->id
								);
							?>
						</a>
						<a href="#skill" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $skill->id?>", js-skill","skill")'>
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
	function hideAndShowSkill(){
	
	let column = "show_skill";
	let variable = $("#input_skill").val();
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