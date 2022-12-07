<?php

return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'command-bus' => [
            'class' => trntv\bus\console\BackgroundBusController::class,
        ],
        'message' => [
            'class' => console\controllers\ExtendedMessageController::class
        ],
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@common/migrations/db',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'rbac-migrate' => [
            'class' => console\controllers\RbacMigrateController::class,
            'migrationPath' => '@common/migrations/rbac/',
            'migrationTable' => '{{%system_rbac_migration}}',
            'templateFile' => '@common/rbac/views/migration.php'
        ],
        'jobseeker-migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@frontend/modules/jobseeker/migrations',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'news-migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@frontend/modules/news/migrations',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'service-migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@frontend/modules/service/migrations',
            'migrationTable' => '{{%system_db_migration}}'
        ],
    ],
];
