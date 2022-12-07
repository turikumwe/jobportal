<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="pxp-header fixed-top pxp-is-sticky">
    <div class="pxp-container">
        <div class="pxp-header-container">
            <div class="pxp-logo">
                <a href="<?= Yii::getAlias('@frontendUrl') ?>" class="pxp-animate"><img src="<?= Yii::getAlias('@staticUrl') ?>/images/kora.png" width="82px" height='40px'></a>
            </div>
            <?php 
            include 'mainmenu.php'; 
            ?>
        </div>
    </div>
</div>
</header>
<?php
?>