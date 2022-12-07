<?php

use yii\helpers\Url;
use kartik\grid\GridView;
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
        'attribute' => 'mediator_id',
        'label' => 'Mediator',
        'value' => 'mediator.madiator_name',
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => \yii\helpers\ArrayHelper::map(\common\models\MdMediator::find()->asArray()->all(), 'id', 'madiator_name'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Md mediator', 'id' => 'grid--mediator_id']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'person_id',
        'label' => 'Employee',
        'value' => function ($data) {
            return $data->person->first_name . ' ' . $data->person->middle_name . ' ' . $data->person->last_name;
        },
    // 'filterType' => GridView::FILTER_SELECT2,
    //         'filter' => \yii\helpers\ArrayHelper::map(\common\models\CommonPerson::find()->asArray()->all(), 'id', 'first_name'),
    //         'filterWidgetOptions' => [
    //             'pluginOptions' => ['allowClear' => true],
    //         ],
    //         'filterInputOptions' => ['placeholder' => 'Manager', 'id' => 'grid--person_id']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'position_id',
        'label' => 'Position',
        'value' => 'position.position',
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => \yii\helpers\ArrayHelper::map(\common\models\SMediatorPosition::find()->asArray()->all(), 'id', 'position'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Position', 'id' => 'grid--position_id']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'person_id',
        'label' => 'Phone',
        'value' => 'person.phone',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'person_id',
        'label' => 'Email',
        'value' => 'person.email',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'start_date',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'end_date',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'format' => 'raw',
        'label' => 'Status',
        'value' => function ($data) {
            $user = \common\models\User::findOne($data->created_by);
            if ($user->status == 1) {
                return 'Inactive | ' . Html::a('Activate', ['#'], ['onclick' => 'return confirm_action(' . $data->created_by . ',2)']);
            }
            if ($user->status == 2) {
                return 'Active | ' . Html::a('<span style="color: red;">Deactivate</span>', ['#'], ['onclick' => 'return confirm_action(' . $data->created_by . ',1)']);
            }
        },
    ],
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
?>