<?php

use yii\widgets\DetailView;
use common\grid\EnumColumn;
use common\models\User;
/* @var $this yii\web\View */
/* @var $model common\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           'username',
           'email:email',
           [
            'attribute' => 'status',
            'value' => function ($model) {
                return User::status($model->status);
            }
           ],
        ],
    ]) ?>

</div>
