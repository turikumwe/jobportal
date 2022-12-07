<?php
use yii\helpers\Url;
use kartik\grid\GridView;

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'company_name',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'district_id',
        'label'     => 'District',
        'width'     => '300px',
        'value'     => 'emplAddress.districtRelation.district',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->asArray()->all(), 'id', 'district'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'District', 'id' => 'grid--district']
    ],

    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute' => 'empl_economic_sector',
    //     'label'     => 'Economic sector',
    //     'width'     => '300px',
    //     'value'     => 'economicSector.mainEconomicSector.sector',
    //     'filterType' => GridView::FILTER_SELECT2,
    //             'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SMainecosector::find()->asArray()->all(), 'id', 'sector'),
    //             'filterWidgetOptions' => [
    //                 'pluginOptions' => ['allowClear' => true],
    //             ],
    //             'filterInputOptions' => ['placeholder' => 'Economic sector', 'id' => 'grid--economic-sector']
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'empl_economic_sector',
        'label'     => 'Economic sector',
        'width'     => '300px',
        'value'     => 'economicSector.economicSector.ecosector',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SIsicr4Level4::find()->asArray()->all(), 'id', 'ecosector'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Economic sector', 'id' => 'grid--economic-sector']
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'empl_email',
        'label'     => 'Email',
        'value'     => 'emplAddress.email_address',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'empl_phone_number',
        'label'     => 'Phone',
        'value'     => 'emplAddress.phone_number',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to(['index','idOtherProfile'=>$key,'visitor' => true]);
        },
        'viewOptions'=>['title'=>'View','data-toggle'=>'tooltip'],
    ],
];   