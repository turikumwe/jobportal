<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView; 

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
        'attribute'=>'person_id',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\CommonPerson::find()->asArray()->all(), 'id', 'id'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Manager', 'id' => 'grid--person_id']
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'person_id',
    //     'label'=>'Manager',
    //     'value' => 'person.employerManagers.fullName',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'employer_id',
        'label'=>'Employer',
        'value' => 'employer.company_name',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\EmplEmployer::find()->asArray()->all(), 'id', 'company_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Employer', 'id' => 'grid--employer_id'] 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'start_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'end_date',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'created_by',
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