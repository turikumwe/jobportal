<?php
use yii\helpers\Url;
use common\models\SOpportunity;

$job_opportinities = SOpportunity::find()->firstType()->all();
$event_opportinities = SOpportunity::find()->secondType()->all();
?>
<div class="panel widget light-widget">
<div class="panel-heading"><?= Yii::t("frontend","Jobs") ?></div>
<div class="panel-body">
    <ul>
        <?php foreach($job_opportinities as $opportunity){ ?>
            <li>
                <a href='<?= Url::to(["/mediator/report-application/job-applied?opportunity=".$opportunity->id], true) ?>'> 
                    <?=ucwords($opportunity->name)?> 
                    <span class="pull-right">(<?= Yii::$app->reports->jobTypeApplicationPublished($opportunity->id)?>)</span>
                </a>
            </li>
        <?php } ?>  
    </ul>
</div>
</div>
<div class="panel widget light-widget">
<div class="panel-heading"><?= Yii::t("frontend","Events") ?></div>
<div class="panel-body">
    <ul>  
        <?php foreach($event_opportinities as $opportunity){ ?>
            <li>
                <a href='<?= Url::to(["/mediator/report-application/event-applied?opportunity=".$opportunity->id], true) ?>'> 
                    <?=ucwords($opportunity->name)?> 
                    <span class="pull-right">
                        (<?= Yii::$app->reports->eventTypeApplicationPublished($opportunity->id)?>)
                    </span>
                </a>
            </li>
        <?php } ?>    
    </ul>
</div>
</div>