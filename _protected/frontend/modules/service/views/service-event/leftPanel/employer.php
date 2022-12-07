<div class="panel widget light-widget panel-bd-top">
	<div class="panel-heading no-title"> </div>
    <div class="panel-body">
       <div class="text-center vd_info-parent"> 

            <img 
                src="<?php // $mediator->mediatorProfile->getAvatar($this->assetManager->getAssetUrl($bundle,'img/anonymous.jpg')) ?>"
                class="user-image"
            >
        </div>              
            
            <center>
                <?php if($employer->status == 2){?>
                    <span class="label label-success">Active</span>
                <?php } else if($employer->status == 1) { ?>
                    <span class="label label-warning">No Active</span>
                <?php } else { ?>
                    <span class="label label-danger">Deleted</span>
                <?php } ?>
            </center>          
    
        <div class="mgtp-20">
            <table class="table table-striped table-hover">
            <tbody>
            <tr>
            <td style="width:40%;">
                Messages 
            </td>
            <td>
                <span class="label label-primary"><?= \common\models\JsMessage::find()->received()->new()->count()?> <sup>New</sup></span>
            </td>
            </tr>
        
            <tr>
            <td>Since</td>
            <td><?= date('d M Y',$employer->created_at)?></td>
            </tr>
            </tbody>
            </table>
        </div>

        <div>
           <center> 
                <h2>
                    <a href="/service/service-event/post-opportunity">
                        <span class="label label-danger" style="color:white">Post</span>
                    </a>
                </h2>
        	</center>
        </div>

    </div>
</div>