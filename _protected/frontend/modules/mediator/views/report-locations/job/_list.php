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
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'districts.district',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'numberOfAdvertised',
        'value' => function($model) {
           
            return $model->totalJobByDistrict($model->district_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'numberOfActive',
        'value' => function($model) {
           
            return $model->totalAvailableByDistrict($model->district_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'numberOfActive',
        'value' => function($model) {
           
            return $model->totalArchivedByDistrict($model->district_id);
        
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
                    ['/mediator/report-locations/view', 'opportunity' => isset($_GET['opportunity']) ? (int)$_GET['opportunity'] : null,'district_id' => $model->district_id], 
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
