<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
use yii\grid\GridView;
use yii\web\JsExpression;
use common\grid\EnumColumn;
use trntv\yii\datetime\DateTimeWidget;

return [
        [
            'class' => 'kartik\grid\SerialColumn',
            'width' => '30px',
        ],
        'username',
        'email:email',
        [
            'class' => EnumColumn::class,
            'attribute' => 'status',
            'enum' => User::statuses(),
            'filter' => User::statuses()
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'filter' => DateTimeWidget::widget([
                'model' => $searchModel,
                'attribute' => 'created_at',
                'phpDatetimeFormat' => 'dd.MM.yyyy',
                'momentDatetimeFormat' => 'DD.MM.YYYY',
                'clientEvents' => [
                    'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                ],
            ])
        ],
        [
            'attribute' => 'logged_at',
            'format' => 'datetime',
            'filter' => DateTimeWidget::widget([
                'model' => $searchModel,
                'attribute' => 'logged_at',
                'phpDatetimeFormat' => 'dd.MM.yyyy',
                'momentDatetimeFormat' => 'DD.MM.YYYY',
                'clientEvents' => [
                    'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                ],
            ])
        ],
        // 'updated_at',
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{login} {view} {update} {delete}',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
                'login' => function ($url) {
                    return Html::a(
                            '<i class="fa fa-sign-in" aria-hidden="true"></i>',
                            $url,
                            [
                                'title' => Yii::t('backend', 'Login')
                            ]
                    );
                },
            ],
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
        'visibleButtons' => [
                'login' => Yii::$app->user->can('administrator')
        ]
    ],

];   