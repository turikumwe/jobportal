<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [

     // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'label'=>'Job Seeker',
        'value' => 'user.userProfile.fullName'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'school',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'country_id',
        'value' => 'country.cc_description'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'education_level_id',
        'value' => 'educationLevel.level'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'education_field_id',
        'value' => 'educationField.field'
    ],
    
    
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'exact_quali',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'start_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'end_date',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'grade_id',
        'value' => 'grade.grade'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'certificate_id',
        'value'=>'certificate.certificate',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'certificate_path',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'certificate_base_url',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'deleted_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'deleted_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{restore}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [ 
            'restore' => function ($url) { 
            return Html::a('<span class="glyphicon glyphicon-arrow-up"> </span>', $url, 
                                [ 
                                    //'title' => 'Restore Item', 
                                    //'data-pjax' => '0',
                                    'role'=>'modal-remote','title'=>'Restore', 
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-toggle'=>'tooltip',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to restore this item' 
                                ] 
                            );
                }
            ],
    ],

];   