<?php

use yii\widgets\DetailView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model common\models\ServiceEvent */
?>
<div class="service-event-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [   
                'attribute' => 'event_title',
                'value' => $model->event_title,
                'visible' => isset($model->event_title) ? true : false,
            ],

            //added fields

            [   
                'attribute' => 's_opportunity_id',
                'value' => strip_tags(isset($model->opportunity->name)?$model->opportunity->name:"-"),
                'visible' => isset($model->opportunity->name) ? true : false,
            ],
            [   
                'attribute' => 'event_duration',
                'value' => strip_tags(isset($model->eventDuration->name)?($model->eventDuration->name):"-"),
                'visible' => isset($model->eventDuration->name) ? true : false,
            ],
            [   
                'attribute' => 'description_organiser',
                'value' => strip_tags($model->description_organiser),
                'visible' => isset($model->description_organiser) ? true : false,
            ],
            [   
                'attribute' => 'description_event',
                'value' => strip_tags($model->description_event),
                'visible' => isset($model->description_event) ? true : false,
            ],
            [   
                'attribute' => 'qualification_participant',
                'value' => strip_tags($model->qualification_participant),
                'visible' => isset($model->qualification_participant) ? true : false,
            ],

            //End added fields
            
            [
                'attribute' => 'event_summary',
                'value' => strip_tags($model->event_summary),
                'visible' => isset($model->event_summary) ? true : false,
            ],
            [   
                'attribute' => 'event_requirement',
                'value' => $model->event_requirement,
                'visible' => isset($model->event_requirement) ? true : false,
                'format' => 'raw',
            ],
            [
                'attribute' => 'event_location',
                'value' => strip_tags($model->location->sector)
            ],
            'number_participant',
            'venue',
            'start_date',
            'closure_date',
            'how_to_apply:ntext',
            // 'contact_phone',
            // 'contact_email:email',
            // 'posted',
            // [   
            //     'attribute' => 'action_id',
            //     'value' => isset($model->action->action) ? $model->action->action : '-',
            // ],
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
<?php 
if(Yii::$app->user->can('user')) { ?>
    <?php if($apply->eventApplied($model->id) == 0 && $model->apply_through_kora_flag==1) { ?> 
    <?php 
        Modal::begin([
            'header' => 'Apply Now:'.$model->event_title,
            "class" => "vd_bg-red", 
            'toggleButton' => [
            'class' => 'btn vd_btn btn-xs vd_bg-green',
            'label' => 'Apply Now <i class="glyphicon glyphicon-apply" aria-hidden="true"></i>'
        ],
            'footer'=> ''
        ]);
            $request = \Yii::$app->request;
            echo $this->render('opportunity/_apply', [
                'model'       => $apply,
                'get'         => $model,
                'opportunity' => $model->opportunity->id
        ]);  
        Modal::end();
    }else if ($apply->eventApplied($model->id) != 0 && $model->apply_through_kora_flag == 1) {
        echo "<span class='btn btn-large btn-default'>Applied </span>";
    }
}
?>

