<?php

use yii\helpers\Html;

$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
$this->registerJsFile('https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <?= $this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@storageUrl') . "/source/1/kora.png"]); ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@staticUrl') ?>/images/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/animate.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/style.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@staticUrl') ?>/css/select2.min.css">

    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/jquery-3.4.1.min.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/owl.carousel.min.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/nav.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/main.js"></script>
    <script src="<?= Yii::getAlias('@staticUrl') ?>/js/select2.min.js" defer></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                closeOnSelect: false
            });
        });
    </script>
</head>