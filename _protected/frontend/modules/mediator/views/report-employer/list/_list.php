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
    'opening_date',
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'ownership_id',
        'label'     => 'Ownership',
        'width'     => '300px',
        'value'     => 'ownership.ownership',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\SOwnership::find()->asArray()->all(), 'id', 'ownership'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Ownership', 'id' => 'grid--ownership']
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
        'attribute'=>'created_at', 
        'width'=>'250px',
        'value'=>function ($model, $key, $index, $widget) { 
            return $model->registrationdate;
        },
    ],
    
];   