<?php
use yii\helpers\Url;
use common\models\SOpportunity;

?>
<div class="panel widget light-widget panel-bd-top">
<div class="panel-heading no-title"><center>Case Management</center> </div>
<div class="panel-body">
    <table class="table">
            <tr>
                <td>
                    <a href='<?= Url::to(["/mediator/report-case-management"], true) ?>'> 
                        List
                    </a>
                </td>
            </tr>               
    </table>
</div>
</div>
