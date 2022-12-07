<?php 
use yii\helpers\Html;

$this->beginContent('@frontend/views/layouts/base.php'); ?>
    <div id="main">
        <section>
            <div class="kora-container">
                <div class="sec__header">
                    <div class="sec__header__title">
                        <h2><?= Yii::t("frontend", $this->title); ?></h2>
                        <p tabindex="0">
                            <?= Yii::t("frontend", "Welcome to the "); ?> <?= Yii::t("frontend", $this->title); ?> <?= Yii::t("frontend", "page, <br>how can I help you?"); ?>
                        </p>

                    </div>
                    <div class="sec__header__slider">
                        <div class="slider__wrp">
                            <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/" . $this->params['bgimage'], ['alt' => 'hands holding a paper and a pen']); ?>
                        </div>
                    </div>
                </div><br>
            </div>
        </section>

        <section class="howapply__s">
            <div class="kora-container howapply-wrp">
                <div class="howapply__cont" tabindex="0">
                    <?php echo $content ?>
                </div>
            </div>
        </section>
    </div>
<?php $this->endContent() ?>