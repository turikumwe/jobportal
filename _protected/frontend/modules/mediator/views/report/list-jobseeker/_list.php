<?php
use yii\helpers\Url;
use kartik\grid\GridView; 
use \common\models\UserProfile;
$gfCountry = function ($model, $key, $index, $widget) {

    return [
        'mergeColumns' => [[1, 2]], 
        'content' => [              // content to show in each summary cell
            1 => Yii::t('app','Total By ( '.$model->nationality0->cc_description.')' ),
            4 => count($key),
        ],
        'contentFormats' => [      // content reformatting for each summary cell
           // 4 => ['format' => 'number', 'decimals' => 2],
        ],
        'contentOptions' => [      // content html attributes for each summary cell
            4 => ['class' => 'text-right'],
        ],
        'options' => ['class' => 'active table-active h6']
    ];
};

$gfGender = function ($model, $key, $index, $widget) {
    return [
        'mergeColumns' => [[1, 2]], 
        'content' => [              // content to show in each summary cell
            1 =>Yii::t('app','Total By '.($model->gender == UserProfile::GENDER_MALE)?'Malewww':"Female" ),
            2 => count($key),
        ],
        'contentFormats' => [      // content reformatting for each summary cell
            2 => ['format' => 'number', 'decimals' => 0],
        ],
        'contentOptions' => [      // content html attributes for each summary cell
            2 => ['class' => 'text-right'],
        ],
        'options' => ['class' => 'active table-active h6']
    ];
};

return [
    ['class' => 'kartik\grid\SerialColumn', 'hidden' => true], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nationality',
        'value' => 'nationality0.cc_description',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->asArray()->all(), 'id', 'cc_description'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Country', 'id' => 'grid--nationality'],
        'width' => '250px',
        'pageSummary' => 'Country Summary',
        'group' => true,
        //'groupFooter'=> $gfCountry
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gender',
        'value'  => function ($model) {
            return ($model->gender == UserProfile::GENDER_MALE) ? 'Male' : "Female" ;
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
        //'groupFooter'=> $gfGender,    
        'subGroupOf' => 1,
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'marital_status',
        'value' => 'maritalStatus.status' ,
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SMaritalStatus::find()->asArray()->all(), 'id', 'status'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Marital Status', 'id' => 'grid--marital_status'], 
        'group' => true ,
        'subGroupOf' => 2,
          
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fullName',
        'pageSummary' => true
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_at',
        'label' => 'Registration Date',
    ],
   
   
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_number',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'passport_number',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'dob',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nationality',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'marital_status',
    // ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'disability_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'phone_number',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'terminate',
    // ],

];
