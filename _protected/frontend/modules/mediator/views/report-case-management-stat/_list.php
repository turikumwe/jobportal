<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use common\models\UserProfile;

return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => false],
    //service offere
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'service', 
        'value' => function($model){
           return $model->services->name;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Male', 
        'value' => function($model){
           return $model->numberofGender(UserProfile::GENDER_MALE, $model->given_service);
        },
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Female', 
        'value' => function($model){
            return $model->numberofGender(UserProfile::GENDER_FEMALE, $model->given_service);
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Total', 
        'value' => function($model){
            return $model->numberofGenderTotal($model->given_service);
        },
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
                    ['/mediator/report-case-management-stat/view','service' => $model->given_service], 
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
