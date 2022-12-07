<?php
use yii\helpers\Url;
?>
<div class="panel widget light-widget panel-bd-top">
    <div class="panel-heading no-title"><center>Job Seekers By</center> </div>
    <div class="panel-body">
        <table class="table">
            <tr>
                <td><i class="glyphicon glyphicon-chevron-right"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-location"], true) ?>'> Kigali City </a> 
                </td>
            </tr>

            <tr>
                <td><i class="glyphicon glyphicon-chevron-right"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-industries"], true) ?>'>North Province </a> 
                </td>
            </tr>

            <tr>
                <td><i class="glyphicon glyphicon-chevron-right"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-occupation"], true) ?>'>South Province </a> 
                </td>
            </tr>
            
            <tr>
                <td><i class="glyphicon glyphicon-chevron-right"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-physical-disability"], true) ?>'> East Province </a> 
                </td>
            </tr>
            <tr>
                <td><i class="glyphicon glyphicon-chevron-right"></i>
                    <a href='<?= Url::to(["/mediator/report/jobseeker-statistic-physical-disability"], true) ?>'> West Province </a> 
                </td>
            </tr>
        </table>
    </div>
</div>