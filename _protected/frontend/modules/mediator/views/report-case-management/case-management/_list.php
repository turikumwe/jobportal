<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use common\models\UserProfile;

return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => false], 
            'jobseeker.fullName',
            'availability',
            [
                'attribute' => 'given_service',
                'label'     => 'Service',
                //'value' => $model->services->name,
            ],
            'typeOfJob.job_type',
            'willingness',
            'license_permit',
    //        'geven_service_description:ntext',
    //         'cooperative:ntext',
    //         'mediotor.madiator_name',
    //         'created_at',
    //         [
    //             'attribute' => 'created_by',
    //             'label'     => 'Submitted By',
    //             'value' => (isset($model->createdBy->mediatorProfile->madiator_name)) ? $model->createdBy->mediatorProfile->madiator_name : '',
    //         ],

    // [
    //     'class'       => '\kartik\grid\DataColumn',
    //     'attribute'   => 'Total',
    //     'value'       => 'stat',
    //     'hAlign'      => 'right',
    //     'pageSummary' => true,

    // ],

    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'template' => '{view}',
    //     'buttons' => [
    //         'view' => function ($url, $model) {
    //             return Html::a(
    //                 '<span class="glyphicon glyphicon-eye-open"></span>',
    //                 ['/mediator/report-application/event-breakdown', 'expertise' => $model->area_of_expertise_id, 'opportunity' => $model->s_opportunity_id], 
    //                 [
    //                     'title'=>'View',
    //                     'data-pjax' => '0',
    //                 ]
    //             );
    //         },
    //     ],
    // ],

];   
