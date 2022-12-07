<?php
use yii\helpers\Url;
use common\models\SOpportunity;
use backend\models\SActions;

$job_opportinities = SOpportunity::find()->firstType()->all();
$event_opportinities = SOpportunity::find()->secondType()->all();
?>
<div class="panel widget light-widget panel-bd-top">
	<div class="panel-heading no-title"><center>Jobs</center> </div>
		<div class="panel-body">
		    <table class="table">

		        <?php foreach ($job_opportinities as $opportunity) { ?>
		            <tr>
		                <td>
		                    <a href='<?= Url::to(["/mediator/report-locations/job?opportunity=".$opportunity->id], true) ?>'> 
		                        <?=ucwords($opportunity->name)?> 
		                        <span class="pull-right">(<?= Yii::$app->reports->jobType($opportunity->id)->count()?>)</span>
		                    </a>
		                </td>
		            </tr>   
		        <?php } ?>
		            
		    </table>
		</div>
	</div>

<div class="panel widget light-widget panel-bd-top">
<div class="panel-heading no-title"><center>Events</center></center> </div>
<div class="panel-body">
    <table class="table">
        
        <?php foreach ($event_opportinities as $opportunity) {
        ?>
            <tr>
                <td>
                    <a href='<?= Url::to(["/mediator/report-locations/event?opportunity=".$opportunity->id], true) ?>'> 
                        <?=ucwords($opportunity->name)?> 
                        <span class="pull-right">
                            (<?= Yii::$app->reports->eventType($opportunity->id)->count()?>)
                        </span>
                    </a>
                </td>
            </tr>
        <?php
    } ?>
            
    </table>
</div>
</div>
