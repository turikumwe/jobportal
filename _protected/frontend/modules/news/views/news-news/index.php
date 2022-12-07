<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\news\models\NewsNewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'News News');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>
<?php
/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = \frontend\assets\FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<style>
    .howapply-wrp .howapply__cont .howapply__xpla li {
        list-style-type: initial;
        margin-left: 15px;
    }
</style>
<?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
<br />
<br />
<br />
<section class="mt-4" style="background-color: var(--pxpSecondaryColorLight);">
    <div class="pxp-container">
        <div class="col-lg-7 col-xl-8 col-xxl-9">

            <?php
            $news_data = $dataProvider->getModels();
            if (count($news_data) > 0) {
                foreach ($news_data as $news) {
                    ?>
                    <div class="pxp-posts-card-2-container">
                        <div class="pxp-posts-card-2 pxp-has-border">
                            <div class="pxp-posts-card-2-fig">
                                <div class="pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/images/news.jpg);"></div>
                            </div>
                            <div class="pxp-posts-card-2-content">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <a href="blog-list-1.html" class="pxp-posts-card-2-category"><?= $news->source; ?></a>
                                    </div>
                                    <div class="col-auto">
                                        <div class="pxp-posts-card-2-date"><strong><?= date_format(date_create($news->publication_date), "M d, Y"); ?><strong></div>
                                    </div>
                                </div>
                                <div class="pxp-posts-card-2-title mt-4">
                                    <a href="<?= $news->link; ?>" target="_blank"><?= $news->headline; ?></a>
                                </div>
                                <div class="pxp-posts-card-2-cta">
                                    <a href="<?= $news->link; ?>" target="_blank">Read more..<span class="fa fa-angle-right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="col-md-12 text-center">
                <nav class="mt-3 mt-sm-0" aria-label="Jobs list pagination">
                    <?php
                    echo \yii\widgets\CustomLinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                    ]);
                    ?>
                </nav>
            </div>
        </div>
        
    </div>
</section>