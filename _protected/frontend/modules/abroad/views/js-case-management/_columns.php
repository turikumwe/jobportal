<?php
use yii\helpers\Url;
use kartik\grid\GridView; 

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'jobseeker_id',
        'label'=>'Job applicant',
        'width' => '300px',
        'value' => 'jobseeker.fullName',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\UserProfile::jobSeekers()->asArray()->all(), 'user_id', 'fullName'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Job applicant', 'id' => 'grid--jobseeker_id']
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'availability',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'given_service',
        'label'=>'Service',
        'width' => '300px',
        'value' => 'services.name',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\SServices::find()->asArray()->all(), 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Services', 'id' => 'grid--service_id']
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type_of_job',
        'width' => '300px',
        'value' => 'typeOfJob.job_type',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SJobType::find()->asArray()->all(), 'id', 'job_type'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Type', 'id' => 'grid--jobtype_id']
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'willingness',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'license_permit',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'geven_service_description',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cooperative',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'mediotor_id',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
    ],

];   