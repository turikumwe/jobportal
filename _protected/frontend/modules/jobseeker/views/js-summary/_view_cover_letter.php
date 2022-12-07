<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsSummary */
?>
<div class="js-summary-view"  style="color:black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cover_letter:ntext',
        ],
    ]) ?>

</div>
