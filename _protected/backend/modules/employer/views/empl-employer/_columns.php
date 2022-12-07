<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\Html;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'company_name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'company_name_abbraviatio',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'avatar_path',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'avatar_base_url',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'parent',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'child',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'employer_type_id',        
        'label'=>'Employer type',
        'value' => 'employerType.type',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\SEmployerType::find()->asArray()->all(), 'id', 'type'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Employer type', 'id' => 'grid--employer_type_id'] 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'opening_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'registration_authority_id',        
        'label'=>'Registration authority',
        'value' => 'registrationAuthority.registrationauthority',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\SRegistrationauthority::find()->asArray()->all(), 'id', 'registrationauthority'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Registration authority', 'id' => 'grid--registration_authority_id'] 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tin',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'mediator_status',
        'format' => 'raw',
        'label' => 'Status',
        'value' => 'is_verified',
        'value' => function ($data) {
            $employer = \common\models\EmplEmployer::findOne($data->id);
            if ($employer->is_verified == 0) {
                return 'Not verified | ' . Html::a('<span data-toggle="modal" data-target="#myModal">Mark as verified</span>', ['#'], ['onclick' => 'return confirm_action(' . $employer->id . ',1)']);
            }
            if ($employer->is_verified == 1) {
                return 'Verified | ' . Html::a('<span style="color: red;" data-toggle="modal" data-target="#myModal">Deactivate</span>', ['#'], ['onclick' => 'return confirm_action(' . $employer->id . ',0)']);
            }
        },
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ownership_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_address',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_economic_sector',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_employer_status',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_reference',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_employer_summary',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_manager',
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
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   