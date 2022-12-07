<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use common\models\UserProfile;

$gfJob = function ($model, $key, $index, $widget) {
    $job = isset($model->job->jobtitle) ? $model->job->jobtitle : '';
    return [
        'mergeColumns' => [[0, 1]], 
        'content' => [              // content to show in each summary cell
            0 => Yii::t('app','Summary ( '.$job.')' ),
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
        'attribute' => 'job_id',
        'label'     => 'Title',
        'value'=> 'job.jobtitle',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\ServiceJob::find()->asArray()->all(), 'id', 'jobtitle'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Title', 'id' => 'grid--district'],
        'group' => true,  // enable grouping,
       //'groupFooter'=> $gfJob,
       // 'pageSummary' => 'Page Summary',
        'pageSummaryOptions' => ['class' => 'text-right'],
    ],

    // [
    //     'class'       => '\kartik\grid\DataColumn',
    //     'attribute'   => 'Total Accepted',
    //     'value'       => 'accepted',
    //     'hAlign'      => 'right',
    //     'pageSummary' => true,

    // ],

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
        'template' => '{view} {job}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    ['/mediator/report-application/job-breakdown', 'job' => $model->job_id, 'opportunity' => $model->s_opportunity_id], 
                    [
                        'title'=>'View',
                        'data-pjax' => '0',
                    ]
                );
            },
        'job' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-arrow-up"></span>',
                    ['/service/service-job/view-modal','id'=>$model->job_id], 
                    [
                        'role'=>'modal-remote',
                        'title'=>'View Job',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            },
        ],
    ],
]; 
