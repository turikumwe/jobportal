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
        'header'=>'Job Title',
        'attribute' => 'jobtitle',
        'value'=> function($model){ 
                   return  Html::a($model->jobtitle, ['/service/service-job/view-modal','id'=>$model->id], 
                   [
                    'class' => 'text-primary', 
                    'id' => 'popupModal',
                    'role'=>'modal-remote',
                    'title'=>'View Job',
                    'data-toggle'=>'tooltip',
                    'data-pjax' => '0',
                ]);      
        },
        'format' => 'raw'
    ],
    [
        'header'=>'Economic Sector',
        'attribute' => 'economic_sector_id',
        'value'=> function($model){ 
                   return  Html::a($model->economicSector->occupation, ['/service/service-job/view-modal','id'=>$model->id], 
                   [
                    'class' => 'text-primary', 
                    'id' => 'popupModal',
                    'role'=>'modal-remote',
                    'title'=>'View Job',
                    'data-toggle'=>'tooltip',
                    'data-pjax' => '0',
                ]);      
        },
        'format' => 'raw'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'posting_date',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'closure_date',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'active',
        'value' => function($model) {
            return (strtotime($model->closure_date) >= strtotime(date('Y-m-d')) ) ? 'Yes' : 'No';
        },
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map([
                    ['id' => 1, 'name' => 'Yes'],
                    ['id' => 2, 'name' => 'No'],
                    ['id' => 0, 'name' => 'All'],
                ], 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'active', 'id' => 'grid--active'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'archive',
        'value' => function($model) {
            return (strtotime($model->closure_date) < strtotime(date('Y-m-d')) ) ? 'Yes' : 'No';
        },
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map([
                    ['id' => 1, 'name' => 'Yes'],
                    ['id' => 2, 'name' => 'No'],
                    ['id' => 0, 'name' => 'All'],
                ], 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'archive', 'id' => 'grid--archive'],
    ],
];
