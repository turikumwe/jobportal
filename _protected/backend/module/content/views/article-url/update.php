<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleUrl */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Article Url',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Article Urls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="article-url-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
