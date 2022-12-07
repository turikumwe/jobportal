<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsMessage */
?>
<div class="js-message-view" style="color: black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'subject',
            'body:ntext',
            [
                'attribute' => 'From',
                'value' => isset($model->user_from->userProfile->fullName) ? $model->user_from->userProfile->fullName : '-',

            ],
            [   
                'attribute' => 'To',
                'value' => isset($model->user_to->userProfile->fullName) ? $model->user_to->userProfile->fullName : '-',

            ],
            'created_at'
        ],
    ]) ?>

</div>
