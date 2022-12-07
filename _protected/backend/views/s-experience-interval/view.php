<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SExperienceInterval */
?>
<div class="sexperience-interval-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'experience_interval',
        ],
    ]) ?>

</div>
