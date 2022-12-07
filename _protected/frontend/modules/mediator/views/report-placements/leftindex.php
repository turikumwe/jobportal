<?php
use yii\helpers\Url;
use common\models\SOpportunity;
use backend\models\SActions;

$job_opportinities = SOpportunity::find()->firstType()->all();
?>
 
<div class="panel widget light-widget">
	<div class="panel-heading"><strong>Jobs</strong></div>
		<div class="panel-body">
		    <table class="table">

		        <?php foreach ($job_opportinities as $opportunity) { ?>
		            <tr>
		                <td>
		                     <a href='<?= Url::to(["/mediator/report-placements?opportunity=".$opportunity->id], true) ?>'> 
		                        <?=ucwords($opportunity->name)?> 
		                        <span class="pull-right">(<?= Yii::$app->reports->jobTypeApplicationPublished($opportunity->id)?>)</span>
		                    </a>
		                </td>
		            </tr>   
		        <?php } ?>
		            
		    </table>
		</div>
	</div>
