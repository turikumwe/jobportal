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
use common\models\JsCaseManagement;

class JobSeeker {

    protected $now;

    const MAXDAY = 90;

    public function __construct() {
        $this->now = new \Datetime(date('Y-m-d'));
    }

    /*
     * $view should be a view like _form , create,update, view , index,... any page
     *
     *
     */

    public function menu() {
        $job_opportinities = SOpportunity::find()->firstType()->all();
        $event_opportinities = SOpportunity::find()->secondType()->all();
        ?>
        <div class="panel widget light-widget">
            <div class="panel-heading"><?= Yii::t("frontend", "Opportunity Type") ?></div>
            <div class="panel-body">
                <ul>
                    <li>
                        <a href="<?= Url::to(["/service/service-job"], true) ?>">
                            <?php echo Yii::t("frontend", "All"); ?><br>
                        </a>
                    </li>
                    <?php foreach ($job_opportinities as $opportunity) { ?>
                        <li>
                            <a href='<?= Url::to(["/service/service-job?opportunity=" . $opportunity->id], true) ?>'> <?= Yii::t("frontend", ucwords($opportunity->name)); ?>
                                <span class="pull-right">(<?= Yii::$app->reports->jobTypePublished($opportunity->id) ?>)</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="panel widget light-widget">
            <div class="panel-heading"><?= Yii::t("frontend", "Events") ?></div>
            <div class="panel-body">
                <ul>
                    <li>
                        <a href="<?= Url::to(["/service/service-job"], true) ?>">
                            <?php echo Yii::t("frontend", "All"); ?><br>
                        </a>
                    </li>
                    <?php foreach ($event_opportinities as $opportunity) {
                        ?>
                        <li>
                            <a href='<?= Url::to(["/service/service-event?opportunity=" . $opportunity->id], true) ?>'> <?= Yii::t("frontend", ucwords($opportunity->name)) ?>
                                <span class="pull-right">(<?= Yii::$app->reports->eventTypePublished($opportunity->id) ?>)</span>
                            </a>
                        </li>
                        <?php }
                    ?>
                </ul>
            </div>
        </div>
        <?php
    }

    public function profile($jobseeker) {
        return '
    		<div class="panel widget light-widget panel-bd-top">
				<div class="panel-heading"> 
					<center>
					<i class="glyphicon glyphicon-user"></i>
					' . $jobseeker->userProfile->fullName . '
					</center>
				</div>
				<div class="panel-body">							
					<div class="row">
						<table class="table">
							<tr>
								<td colspan="2">
									<center> 
										<span class="label label-warning">' . $this->status($jobseeker) . '</span>
									</center>
								</td>
							</tr>
							<tr>
								<td><i class="glyphicon glyphicon-time"></i></td>
								<td>
									' . date('d M Y', $jobseeker->created_at) . '
								</td>
							</tr>

							<tr>
								<td><i class="glyphicon glyphicon-earphone"></i></td>
								<td>
									' . $jobseeker->phone . '
								</td>
							</tr>

							<tr>
								<td><i class="glyphicon glyphicon-envelope"></i></td>
								<td>
									' . $jobseeker->email . '
								</td>
							</tr>						
						</table>
						<table class="table">
							<tr>
								<td><span class=""><b>Profile View</b></span></td>
								<td>
									<span class="pull-right"><b>' . $this->numberViewed($jobseeker->id) . '</b></span>
								</td>
							</tr>
						</table>
					</div>		
				</div>
			</div>
    	';
    }

    public function search() {
        return '
    		    <div class="panel widget light-widget" >
			        <div class="panel-heading">Search a Member</div>
			            <div class="panel-body">
			                    ' .
                AutoComplete::widget([
                    'name' => 'grobal_search',
                    'id' => 'profile',
                    'clientOptions' => [
                        'source' => UserProfile::data(),
                        'autoFill' => true,
                        'minLength' => '1',
                        'select' => new JsExpression("function( event, ui ) {
			                            search($('#profile').val(ui.item.id).val());
			                         }")
                    ],
                    'options' => [
                        'placeholder' => 'Search a member as you type ...',
                    ]
                ])
                . '
			            </div>
			    </div>
    	';
    }

    private function lastlogin($jobseeker) {
        $logged_at = User::findOne(['id' => $jobseeker])->logged_at;

        $logged = new \Datetime();
        $logged_at = $logged->setTimestamp($logged_at);

        return ($this->now->diff($logged_at)->days < SELF::MAXDAY) ? true : false;
    }

    private function lastTimeAtCenter($jobseeker) {

        $case = JsCaseManagement::find(['jobseeker_id' => $jobseeker])->orderBy(['created_at' => SORT_DESC])->limit(1);

        if (!empty($case->one()->created_at)) {
            $created_at = new \Datetime($case->one()->created_at);

            return ($this->now->diff($created_at)->days < SELF::MAXDAY) ? true : false;
        }
    }

    private function status($jobseeker) {

        if ($this->lastTimeAtCenter($jobseeker->id))
            return User::status($jobseeker->status);
        if ($this->lastlogin($jobseeker->id))
            return User::status($jobseeker->status);

        return User::status(User::STATUS_SLEEPING);
    }

    private function numberViewed($id) {
        $id = (int) $id;
        $query = "SELECT count(*) AS num FROM `timeline_event` where category = 'profile'
    							AND event = 'profile-view'
    							AND REPLACE(JSON_EXTRACT(data, '$.user_id'),'\"', '') =" . $id;

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($query);

        $result = $command->queryOne();

        return $result['num'];
    }

    public function numberViewedApportunity($id) {
        $id = (int) $id;
        $query = "SELECT count(*) AS num FROM `timeline_event` where category = 'visitor'
    							AND event = 'opportunity-view'
    							AND REPLACE(JSON_EXTRACT(data, '$.opportunity_id'),'\"', '') =" . $id;

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($query);

        $result = $command->queryOne();

        return $result['num'];
    }

    public function numberOfApplicants($id) {
        $id = (int) $id;
        $query = "SELECT count(*) AS num FROM `js_job_application` where job_id = " . $id;

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($query);

        $result = $command->queryOne();

        return $result['num'];
    }

}
