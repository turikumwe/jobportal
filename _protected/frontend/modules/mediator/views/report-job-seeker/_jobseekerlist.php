<?php
use yii\helpers\Url;
use kartik\grid\GridView; 

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'firstname',
        //'value' => 'fullName',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lastname',
        //'value' => 'fullName',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_number',
        // 'value' => 'gender',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gender',
        'value' => function($model){
            return ($model->gender == \common\models\UserProfile::GENDER_MALE) ? 'Male' : 'Female'; 
        },
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(
                [
                   ['id' => \common\models\UserProfile::GENDER_FEMALE ,
                    'name' => Yii::t('frontend', 'Female')],
                   ['id' => \common\models\UserProfile::GENDER_MALE , 
                    'name' => Yii::t('frontend', 'Male')]
                ], 'id' ,'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],

                'filterInputOptions' => ['placeholder' => 'Gender', 'id' => 'grid--gender_id']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'jobseeker_age',
        'value' => 'age',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'disability_id',
        'label'=>'Disability',
        'width' => '300px',
        'value' => 'disability.disability',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SDisability::find()->asArray()->all(), 'id', 'disability'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Disability', 'id' => 'grid--disability_id']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'numberEducation',
        'value' => 'countEducation',
        // 'filterType' => GridView::FILTER_SELECT2,
        //         'filter' => \yii\helpers\ArrayHelper::map(
        //         [
        //            ['id' => 1, 'name' => '>1'],
        //            ['id' => 2 , 'name' => '>2']
        //         ], 'id' ,'name'),

        //         'filterWidgetOptions' => [
        //             'pluginOptions' => ['allowClear' => true],
        //         ],

        //         'filterInputOptions' => ['placeholder' => 'Times', 'id' => 'grid--count_education']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'numberTraining',
        'value' => 'countTraining',
        // 'filterType' => GridView::FILTER_SELECT2,
        //         'filter' => \yii\helpers\ArrayHelper::map(
        //         [
        //            ['id' => 1, 'name' => '>1'],
        //            ['id' => 2 , 'name' => '>2']
        //         ], 'id' ,'name'),

        //         'filterWidgetOptions' => [
        //             'pluginOptions' => ['allowClear' => true],
        //         ],

        //         'filterInputOptions' => ['placeholder' => 'Times', 'id' => 'grid--count_education']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'numberOfPostOccupied',
        'value' => 'countJobPosition',
        // 'filterType' => GridView::FILTER_SELECT2,
        //         'filter' => \yii\helpers\ArrayHelper::map(
        //         [
        //            ['id' => 1, 'name' => '>1'],
        //            ['id' => 2 , 'name' => '>2']
        //         ], 'id' ,'name'),

        //         'filterWidgetOptions' => [
        //             'pluginOptions' => ['allowClear' => true],
        //         ],

        //         'filterInputOptions' => ['placeholder' => 'Times', 'id' => 'grid--count_education']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
        'value' => 'user.email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phone_number',
        'value' => 'user.phone',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'education_level_id',
        'label'=>'Education Level',
        'width' => '300px',
        'value' => 'createdBy.jsEducation.educationLevel.level',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->asArray()->all(), 'id', 'level'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Education level', 'id' => 'grid--education_level']
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'education_field_id',
        'label'=>'Education Field',
        'width' => '300px',
        'value' => 'createdBy.jsEducation.educationField.field',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->asArray()->all(), 'id', 'field'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Education Field', 'id' => 'grid--education_field']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'graduation_date',
        'width' => '300px',
        'value' => 'createdBy.jsEducation.graduation_date',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\JsEducation::find()->asArray()->distinct()->all(), 'graduation_date', 'graduation_date'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Graduation Year', 'id' => 'grid--graduation_date']
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'mediator_id',
        'label'=>'ESC',
        'width' => '300px',
        'value' => 'createdBy.jsAddress.district.mediator.madiator_name',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\MdMediator::find()->asArray()->all(), 'id', 'madiator_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Mediator', 'id' => 'grid--mediator']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'province_id',
        'label'=>'Province',
        'width' => '300px',
        'value' => 'createdBy.jsAddress.district.province.province',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SProvince::find()->asArray()->all(), 'id', 'province'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Province', 'id' => 'grid--province']
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'district_id',
        'label'=>'District',
        'width' => '300px',
        'value' => 'createdBy.jsAddress.district.district',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->asArray()->all(), 'id', 'district'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'District', 'id' => 'grid--district']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'country_id',
        'value' => 'jsAddress.country.cc_description',
        // 'label' => 'Country of residence',
        'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->asArray()->all(), 'id', 'cc_description'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Country', 'id' => 'grid--country']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_at',
        'label' => 'Registration',
        'value' => function($model){
            return date('Y-m-d',strtotime($model->created_at));
        }
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to(['/jobseeker/user-profile/index','idOtherProfile'=>$key,'employer' => true]);
        },
        'viewOptions'=>['title'=>'View','data-toggle'=>'tooltip'],
    ],

];   