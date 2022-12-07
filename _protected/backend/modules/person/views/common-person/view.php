<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CommonPerson */
?>
<div class="common-person-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'document_id',
            'id_number',
            'passport_number',
            'country_id',
            'first_name',
            'middle_name',
            'last_name',
            'date_of_birth',
            'gender_id',
            'geo_sector_id',
            'phone',
            'email:email',
            'created_by',
            'created_at',
            'deleted_by',
            'deleted_at',
            'updated_by',
            'updated_at',
        ],
    ]) ?>

</div>
