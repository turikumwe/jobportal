<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SSkill */
?>
<div class="sskill-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'skill',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'deleted_at',
            // 'deleted_by',
        ],
    ]) ?>

</div>
