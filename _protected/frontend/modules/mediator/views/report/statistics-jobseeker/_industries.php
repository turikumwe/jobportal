<?php
use yii\helpers\Url;
use kartik\grid\GridView; 
use \common\models\UserProfile;
$gfCountry = function ($model, $key, $index, $widget) {

    return [
        'mergeColumns' => [[0, 3]], 
        'content' => [              // content to show in each summary cell
            0 => Yii::t('app','Summary ( '.$model->nationality0->cc_description.')' ),
            5 => GridView::F_SUM,
        ],
        'contentFormats' => [      // content reformatting for each summary cell
            //1 => ['class' => 'text-left'],
            5 => ['format' => 'number', 'decimals' => 0],
        ],
        'contentOptions' => [      // content html attributes for each summary cell
            0 => ['style' => 'font-variant:small-caps'],
            5 => ['class' => 'text-right'],
        ],
        'options'=>['class'=>'success','style'=>'font-weight:bold;font-size:14px']
    ];
};

$gfGender = function ($model, $key, $index, $widget) {
    return [
        'mergeColumns' => [[2, 4]], 
        'content' => [              // content to show in each summary cell
            2 => ($model->gender == UserProfile::GENDER_MALE) ? 'Total(Male)' : 'Total(Female)',
            5 => GridView::F_SUM,
        ],
        'contentFormats' => [      // content reformatting for each summary cell
            5 => ['format' => 'number', 'decimals' => 0],
        ],
        'contentOptions' => [      // content html attributes for each summary cell
            2 => ['class' => 'text-left'],
            5 => ['class' => 'text-right'],
        ],
         'options'=>['class'=>'primary','style'=>'font-weight:bold;font-size:14px']
    ];
};

$gfEducationLevel = function ($model, $key, $index, $widget) {
    return [
        'mergeColumns' => [[3, 4]], 
        'content' => [              // content to show in each summary cell
            3 => Yii::t('app','Summary ( '.$model->jsEducation->educationLevel->level.')' ),
            5 => GridView::F_SUM,
        ],
        'contentFormats' => [      // content reformatting for each summary cell
            3 => ['class' => 'text-left'],
            5 => ['format' => 'number', 'decimals' => 0],
        ],
        'contentOptions' => [      // content html attributes for each summary cell
            5 => ['class' => 'text-right'],
        ],
         'options'=>['class'=>'primary','style'=>'font-weight:bold;font-size:14px']
    ];
};

$gfEducationField = function ($model, $key, $index, $widget) {
    return [
        'mergeColumns' => [[4, 4]], 
        'content' => [              // content to show in each summary cell
            4 => Yii::t('app','Summary ( '.$model->jsEducation->educationField->field.')' ),
            5 => GridView::F_SUM,
        ],
        'contentFormats' => [      // content reformatting for each summary cell
            5 => ['format' => 'number', 'decimals' => 0],
        ],
        'contentOptions' => [      // content html attributes for each summary cell
            4 => ['class' => 'text-left'],
            5 => ['class' => 'text-right'],
        ],
         'options'=>['class'=>'primary','style'=>'font-weight:bold;font-size:14px']
    ];
};


return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => false], 
    [
        'class'      => '\kartik\grid\DataColumn',
        'attribute'  => 'nationality',
        'value'      => 'nationality0.cc_description',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->asArray()->all(), 'id', 'cc_description'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Country', 'id' => 'grid--nationality'],
        'width' => '250px',
        'pageSummary' => 'Total',
        'group' => true,  // enable grouping,
        'groupedRow' => true,                    // move grouped column to a single grouped row
        'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
        'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
        'groupFooter'=> $gfCountry
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gender',
        'value'  => function ($model) {
            return ($model->gender == UserProfile::GENDER_MALE) ? 'Male' : 'Female' ;
        },
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                                '' => 'Select a Gender',
                                UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                                UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                            ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Gender', 'id' => 'grid--gender'],
        'group' => true,
        'groupFooter'=> $gfGender,    
        'subGroupOf'  => 1,
        'pageSummary' => 'Page Summary',
        'pageSummaryOptions' => ['class' => 'text-right'],
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'education_level_id',
        'label'=>'Education Level',
        //'width' => '300px',
        'value' => 'jsEducation.educationLevel.level',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->asArray()->all(), 'id', 'level'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Education level', 'id' => 'grid--education_level'],
        //'group' => true,
        // 'groupFooter'=> $gfEducationLevel,    
        // 'subGroupOf'  => 2,
    ],
 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'education_field_id',
        'label'=>'Education Field',
        //'width' => '300px',
        'value' => 'jsEducation.educationField.field',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->asArray()->all(), 'id', 'field'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Education Field', 'id' => 'grid--education_field'],
        //'group' => true,
        // 'groupFooter'=> $gfEducationField,    
        // 'subGroupOf'  => 2,
    ],
   
    [
        'class'       => '\kartik\grid\DataColumn',
        'attribute'   => 'Total',
        'value'       => 'stat',
        'hAlign'      => 'right',
        'pageSummary' => true
    ],

];
