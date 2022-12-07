<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use common\models\UserProfile;

$gfEvent = function ($model, $key, $index, $widget) {
    $event = isset($model->areaOfExpertise->expertise) ? $model->areaOfExpertise->expertise : '';
    return [
        'mergeColumns' => [[0, 1]], 
        'content' => [              // content to show in each summary cell
            0 => Yii::t('app','Summary ( '.$event.')' ),
            2 => GridView::F_SUM,
        ],
        'contentFormats' => [      // content reformatting for each summary cell
            2 => ['format' => 'number', 'decimals' => 0],
        ],
        'contentOptions' => [      // content html attributes for each summary cell
            0 => ['style' => 'font-variant:small-caps'],
            2 => ['class' => 'text-right'],
        ],
        'options'=>['class'=>'success','style'=>'font-weight:bold;font-size:14px']
    ];
};

return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => false], 

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'even_id',
        'label'     => 'Title',
        'value'     => 'even.event_title',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\ServiceEvent::find()->asArray()->all(), 'id', 'event_title'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Title', 'id' => 'grid--district'],
        'group' => true,  // enable grouping,
       // 'groupFooter'=> $gfEvent,
       // 'pageSummary' => 'Page Summary',
        'pageSummaryOptions' => ['class' => 'text-right'],
    ],

    [
        'class'       => '\kartik\grid\DataColumn',
        'attribute'   => 'Total',
        'value'       => 'stat',
        'hAlign'      => 'right',
        'pageSummary' => true,

    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    ['/mediator/report-application/event-breakdown', 'eventtitle' => $model->even_id, 'opportunity' => $model->s_opportunity_id], 
                    [
                        'title'=>'View',
                        'data-pjax' => '0',
                    ]
                );
            },
        ],
    ],

];   
