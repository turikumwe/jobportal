<?php
$config = [
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'user' => [
            'class' => frontend\modules\user\Module::class,
            'shouldBeActivated' => true,
            'enableLoginByPass' => true,
        ],
        'jobseeker' => [
            'class' => frontend\modules\jobseeker\Settings::class,
        ],

        'employer' => [
            'class' => 'frontend\modules\employer\Module',
        ],

        'mediator' => [
            'class' => 'frontend\modules\mediator\module',
        ],
        'service' => [
            'class' => 'frontend\modules\service\Settings',
        ],
        'abroad' => [
            'class' => 'frontend\modules\abroad\Module',
        ],
        'news' => [
            'class' => 'frontend\modules\news\News',
        ],
        'hr' => [
            'class' => 'frontend\modules\hr\HR',
        ],
        // Allowed IPs, localhost by default. Set to false to allow all IPs.
        'ipFilters' => array('127.0.0.1', '::1'),
        // Valid PHP callback that returns if user should be allowed to use web shell.
        // In this example it's valid for PHP 5.3.
        'checkAccessCallback' => function ($controller, $action) {
            return !Yii::app()->user->isGuest;
        }
    ],
    'components' => [
        'authClientCollection' => [
            'class' => yii\authclient\Collection::class,
            'clients' => [
                'github' => [
                    'class' => yii\authclient\clients\GitHub::class,
                    'clientId' => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET')
                ],
                'facebook' => [
                    'class' => yii\authclient\clients\Facebook::class,
                    'clientId' => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret' => env('FACEBOOK_CLIENT_SECRET'),
                    'scope' => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => common\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                if (env('APP_MAINTENANCE') === '1') {
                    return true;
                }
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ],

        'jobPortalModal' => [
            'class' => common\components\popup\JobPortalModal::class,
        ],

        'link' => [
            'class' => frontend\components\url\Link::class,
        ],

        'jobSeeker' => [
            'class' => frontend\components\menu\JobSeeker::class,
        ],
        'label' => [
            'class' => common\components\help\Helpers::class,
        ],
        'sms' => [
            'class' => common\components\sms\Sms::class,
        ],
        'nid' => [
            'class' => common\components\nid\Nid::class,
        ],
        'reports' => [
            'class' => frontend\components\reports\OpportunityStatistics::class,
        ],
        'siteApi' => [
            'class' => 'mongosoft\soapclient\Client',
            'url' => 'http://10.10.74.217:81/nida_ws/Service1.svc?wsdl',
            'options' => [
                'cache_wsdl' => WSDL_CACHE_NONE,
            ],
        ],
        'myfield' => [
            'class' => frontend\components\myfield\Myfield::class,
        ],
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class' => yii\gii\generators\crud\Generator::class,
                'messageCategory' => 'frontend'
            ]
        ]
    ];
}

return $config;
