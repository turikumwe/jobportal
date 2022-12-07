<?php
use yii\helpers\Url;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use common\models\UserProfile;

$gfLocation = function ($model, $key, $index, $widget) {
    $district = isset($model->emplAddress->districtRelation->district) ? $model->emplAddress->districtRelation->district : '';
    return [
        'mergeColumns' => [[0, 2]], 
        'content' => [              // content to show in each summary cell
            0 => Yii::t('app','Summary ( '.$district.')' ),
            4 => GridView::F_SUM,
        ],
        'contentFormats' => [      // content reformatting for each summary cell
            4 => ['format' => 'number', 'decimals' => 0],
        ],
        'contentOptions' => [      // content html attributes for each summary cell
            0 => ['style' => 'font-variant:small-caps'],
            4 => ['class' => 'text-right'],
        ],
        'options'=>['class'=>'success','style'=>'font-weight:bold;font-size:14px']
    ];
};

return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => false], 

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'district_id',
        'label'     => 'District',
        'value'     => 'emplAddress.districtRelation.district',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->asArray()->all(), 'id', 'district'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'District', 'id' => 'grid--district'],
        'group' => true,  // enable grouping,
        'groupedRow' => true,                    // move grouped column to a single grouped row
        //'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
        //'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
        'groupFooter'=> $gfLocation
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'empl_economic_sector',
        'label'     => 'Main Economic sector',
        'width'     => '300px',
        'value'     => 'economicSector.mainEconomicSector.sector',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SMainecosector::find()->asArray()->all(), 'id', 'sector'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Economic sector', 'id' => 'grid--main--economic-sector'],
        'pageSummary' => 'Page Summary',
        'pageSummaryOptions' => ['class' => 'text-right'],
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'empl_economic_sector',
        'label'     => 'Economic sector',
        'width'     => '300px',
        'value'     => 'createdBy.economicSector.economicSector.ecosector',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SIsicr4Level4::find()->asArray()->all(), 'id', 'ecosector'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Economic sector', 'id' => 'grid--economic-sector'],

    ],

    [
        'class'       => '\kartik\grid\DataColumn',
        'attribute'   => 'Total',
        'value'       => 'stat',
        'hAlign'      => 'right',
        'pageSummary' => true,

    ],

];   
