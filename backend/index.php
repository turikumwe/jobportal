<?php
// Composer
require(__DIR__ . '/../_protected/vendor/autoload.php');

// Environment
require(__DIR__ . '/../_protected/common/env.php');

// Yii
require(__DIR__ . '/../_protected/vendor/yiisoft/yii2/Yii.php');

// Bootstrap application
require(__DIR__ . '/../_protected/common/config/bootstrap.php');
require(__DIR__ . '/../_protected/backend/config/bootstrap.php');

$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../_protected/common/config/base.php'),
    require(__DIR__ . '/../_protected/common/config/web.php'),
    require(__DIR__ . '/../_protected/backend/config/base.php'),
    require(__DIR__ . '/../_protected/backend/config/web.php')
);

(new yii\web\Application($config))->run();
