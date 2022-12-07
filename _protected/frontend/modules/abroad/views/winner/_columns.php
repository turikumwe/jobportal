<?php
use yii\helpers\Url;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'label' => 'User ID'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'value' => function($data){
            if(isset($data->user->userProfile->document_type) && $data->user->userProfile->document_type==1)
                return $data->user->userProfile->id_number;
            else{
                if (isset($data->user->userProfile->passport_number) && $data->user->userProfile->document_type == 2)
                    return $data->user->userProfile->passport_number;
                else
                    return "-";
            }
        },
        'label' => 'ID/Passport'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'value' => function($data){
            if (isset($data->user->userProfile->firstname) && $data->user->userProfile->firstname != '')
                return $data->user->userProfile->firstname.' '.$data->user->userProfile->middlename.' '.$data->user->userProfile->lastname;
            else
                return "-";
        },
        'label' => 'Names',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'value' => function($data){
            return $data->user->phone;
        },
        'label' => 'Phone',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'value' => function($data){
            return $data->user->email;
        },
        'label' => 'Email',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'created_by',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_on',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'modified_by',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'modified_on',
    // ],
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
    //     'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
    //     'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
    //                       'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
    //                       'data-request-method'=>'post',
    //                       'data-toggle'=>'tooltip',
    //                       'data-confirm-title'=>'Are you sure?',
    //                       'data-confirm-message'=>'Are you sure want to delete this item'], 
    // ],

];   