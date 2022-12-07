<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>" class="pxp-root">

    <head>
        <meta charset="<?php echo Yii::$app->charset ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo Html::encode($this->title) ?></title>
        <!-- Google Tag Manager -->
        <script>
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s),
                        dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-KD8DCVP');
        </script>
        <!-- End Google Tag Manager -->
      
    </head>

    <body style="background-color: var(--pxpMainColorLight);">
        <?php $this->beginBody() ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KD8DCVP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php echo $content ?>
        <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>