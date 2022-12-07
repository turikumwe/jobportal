<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use common\models\UserProfile;

return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => false],
    [
        'header'=>'Event Title',
        'attribute' => 'event',
        'value'=> function($model){ 
                   return $model->even->event_title;
        },
    ],
    
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'event_venue', 
        'value' => function($model){
            return $model->even->venue;
        }
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'event_start_date', 
        'value' => function($model) {
            return $model->even->start_date;
        }
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'event_end_date', 
        'value' => function($model) {
            return $model->even->end_date;
        },
    ],

     [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Male', 
        'value' => function($model){
           return $model->numberofGenderApplied(UserProfile::GENDER_MALE, $model->even_id);
        },
    ],

     [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Female', 
        'value' => function($model){
            return $model->numberofGenderApplied(UserProfile::GENDER_FEMALE, $model->even_id);
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width'=> '4%',
        'template' => '{view}',
        
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    ['/mediator/report-events-stat/view-event', 'opportunity' => isset($_GET['opportunity']) ? (int)$_GET['opportunity'] : null,'event_id' => $model->even_id], 
                    [
                        'title'=>'View',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            },
        ],
        
    ],
];
