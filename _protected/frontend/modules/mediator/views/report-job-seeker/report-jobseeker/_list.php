<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView; 

return [

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'district.district',
    ],
      
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'number',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'number',
        'value' => function($model) {
           
            return $model->totalJobseekersByDistrict($model->district_id);
        
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
                    '<span class="fa fa-eye"></span>',
                    ['/mediator/report-job-seeker/view', 'opportunity' => isset($_GET['opportunity']) ? (int)$_GET['opportunity'] : null,'district_id' => $model->district_id], 
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