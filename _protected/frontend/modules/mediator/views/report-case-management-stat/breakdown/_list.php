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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jobseeker', 
        'value' => function($model){
            return $model->jobseeker->fullName;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'gender', 
        'value' => function($model){
            return ($model->jobseeker->gender == 1) ? 'Male' : 'Female';
        },
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map([
                    ['id' => 1, 'name' => 'Male'],
                    ['id' => 2, 'name' => 'Female']
                ], 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'gender', 'id' => 'grid--gender'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'createdAt', 
        'value' => function($model) {
            return date('Y-m-d', strtotime($model->services->created_at) );
        }
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'phone', 
        'value' => function($model){
            return $model->user->phone;
        }
    ],

    [
        'header'=>'Application Title',
        'attribute' => 'event',
        'value'=> function($model){ 
            return  isset($model->applicationJob->job->jobtitle) ? $model->applicationJob->job->jobtitle : $model->applicationEvent->even->event_title;          
        },
        'format' => 'raw'
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'education', 
        'value' => function($model){
            return isset($model->jobseeker->jsEducation->educationLevel->level) ? $model->jobseeker->jsEducation->educationLevel->level : '-';
        }
    ], 
];
