<?php

use common\models\MdEmployees;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$employeeModel = new MdEmployees();
?>
<div class="row profile">
	<div class="col-sm-12">
		<?php if (!isset($_GET['idOtherProfile'])) { ?>
			<a href="#" onClick="hideAndShowEmployee()" class="mgbt-xs-15 font-semibold pull-right">
				<input type="checkbox" id="input_employee" value="<?= ($mediator->show_employee) ? 0 : 1 ?>" <?= ($mediator->show_employee) ? 'checked' : '' ?>>

				<span id="label_employee"><?= ($mediator->show_employee) ? 'Show' : 'Hide' ?></span>
			</a>
		<?php } ?>
		<?php kak\widgets\fieldset\FieldSet::begin([
			'legend' => Yii::t('app-dash', '<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-duplicate"></i> Employee</span>'),
			'active' => false, // false - hide content, default true
			'speed'  => 0, // animation speed default value 300
			'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></div>",     // template content icon
			'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i></div>",   // template content icon
		]); ?>
			<div id="employee" class="table-responsive">
				<table class='table table-bordered table-striped'>
					<?php if (!isset($_GET['idOtherProfile'])) { ?>
						<tr>
							<td colspan="7" style="text-align: left;">
								<?php
								Yii::$app->jobPortalModal
									->popup(
										$employeeModel,
										"Add Employee",
										"green",
										"plus",
										"/md-employees/_form",
										"/mediator/md-employees/create",
										"Add"

									);
								?>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<th><?= $employeeModel->getAttributeLabel('person_id') ?></th>
						<th>Phone</th>
						<th>Email</th>
						<th><?= $employeeModel->getAttributeLabel('start_date') ?></th>
						<th><?= $employeeModel->getAttributeLabel('end_date') ?></th>
						<th>Action</th>
					</tr>
					<?php

					$employees = $mediator->mdEmployees;
					foreach ($employees as $employee) {
					?>
						<tr>
							<td><?= $employee->person->fullName ?></td>
							<td><?= $employee->person->phone ?></td>
							<td><?= $employee->person->email ?></td>
							<td><?= $employee->start_date ?></td>
							<td><?= $employee->end_date ?></td>
							<td>
								<a href="#">
									<?php
									$employeeModel = MdEmployees::find()->where(['id' => $employee->id])->one();
									Yii::$app->jobPortalModal->popup($employeeModel, "Update employee", "blue", "eye-open", "/md-employees/view");
									?>

								</a>
								<?php if (!isset($_GET['idOtherProfile'])) { ?>
									<a href="#">
										<?php
										$employeeModel = MdEmployees::find()->where(['id' => $employee->id])->one();
										Yii::$app->jobPortalModal
											->popup(
												$employeeModel,
												"employee",
												"green",
												"edit",
												"/md-employees/_form",
												'/mediator/md-employees/update?id=' . $employeeModel->id

											);
										?>

									</a>

									<a href="#" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $employee->id ?>,"md-employees","employee")'>
										<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
									</a>
								<?php } ?>
							</td>
						</tr>
					<?php  } ?>
				</table>
			</div>
		<?php kak\widgets\fieldset\FieldSet::end(); ?>
	</div>
</div>

<script>
	function hideAndShowEmployee() {

		let column = "show_employee";
		let variable = $("#input_employee").val();
		let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

		if ($("#label_employee").html() == 'Show') {
			$("#label_employee").html('Hide');
		} else {
			$("#label_employee").html('Show');
		}

		$.ajax({
			type: "POST",
			url: FRONTEND_BASE_URL + "/mediator/md-mediator/hide-and-show?variable=" + variable + "&column=" + column,
			dataType: "json",
			success: function(data) {

			}
		});

	}
</script>