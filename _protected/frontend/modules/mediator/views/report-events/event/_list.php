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
        'attribute' => 'user_id', 
        'value' => function($model){
            return isset($model->user->userProfile->fullName);
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'user_gender', 
        'value' => function($model){
           if(!empty($model->user->userProfile->gender)){
        return ($model->user->userProfile->gender == 1) ? 'Male' : 'Female';
           }
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
        'attribute' => 'event_start_date', 
        'value' => function($model) {
            return isset( $model->even->start_date);
        }
    ],

     [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'event_end_date', 
        'value' => function($model) {
            return isset( $model->even->end_date);
        },

    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'user_id', 
        'value' => function($model){
            //return  ($model->user->userProfile->document_type == 1) ? $model->user->userProfile->passport_number : $model->user->userProfile->id_number;
        }
    ],

    [
        'header'=>'Event Title',
        'attribute' => 'event',
        'value'=> function($model){ 
                   return  Html::a($model->even->event_title, ['/service/service-job/view-modal','id'=>$model->id], 
                   [
                    'class' => 'text-primary', 
                    'id' => 'popupModal',
                    'role'=>'modal-remote',
                    'title'=>'View Event',
                    'data-toggle'=>'tooltip',
                    'data-pjax' => '0',
                ]);      
        },
        'format' => 'raw'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'event_venue', 
        'value' => function($model){
            return isset( $model->even->venue);
        }
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'education', 
        'value' => function($model){
            return isset($model->user->jsEducation->educationLevel->level) ? $model->user->jsEducation->educationLevel->level : '-';
        }
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'placement',
        'value' => function($model) {
            return ($model->placement == 1) ? 'Yes' : 'No';
        },
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map([
                    ['id' => 1, 'name' => 'Yes'],
                    ['id' => 0, 'name' => 'No']
                ], 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'placement', 'id' => 'grid--placement'],
    ],
   

];
