
<?php 
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use common\models\EmplEmployer;
?>

<div class="panel widget light-widget" >
<div class="panel-heading"><?= Yii::t('frontend','Mediator Contact') ?></center></div>
    <div class="panel-body">

            <?php if ( !is_integer($mediator_contact)) { ?>
                
                <?php if(!empty($mediator_contact->one()->phone_number)) { ?>
                    <hr class="pd-1">
                    <h4>Phone: <?=$mediator_contact->one()->phone_number?></h4>
                <?php } ?>
                    
                <?php if(!empty($mediator_contact->one()->email_address)) { ?>
                    <hr>
                    <h4>Email:<?=$mediator_contact->one()->email_address?></h4>
                <?php } ?>

            <?php } else { ?> 
               <span class="label label-danger" >No Contact</span>
           <?php } ?>
    </div>
</div>