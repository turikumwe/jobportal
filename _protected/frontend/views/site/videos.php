<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
// $this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" style="text-align: center"><br>
    <div class="row">
        <div class="col col-xl-12 col-md-12 col-sm-12 col-xs-12">
            <?php
                //$path="../storage/careerguidance/".$_GET['dir']."/".$_GET['name'].".mp4";
            ?>
            <iframe 
                width="660" 
                height="415" 
                src="https://www.youtube.com/embed/<?= $_GET['id'] ?>" 
                frameborder="0" 
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
            <h3><?= $_GET['title']; ?></h3>
        </div>
    </div>
</div>