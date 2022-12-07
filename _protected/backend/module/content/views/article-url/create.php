<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ArticleUrl */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Article Url',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Article Urls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-url-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
