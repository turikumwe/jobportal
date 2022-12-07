<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use common\models\UserProfile;
use common\models\JsJobApplication;
$opportunity = (int)$_GET['opportunity'];
$job = (int)$_GET['job'];

return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => false], 

    [
        'header'=>'Job',
        'value'=> function($data){ 
                   return  Html::a($data->job->jobtitle.' <i class="glyphicon glyphicon-arrow-up"></i>', ['/service/service-job/view-modal','id'=>$data->job_id], 
                   [
                    'class' => 'text-primary', 
                    'id' => 'popupModal',
                    'role'=>'modal-remote',
                    'title'=>'View Job',
                    'data-toggle'=>'tooltip',
                    'data-pjax' => '0',
                ]);      
        },
        'format' => 'raw',
        'group' => true,  // enable grouping,
        'groupedRow' => true,
        'groupEvenCssClass' => 'kv-grouped-row',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'user_id',
        'label'     => 'Fullname',
        'value'     => 'user.userProfile.fullname',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(JsJobApplication::jobseekersApplied($job, $opportunity), 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Jobseeker', 'id' => 'grid--user_profile']
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'status_id',
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
       // 'value' => 'status.status',
        'value'=>function($model,$url){
                if($model->status->label == 'waiting')
                {
                    return '<span class="label label-warning">'.$model->status->status.'</span>';
                }
                elseif($model->status->label == 'success')
                {
                     return '<span class="label label-success">'.$model->status->status.'</span>';
                }
                 elseif($model->status->label == 'danger')
                {
                     return '<span class="label label-danger">'.$model->status->status.'</span>';
                }
            },
         'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SStatus::find()->asArray()->all(), 'pk_status', 'status'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'status', 'id' => 'grid--status'],
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'placement',
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width'=> '12%',
        'value'=>function($model,$url){
                if($model->placement == 1)
                {
                    return '<span class="label label-success">Yes</span>';
                }else
                {
                     return '<span class="label label-danger">No</span>';
                }
            },
         'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(
                    [
                        ['id' => 0 , 'name' => 'No'],
                        ['id' => 1 , 'name' => 'Yes']
                    ], 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'placement', 'id' => 'grid--placed'],
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'user.email',
        'vAlign' => 'middle',
        'width'=> '12%',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'user.phone',
        'vAlign' => 'middle',
        'width'=> '12%',
    ],
  
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width'=> '8%',
        'template' => '{view} {update} {placement} {profile}',
        
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    ['/jobseeker/js-job-application/view', 'id' => $model->id], 
                    [
                        'role'=>'modal-remote',
                        'title'=>'View',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            },
            'update' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    ['/jobseeker/js-job-application/update-application', 'id' => $model->id], 
                    [
                        'role'=>'modal-remote',
                        'title'=>'Status',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            },
            'placement' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-map-marker"></span>',
                    ['/jobseeker/js-case-management/placement', 'jobseeker_id' => $model->user_id, 'applicationid' => $model->id,'type' => 'job'],
                    [
                        'title'=>'Placement',
                        'role'=>'modal-remote',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            },

            'profile' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-user"></span>',
                    ['/jobseeker/user-profile/index', 'idOtherProfile' => $model->user_id, 'employer' => 1], 
                    [
                        'title'=>'Profile',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            },
        ],
        
    ],
];   
