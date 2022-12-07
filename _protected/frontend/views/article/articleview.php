<?php
/* @var $this View */
/* @var $model Article */
// $this->title = "How to Apply";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->params['bgimage'] = $model->category->body;

$this->title = $model->category->title;

use common\models\Article;
use common\models\ArticleUrl;
use yii\web\View;
?>
<style>
    .howapply-wrp .howapply__cont .howapply__xpla li {
        list-style-type: initial;
        margin-left: 15px;
    }
</style>
<?php include(Yii::getAlias('@frontend').DIRECTORY_SEPARATOR .'views'.DIRECTORY_SEPARATOR .'layouts'.DIRECTORY_SEPARATOR .'header.php') ?>
<section class="pxp-hero vh-50" style="background-color: var(--pxpMainColorLight); height:450px">
    <div class="pxp-hero-caption">
        <div class="pxp-container">
            <div class="row pxp-pl-80 align-items-center justify-content-between">
                <div class="col-12 col-xl-6 col-xxl-5">
                    <h1><?= $model->category->title; ?><br><span style="color: var(--pxpMainColor);"></h1>
                    <div class="pxp-hero-subtitle mt-3 mt-lg-4">Welcome to <?= $model->category->title; ?> page, <br /> how can I help you? 
                       
                    </div>

                </div>
                <div class="d-none d-xl-block col-xl-5 position-relative">
                    <div  class="pxp-hero-cards-container pxp-animate-cards pxp-mouse-move" data-speed="160">
                        <div  class="pxp-hero-card-page pxp-cover pxp-cover-top" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/images/article/<?= $this->params['bgimage']; ?>); min-height: 320px; background-color: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="mt-100">
    <div class="pxp-container">
        <h2 class="pxp-section-h2 text-center"><?= $model->category->title; ?></h2>

        <div class="row mt-4 justify-content-center">
            <div class="col-xxl-12">
                <div class="accordion pxp-faqs-accordion" id="pxpFAQsAccordion">
                    <?php
                    foreach ($category as $category) {
                        $article = Article::find()->published()->andWhere(['category_id' => $category->id])->all();
                        foreach ($article as $article) {
                            ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="pxpFAQsHeader<?= $article->id; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs<?= $article->id; ?>" aria-expanded="false" aria-controls="pxpCollapseFAQs<?= $article->id; ?>">
                                        <?= $article->title; ?>
                                    </button>
                                </h2>
                                <div class='row'>
                                    <div id="pxpCollapseFAQs<?= $article->id; ?>" class="accordion-collapse collapse col-xxl-9" aria-labelledby="pxpFAQsHeader<?= $article->id; ?>" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="accordion-body">
                                            <?= $article->body; ?>
                                        </div>
                                    </div>
                                    <div id="pxpCollapseFAQs<?= $article->id; ?>" class="accordion-collapse collapse col-xxl-3" aria-labelledby="pxpFAQsHeader<?= $article->id; ?>" data-bs-parent="#pxpFAQsAccordion">
                                        <div class="pxp-posts-card-2-fig-small">
                                            <?php
                                            $article = Article::find()->published()->andWhere(['slug' => $article->slug])->one();
                                            $urls = ArticleUrl::find()->andWhere(['article_id' => $article->id])->all();
                                            if (COUNT($urls) >= 1) {
                                                ?>
                                                <div class="howto_dtailcont-lnk">
                                                    <h4>Additional resource</h4>
                                                    <?php foreach ($urls as $url) { ?>
                                                        <div class="pxp-cover" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/images/pdf.png);"></div>
                                                        <a href="<?= $url->url; ?>" target="_blank"><?= $url->name; ?></a>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>