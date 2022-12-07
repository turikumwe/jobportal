<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView; 

return [

    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Education Field',
        'attribute' => 'educationField.field',
    ],
      
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'number',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Total Number',
        'value' => function($model) {
           
            return $model->totalJobseekersByEducationfield($model->education_field_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'PhD',
        'value' => function($model) {
           
            return $model->totalWithPhd($model->education_field_id,$model->education_level_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Masters',
        'value' => function($model) {
           
            return $model->totalWithMasters($model->education_field_id,$model->education_level_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Bachelor',
        'value' => function($model) {
           
            return $model->totalWithBachelor($model->education_field_id,$model->education_level_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Diploma',
        'value' => function($model) {
           
            return $model->totalWithDiploma($model->education_field_id,$model->education_level_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Advanced Level',
        'value' => function($model) {
           
            return $model->totalWithALevel($model->education_field_id,$model->education_level_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Ordinary Level',
        'value' => function($model) {
           
            return $model->totalWith0Level($model->education_field_id,$model->education_level_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => '6 Years',
        'value' => function($model) {
           
            return $model->totalWith6Years($model->education_field_id,$model->education_level_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Uknown',
        'value' => function($model) {
           
            return $model->totalWithUknown($model->education_field_id,$model->education_level_id);
        
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        
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
                    ['/mediator/report-job-seeker/view', 'opportunity' => isset($_GET['opportunity']) ? (int)$_GET['opportunity'] : null,'education_field_id' => $model->education_field_id], 
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