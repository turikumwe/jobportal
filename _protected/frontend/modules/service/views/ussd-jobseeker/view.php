<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UssdJobseeker */
?>
<div class="ussd-jobseeker-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nid',
            'names',
            'dob',
            'domain',
            'district',
            'education_level',
            'telephone',
        ],
    ]) ?>

</div>
