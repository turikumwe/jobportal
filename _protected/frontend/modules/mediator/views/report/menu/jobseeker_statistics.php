<?php
use yii\helpers\Url;
?>
<div class="panel widget light-widget">
    <div class="pxp-logo">
        <a href="<?= Yii::getAlias('@frontendUrl'); ?>" class="pxp-animate"><img src="<?= Yii::getAlias('@staticUrl') ?>/images/kora.png" width="82px" height='40px'></a>
    </div><br />
    <div class="panel-heading"><strong>JobSeekers statistic By</strong></div>
    <div class="panel-body">
        <table class="table">
            <tr>
                <td><i class="fa fa-globe"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-location"], true) ?>'> Location </a> 
                </td>
            </tr>

            <tr>
                <td><i class="fa fa-industry"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-industries"], true) ?>'>Industries </a> 
                </td>
            </tr>

            <tr>
                <td><i class="fa fa-briefcase"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-occupation"], true) ?>'>Occupation </a> 
                </td>
            </tr>
            
            <tr>
                <td><i class="fa fa-ambulance"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-physical-disability"], true) ?>'> Physical Disability </a> 
                </td>
            </tr>
        </table>
    </div>
</div>