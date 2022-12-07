<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
// $this->title = "How to Apply";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->params['bgimage'] = $model->category->body;

$this->title = $model->category->title;

use common\models\Article;
use yii\helpers\Html;
?>
<style>
    .howapply-wrp .howapply__cont .howapply__xpla li {
        list-style-type: initial;
        margin-left: 15px;
    }
</style>
<section class="pxp-hero vh-50" style="background-color: var(--pxpMainColorLight); height:450px">
    <div class="pxp-hero-caption">
        <div class="pxp-container">
            <div class="row pxp-pl-80 align-items-center justify-content-between">
                <div class="col-12 col-xl-6 col-xxl-5">
                    <h1>How To Apply<br><span style="color: var(--pxpMainColor);"></h1>
                    <div class="pxp-hero-subtitle mt-3 mt-lg-4">Welcome to the How To Apply page,
                        how can I help you? </div>

                </div>
                <div class="d-none d-xl-block col-xl-5 position-relative">
                    <div  class="pxp-hero-cards-container pxp-animate-cards pxp-mouse-move" data-speed="160">
                        <div  class="pxp-hero-card-page pxp-cover pxp-cover-top" style="background-image: url(<?= Yii::getAlias('@staticUrl') ?>/images/howtoapply.png); min-height: 320px; background-color: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="mt-100">
    <div class="pxp-container">
        <h2 class="pxp-section-h2 text-center">How To Apply</h2>

        <div class="row mt-4 justify-content-center">
            <div class="col-xxl-12">
                <div class="accordion pxp-faqs-accordion" id="pxpFAQsAccordion">
                    <?php
                    foreach ($category as $category) {
                        $article = Article::find()->published()->andWhere(['category_id' => $category->id])->all();
                        foreach ($article as $article) {
                            ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="pxpFAQsHeader<?= $article->id;?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pxpCollapseFAQs<?= $article->id;?>" aria-expanded="false" aria-controls="pxpCollapseFAQs<?= $article->id;?>">
                                        <?= $article->title; ?>
                                    </button>
                                </h2>
                                <div id="pxpCollapseFAQs<?= $article->id;?>" class="accordion-collapse collapse" aria-labelledby="pxpFAQsHeader<?= $article->id;?>" data-bs-parent="#pxpFAQsAccordion">
                                    <div class="accordion-body">
                                        <?= $article->body; ?>
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
