<?php
use yii\helpers\Url;
?>
<div class="panel widget light-widget panel-bd-top">
<div class="panel-heading no-title"><center>Job Seekers By</center> </div>
<div class="panel-body">
    <table class="table">
            <tr>
                <td><i class="glyphicon glyphicon-chevron-right"></i>
                    <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'> Kigali Employment Center </a> 
                </td>
            </tr>
            <tr>
                <td><i class="glyphicon glyphicon-chevron-right"></i>
                    <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'> Musanze Employment Center </a> 
                </td>
            </tr>
            
            <tr>
                <td><i class="glyphicon glyphicon-chevron-right"></i>
                    <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'>Huye Employment Center </a> 
                </td>
            </tr>   
    </table>
</div>
</div>