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
        'attribute'=>'phone_number',
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
                return Url::to(['index','idOtherProfile'=>$key,'employer' => false]);
        },
        'viewOptions'=>['title'=>'View','data-toggle'=>'tooltip'],
    ],

];   