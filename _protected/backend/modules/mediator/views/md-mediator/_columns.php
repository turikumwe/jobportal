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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'madiator_name',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'mediator_type_id',
        'label' => 'Mediator type',
        'value' => 'mediatorType.mediator_type',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'registration_authority_id',
        'label' => 'Registration authority',
        'value' => 'registrationAuthority.registrationauthority',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'registration_number',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'opening_date',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ownership_id',
        'label' => 'Ownership',
        'value' => 'ownership.ownership',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'mediator_status',
        'format' => 'raw',
        'label' => 'Status',
        'value' => 'mediator_status',
        'value' => function ($data) {
            $mediator = \common\models\MdMediator::findOne($data->id);
            if ($mediator->mediator_status == 0) {
                return 'Inactive | ' . Html::a('Activate', ['#'], ['onclick' => 'return confirm_action(' . $mediator->id . ',1)']);
            }
            if ($mediator->mediator_status == 1) {
                return 'Active | ' . Html::a('<span style="color: red;">Deactivate</span>', ['#'], ['onclick' => 'return confirm_action(' . $mediator->id . ',0)']);
            }
        },
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'show_address',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'show_manager',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'show_employee',
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
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
            'data-confirm' => false, 'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'],
    ],
];
