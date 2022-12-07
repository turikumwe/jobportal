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
                'attribute' => 'district_id',
                'label' => Yii::t('app', 'District'),
                'value' => function($model){
                    if ($model->district)
                    {return $model->district->district;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->asArray()->all(), 'id', 'district'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'S district', 'id' => 'grid--district_id']
            ],
        [
                'attribute' => 'mediator_id',
                'label' => Yii::t('app', 'Mediator'),
                'value' => function($model){
                    if ($model->mediator)
                    {return $model->mediator->madiator_name;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\MdMediator::find()->asArray()->all(), 'id', 'madiator_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Md mediator', 'id' => 'grid--mediator_id']
            ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'created_by',
    // ],
    // // [
    //     // 'class'=>'\kartik\grid\DataColumn',
    //     // 'attribute'=>'created_at',
    // // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'deleted_by',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'deleted_at',
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