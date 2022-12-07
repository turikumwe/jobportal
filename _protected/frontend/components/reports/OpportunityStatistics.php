<?php
/**
 * Created by PhpStorm.
 * User: Pacifique Karinda.
 * Date: 26/10/19
 * Time: 7:30 AM
 */

namespace frontend\components\reports;

use Yii;
use yii\helpers\Url;
use yii\db\Expression;
use backend\models\SStatus;
use backend\models\SActions;
use common\models\ServiceJob;
use common\models\ServiceEvent;
use common\models\JsJobApplication;
use common\models\JsEventApplication;

class OpportunityStatistics
{
    //TODO CHANGE NAME TO jobTypeApplicationCount
    public function jobTypeApplicationPublished($opportunity)
    {
        return JsJobApplication::find()->type($opportunity)->count(); 
    }

    public function eventTypeApplicationPublished($opportunity)
    {
        return JsEventApplication::find()->type($opportunity)->count(); 
    }

    public function jobType($opportunity=null , $action_id = null)
    {
       
        $jobs = ServiceJob::find()->opportunity($opportunity)->freshFirst();

        return $jobs;
        
    }

    public function eventType($opportunity = null)
    {        
        $events =  ServiceEvent::find()->opportunity($opportunity)->freshFirst();
        return $events;
  
    }

    public function eventsDetails($opportunity = null)
    {        
        $events =  JsEventApplication::find()->type($opportunity)->freshFirst();
        return $events;
  
    }

    public function jobEconomicSectorType($opportunity=null, $economic_sector_id = null)
    {
        $jobs = ServiceJob::find()->select(['economic_sector_id'])->opportunity($opportunity)
                                ->economicSector($economic_sector_id)
                                ->andWhere('economic_sector_id is not null')
                                ->groupBy('economic_sector_id');
        return $jobs;
        
    }

    public function eventEconomicSectorType($opportunity = null , $economic_sector_id = null)
    {        
        $events =  ServiceEvent::find()->select(['economic_sector_id'])->opportunity($opportunity)
                                ->economicSector($economic_sector_id)
                                ->andWhere('economic_sector_id is not null')
                                ->groupBy('economic_sector_id');
        return $events;
  
    }

    public function jobEconomicSectorBreakdown($opportunity=null, $economic_sector_id = null)
    {
        $jobs = ServiceJob::find()->opportunity($opportunity)
                                ->economicSector($economic_sector_id)
                                ->andWhere('economic_sector_id is not null');
        return $jobs;
        
    }

    public function eventEconomicSectorBreakdown($opportunity = null , $economic_sector_id = null)
    {        
        $events =  ServiceEvent::find()->opportunity($opportunity)
                                ->economicSector($economic_sector_id)
                                ->andWhere('economic_sector_id is not null');
        return $events;
  
    }

    public function jobTypePublished($opportunity)
    {
        return ServiceJob::find()->where(['s_opportunity_id' => $opportunity])
                                ->available()
                                ->action(1) //TODO GET ACTION ID FROM S_ACTION TABLE
                                ->count(); 
    }

    public function jobTypeUnPublished($opportunity)
    {
        return ServiceJob::find()->opportunity($opportunity)
                                 ->available()
                                 ->action(2) //TODO GET ACTION ID FROM S_ACTION TABLE 
                                 ->count();
    }

     public function eventTypePublished($opportunity)
    {
        return ServiceEvent::find()->where(['s_opportunity_id' => $opportunity])
                                    ->available()
                                    ->andWhere(['action_id' => 1])//TODO GET ACTION ID FROM S_ACTION TABLE
                                    ->count(); 
    }

    public function eventTypeUnPublished($opportunity)
    {
        return ServiceEvent::find()->opportunity($opportunity)
                                   ->available()
                                   ->andWhere(['action_id' => 2])//TODO GET ACTION ID FROM S_ACTION TABLE
                                   ->count();
    }

    public function jobStatus($opportunity)
    {
        foreach(SStatus::find()->all()  as $row ){
            $number = JsJobApplication::find()->where(['s_opportunity_id' => $opportunity])
                                           ->andWhere(['status_id' => $row['pk_status'] ])
                                           ->count(); 
            $this->panel($row['status'], $number);

        }
    }

    public function eventStatus($opportunity)
    {
        foreach(SStatus::find()->all()  as $row ){
            $number = JsEventApplication::find()->where(['s_opportunity_id' => $opportunity])
                                           ->andWhere(['status_id' => $row['pk_status'] ])
                                           ->count(); 
            $this->panel($row['status'], $number);

        }
    }

    private function panel($status, $number) {
        echo '<div class="col-lg-3 panel panel-info text-center panel-bd-left size">
            <div class="panel-heading">'.Yii::t("frontend",ucwords($status)).'</div>
            <span style="font-size: 20px;">'.$number.'</span>
        </div>';
    }

    public function jobAction($opportunity)
    {
        foreach(SActions::find()->all()  as $row ){
            $number = ServiceJob::find()->where(['id' => $opportunity])
                                           ->andWhere(['action_id' => $row['pk_action'] ])
                                           ->count(); 
            $this->panel($row['action'], $number);

        }
    }

    public function eventAction($opportunity)
    {
        foreach(SActions::find()->all()  as $row ){
            $number = ServiceEvent::find()->where(['id' => $opportunity])
                                           ->andWhere(['action_id' => $row['pk_action'] ])
                                           ->count(); 
            $this->panel($row['status'], $number);

        }
    }

}
?>

