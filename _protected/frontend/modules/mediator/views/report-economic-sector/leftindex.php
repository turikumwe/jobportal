<?php
use yii\helpers\Url;
use common\models\SOpportunity;
use backend\models\SActions;

$job_opportinities = SOpportunity::find()->firstType()->all();
$event_opportinities = SOpportunity::find()->secondType()->all();
?>
<div class="panel widget light-widget panel-bd-top">
	<div class="panel-heading no-title"><strong>Jobs</strong>  </div>
		<div class="panel-body">
		    <table class="table">

		        <?php foreach ($job_opportinities as $opportunity) { ?>
		            <tr>
		                <td>
		                    <a href='<?= Url::to(["/mediator/report-economic-sector/job?opportunity=".$opportunity->id], true) ?>'> 
		                        <?=ucwords($opportunity->name)?> 
		                        <span class="pull-right">(<?= Yii::$app->reports->jobEconomicSectorType($opportunity->id)->count()?>)</span>
		                    </a>
		                </td>
		            </tr>   
		        <?php } ?>
		            
		    </table>
		</div>
	</div>

<!-- <div class="panel widget light-widget panel-bd-top">
<div class="panel-heading no-title"><center>Events</center></center> </div>
<div class="panel-body">
    <table class="table">
        
        <?php //foreach ($event_opportinities as $opportunity) {
        ?>
            <tr>
                <td>
                    <a href='<?php //Url::to(["/mediator/report-economic-sector/event?opportunity=".$opportunity->id], true) ?>'> 
                        <?php //ucwords($opportunity->name)?> 
                        <span class="pull-right">
                            (<?php // Yii::$app->reports->eventEconomicSectorType($opportunity->id)->count()?>)
                        </span>
                    </a>
                </td>
            </tr>
        <?php
   // } ?>
            
    </table>
</div>
</div> -->
