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
        'attribute' => 'company',
        'value' => function ($model) {
            return $model->job->employer;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'user_id',
        'value' => function ($model) {
            if (!empty($model->user->userProfile->fullName)) {
                return $model->user->userProfile->fullName;
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'gender',
        'value' => function ($model) {
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
        'attribute' => 'phone',
        'value' => function ($model) {
            return $model->user->phone;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'application_date',
        'value' => function ($model) {
            return date('Y-m-d', strtotime($model->application_date));
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'start_date',
        'value' => function ($model) {
            return $model->job->posting_date;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'job_end_date',
        'value' => function ($model) {
            return $model->job->closure_date;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'opportunity',
        'value' => function ($model) {
            return $model->opportunity->name;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'district',
        'value' => function ($model) {
            if (!empty($model->user->userProfile->jsAddress->district->district)) {
                return $model->user->userProfile->jsAddress->district->district;
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'sector',
        'value' => function ($model) {
            if (!empty($model->user->userProfile->jsAddress->geosector->sector)) {
                return $model->user->userProfile->jsAddress->geosector->sector ? $model->user->userProfile->jsAddress->geosector->sector : 'Null';
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'country',
        'value' => function ($model) {
            if (!empty($model->user->userProfile->jsAddress->country->cc_description)) {
                return $model->user->userProfile->jsAddress->country->cc_description;
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'education',
        'value' => function ($model) {
            if (!empty($model->user->jsEducation->educationLevel->level)) {
                return ($model->user->jsEducation->educationLevel->level) ? $model->user->jsEducation->educationLevel->level : '-';
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'placement',
        'value' => function ($model) {
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
        'filterInputOptions' => ['placeholder' => 'active', 'id' => 'grid--active'],
    ],
];
