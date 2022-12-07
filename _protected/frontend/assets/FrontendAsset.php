<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use common\assets\Html5shiv;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Frontend application asset
 */
class FrontendAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = 'bundle';

    /**
     * @var array
     */
    public $css = [
        'style_copy.css',
        'profile.css',
        'frontend.css',
        //'https://kit-free.fontawesome.com/releases/latest/css/free.min.css',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',
        //'style.css',
        // 'css/main.css',
        // 'css/bootstrap.min.css',
        // 'css/global.css',
        // 'css/nav-menu.css',
        // 'css/responsive.css'
    ];

    /**
     * @var array
     */
    public $js = [
        //'app.js',
        //'js/main.js',
        //'https://kit.fontawesome.com/a076d05399.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js',
        // 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js',
        // 'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        //YiiAsset::class,
        //BootstrapAsset::class,
        //Html5shiv::class,
        'common\assets\AdminLte',
        // 'common\assets\Html5shiv'
    ];
}
