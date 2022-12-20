<?php

use yii\helpers\Url;
use kartik\grid\GridView;

return [
    [
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => function ($model) {
            return ["value" => $model->user_id, "class" => ''];
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Names',
        'value' => 'fullName',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'gender',
        'value' => function ($model) {
            return ($model->gender == \common\models\UserProfile::GENDER_MALE) ? 'Male' : 'Female';
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => \yii\helpers\ArrayHelper::map(
                [
                    ['id' => \common\models\UserProfile::GENDER_FEMALE,
                        'name' => Yii::t('frontend', 'Female')],
                    ['id' => \common\models\UserProfile::GENDER_MALE,
                        'name' => Yii::t('frontend', 'Male')]
                ], 'id', 'name'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Gender', 'id' => 'grid--gender_id']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'disability_id',
        'label' => 'Disability',
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'email',
        'value' => 'user.email',
        'filterType' => GridView::FILTER_SELECT2,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'phone_number',
        'value' => 'user.phone',
        'filterType' => GridView::FILTER_SELECT2,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'education_level_id',
        'label' => 'Education Level',
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'education_field_id',
        'label' => 'Education Field',
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'graduation_date',
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_at',
        'label' => 'Registration',
        'filterType' => GridView::FILTER_SELECT2,
        'value' => function ($model) {
            return date('Y-m-d', strtotime($model->created_at));
        }
    ]
];
