<?php
use common\models\JsAddress;
use yii\bootstrap\Modal;
use yii\helpers\Html;

?>
<div class="row profile">
	<div  class="col-sm-12">
		<?php kak\widgets\fieldset\FieldSet::begin([
		'legend' => Yii::t('app-dash', '<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-home"></i> Address</span>'),
		'active' => false,// false - hide content, default true
		'speed'  => 0, // animation speed default value 300
		'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></di> ",     // template content icon
		'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i> </div>",   // template content icon
		]);?>
			
			<div id="address" class="content-list content-menu responsive">
				<table class='table table-bordered table-striped'>
					<?php if (!isset($_GET['idOtherProfile'])) { ?>
					<tr>
						<td colspan="6" style="text-align: left;">
							<?php
								$addressModel = new JsAddress();
								Yii::$app->jobPortalModal
										->popup(
											$addressModel,
											"Add Address",
											"green",
											"plus",
											"/js-address/_form",
											"/jobseeker/js-address/create",
											"Add"
									);
							?>
						</td>
					</tr>
				<?php } ?>
				<tr>
					<th>Province</th>
					<th>District</th>
					<th>Sector</th>
					<th>Action</th>
				</tr>
				<?php
					$addresses = $jobseeker->jsAddresses;
					foreach ($addresses as $address) {
						?>
					<tr>
					<td><?= isset($address->district->province->province) ? $address->district->province->province : '-'?></td>
					<td><?= isset($address->district->district) ? $address->district->district : '-'?></td>
					<td><?= isset($address->geosector->sector) ? $address->geosector->sector : '-'?></td>
					<td>	
						<a href="#">
							<?php
								$addressModel = JsAddress::find()->where(['id' => $address->id])->one();
						Yii::$app->jobPortalModal->popup($addressModel, "View address", "blue", "eye-open", "/js-address/_view"); ?>
						</a>
						<?php if (!isset($_GET['idOtherProfile'])) { ?>
						<a href="#">
							<?php
								$addressModel = JsAddress::find()->where(['id' => $address->id])->one();
								Yii::$app->jobPortalModal
									->popup(
										$addressModel,
										"address",
										"green",
										"edit",
										"/js-address/_form",
										'/jobseeker/js-address/update?id='.$addressModel->id
								);
							?>
						</a>
						<a href="#address" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $address->id?>,"js-address","address")'>
							<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
						</a>
						<?php } ?>
					</td>
					</tr> 
				<?php
					} ?>
			</table>          
		<?php kak\widgets\fieldset\FieldSet::end(); ?>
	</div>
</div>
<script>
	function hideAndShowAddress(){
	
	let column = "show_contact";
	let variable = $("#input_address").val();
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