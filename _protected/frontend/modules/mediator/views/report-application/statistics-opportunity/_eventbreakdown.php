<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use common\models\UserProfile;
use common\models\JsEventApplication;

$opportunity = (int)$_GET['opportunity'];
$event = (int)$_GET['eventtitle'];
return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => false],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'even_id',
        'label'     => 'Event Title',
        'value'     => 'even.event_title',
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
                'filter' => \yii\helpers\ArrayHelper::map(JsEventApplication::jobseekersApplied($event, $opportunity), 'id', 'name'),
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
        'value'=>function ($model, $url) {
            if ($model->status->label == 'waiting') {
                return '<span class="label label-warning">'.$model->status->status.'</span>';
            } elseif ($model->status->label == 'success') {
                return '<span class="label label-success">'.$model->status->status.'</span>';
            } elseif ($model->status->label == 'danger') {
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
                'filterInputOptions' => ['placeholder' => 'Completed', 'id' => 'grid--placed'],
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
        'width' => '10%',
        'template' => '{view} {update}  {profile}',
        
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    ['/jobseeker/js-event-application/view', 'id' => $model->id],
                    [
                        //'role'=>'modal-remote',
                        'title'=>'View',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            },
            'update' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    ['/jobseeker/js-event-application/update-application', 'id' => $model->id],
                    [
                        //'role'=>'modal-remote',
                        'title'=>'Update',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            },

            // 'placement' => function ($url, $model) {
            //     return Html::a(
            //         '<span class="glyphicon glyphicon-map-marker"></span>',
            //         ['/jobseeker/js-case-management/placement', 'jobseeker_id' => $model->user_id, 'applicationid' => $model->id, 'type' => 'event'],
            //         [
            //             'title'=>'Placement',
            //             'role'=>'modal-remote',
            //             'data-toggle'=>'tooltip',
            //             'data-pjax' => '0',
            //         ]
            //     );
            // },

            'profile' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-user"></span>',
                    ['/jobseeker/user-profile/index', 'idOtherProfile' => $model->user_id, 'employer' => 1],
                    [
                        //'role'=>'modal-remote',
                        'title'=>'Profile',
                        'data-toggle'=>'tooltip',
                        'data-pjax' => '0',
                    ]
                );
            }
        ],
        
    ],
];
