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
        'header'=>'Economic Sector',
        'attribute' => 'event_title',
        'value'=> function($model){ 
                   return  Html::a($model->event_title, ['/service/service-job/view-modal','id'=>$model->id], 
                   [
                    'class' => 'text-primary', 
                    'id' => 'popupModal',
                    'role'=>'modal-remote',
                    'title'=>'View Event',
                    'data-toggle'=>'tooltip',
                    'data-pjax' => '0',
                ]);      
        },
        'format' => 'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'numberOfAdvertised',
        'value' => function($model) {
           
            return $model->totalJobByEconomicSector($model->economic_sector_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'numberOfActive',
        'value' => function($model) {
           
            return $model->totalAvailableByEconomicSector($model->economic_sector_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'numberOfActive',
        'value' => function($model) {
           
            return $model->totalArchivedByEconomicSector($model->economic_sector_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
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
                    ['/mediator/report-economic-sector/view-event', 'opportunity' => isset($_GET['opportunity']) ? (int)$_GET['opportunity'] : null,'economic_sector_id' => $model->economic_sector_id], 
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
