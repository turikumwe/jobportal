<?php
/**
 * Created by PhpStorm.
 * User: Ntabana coco.
 * Date: 02/09/18
 * Time: 9:00 PM
 */

namespace frontend\components\menu;

use Yii;
use yii\helpers\Url;
use common\models\User;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use common\models\UserProfile;
use common\models\SOpportunity;

class JobSeeker 
{

	/*
	* $view should be a view like _form , create,update, view , index,... any page
	*
	*
	*/
   	public function menu()
    { 
    	$job_opportinities = SOpportunity::find()->firstType()->all();
    	$event_opportinities = SOpportunity::find()->secondType()->all();

	?>
		<div class="panel widget light-widget panel-bd-top">
            <div class="panel-heading no-title"> <h3><center>Employment  Opportunities</center></h3> </div>
            <div class="panel-body">
				<table class="table">
					<?php foreach($job_opportinities as $opportunity){ ?>
					    <tr>
					        <td>
					            <h5>
					            	<i class="glyphicon glyphicon-chevron-right"></i>
					               <a href='<?= Url::to(["/service/service-job?opportunity=".$opportunity->id], true) ?>'> <?=ucwords($opportunity->name)?> </a>
					            </h5>
					        </td>
					    </tr>
					<?php } ?>
				</table>
			</div>
		</div>

		<div class="panel widget light-widget panel-bd-top">
            <div class="panel-heading no-title"> <h3><center>Events</center></h3> </div>
            <div class="panel-body">
				<table class="table">
					<?php foreach($event_opportinities as $opportunity){ ?>
					    <tr>
					        <td>
					            <h5>
					            	<i class="glyphicon glyphicon-chevron-right"></i>
					               <a href='<?= Url::to(["/service/service-event?opportunity=".$opportunity->id], true) ?>'> <?=ucwords($opportunity->name)?> </a>
					            </h5>
					        </td>
					    </tr>
					<?php } ?>
				</table>
			</div>
		</div>
	<?php
    }

    public function profile($jobseeker){

    	return '
    		<div class="panel widget light-widget panel-bd-top">
				<div class="panel-heading no-title"> 
					<center>
						<h4 class="font-semibold mgbt-xs-5">
							<i class="glyphicon glyphicon-user"></i>
							<b>'. $jobseeker->userProfile->fullName.'</b>
						</h4>
					</center>
				</div>
				<div class="panel-body">							
					<div class="row">
						<table class="table">
							<tr>
								<td colspan="2">
									<center> 
										<span class="label label-warning">'.  User::status($jobseeker->status).'</span>
									</center>
								</td>
							</tr>
							<tr>
								<td><i class="glyphicon glyphicon-time"></i></td>
								<td>
									'. date('d M Y',$jobseeker->created_at).'
								</td>
							</tr>

							<tr>
								<td><i class="glyphicon glyphicon-earphone"></i></td>
								<td>
									'.$jobseeker->phone.'
								</td>
							</tr>

							<tr>
								<td><i class="glyphicon glyphicon-envelope"></i></td>
								<td>
									'.$jobseeker->email.'
								</td>
							</tr>
						</table>
					</div>		
				</div>
			</div>
    	';
    }

    public function search(){
    	return '
    		    <div class="panel widget light-widget panel-bd-top" >
			        <div class="panel-heading no-title"><center><b>Search a Member</b></center> </div>
			            <div class="panel-body">
			                    '. 
			                    	AutoComplete::widget([
			                        'name' => 'grobal_search',
			                        'id' => 'profile',
			                        'clientOptions' => [
			                        'source' => UserProfile::data(),
			                        'autoFill'=>true,
			                        'minLength'=>'1',
			                        'select' => new JsExpression("function( event, ui ) {
			                            search($('#profile').val(ui.item.id).val());
			                         }")],
			                        'options' => [
			                            'placeholder' => 'Search a member as you type ...',
			                        ]
			                         ])
			                    .'
			            </div>
			    </div>
    	';
    }
}
