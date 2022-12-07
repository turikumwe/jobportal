<?php
use yii\helpers\Url;
?>
<div class="panel widget light-widget">
<div class="panel-heading"><strong>Employer By</strong></div>
<div class="panel-body">
    <table class="table">
            <tr>
                <td><i class="fa fa-list"></i>
                    <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'> List </a> 
                </td>
            </tr>
            <tr>
                <td><i class="fa fa-globe"></i>
                    <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'> Location </a> 
                </td>
            </tr>
            
            <tr>
                <td><i class="fa fa-industry"></i>
                    <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'>Industries </a> 
                </td>
            </tr>   
    </table>
</div>
</div>