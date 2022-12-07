<?php
use yii\helpers\Url;
use kartik\grid\GridView;

return [
    
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
       
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'registration_authority_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'registration_number',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'madiator_name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'mediator_type_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'opening_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ownership_id',
    ],
    
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => true,
        'vAlign'=>'middle',
        'template' => '{View}',
        'urlCreator' => function($action, $model, $key, $index) {
                return  Html::a(isset($model->mediator_name), ['/mediator/md-mediator/index?','idOtherProfile'=>$model->id]);
        },
        'viewOptions'=>['title'=>'View','data-bs-toggle'=>'tooltip'],
    ],

]; 
        
       