<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\NewsNews */
?><br><br>
<div class="container news-news-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'headline:ntext',
            [
                'attribute' => 'link:ntext',
                'value' => function($data){
                    return \yii\helpers\HtmlPurifier::process($data->link);
                },
                'label' => 'Link',
            ],
            'source',
            'publication_date',
            // 'created_by',
            // 'created_on',
            // 'modified_by',
            // 'modified_on',
        ],
    ]) ?>

</div>
