<?php
$config = [
    'components' => [
        'assetManager' => [
            'class' => yii\web\AssetManager::class,
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV
        ],
        'label' => [
            'class' => common\components\help\Helpers::class,
        ],
        'geoip' => ['class' => 'lysenkobv\GeoIP\GeoIP'],
        'eRecruitment' => [
            'class' => 'mongosoft\soapclient\Client',
            'url' => 'http://172.27.8.23:8081/IPPISRDBKoraService.svc?wsdl',
            'options' => [
                'trace' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
            ],
        ],
    ],
    'modules' => [
        'gridview' => [
          'class' => '\kartik\grid\Module',
        ],

        'datecontrol' => [
          'class' => '\kartik\datecontrol\Module',
           'displaySettings' => [
            \kartik\datecontrol\Module::FORMAT_DATE => 'yyyy-MM-dd',
            \kartik\datecontrol\Module::FORMAT_TIME => 'HH:mm:ss a',
            \kartik\datecontrol\Module::FORMAT_DATETIME => 'yyyy-MM-dd HH:mm:ss a', 
        ],
    
        // format settings for saving each date attribute (PHP format example)
        'saveSettings' => [
            \kartik\datecontrol\Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
            \kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
            \kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
        ],
        ],

        'treemanager' =>  [
          'class' => '\kartik\tree\Module',
        ],
        // Allowed IPs, localhost by default. Set to false to allow all IPs.
        'ipFilters' => array('127.0.0.1', '::1'),
        // Valid PHP callback that returns if user should be allowed to use web shell.
        // In this example it's valid for PHP 5.3.
        'checkAccessCallback' => function ($controller, $action) {
            return !Yii::app()->user->isGuest;
        }  
    ],
    'as locale' => [
        'class' => common\behaviors\LocaleBehavior::class,
        'enablePreferredLanguage' => true
    ]
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1', '172.17.42.1', '172.17.0.1', '192.168.99.1'],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1', '172.17.42.1', '172.17.0.1', '192.168.99.1'],
    ];
}


return $config;
