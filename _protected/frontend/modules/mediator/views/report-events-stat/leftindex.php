<?php
use yii\helpers\Url;
use common\models\SOpportunity;
use backend\models\SActions;
$event_opportinities = SOpportunity::find()->secondType()->all();
?>
<div class="panel widget light-widget">
<div class="panel-heading">Events</div>
<div class="panel-body">
    <table class="table">
        
        <?php foreach ($event_opportinities as $opportunity) {
        ?>
            <tr>
                <td>
                    <a href='<?= Url::to(["/mediator/report-events-stat?opportunity=".$opportunity->id], true) ?>'> 
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
