<?php
/**
 * Require core files
 */
require_once(__DIR__ . '/../helpers.php');

/**
 * Setting path aliases
 */
Yii::setAlias('@root', realpath(dirname(dirname(dirname(__DIR__)))));
Yii::setAlias('@base', realpath(__DIR__ . '/../../'));
Yii::setAlias('@common', realpath(__DIR__ . '/../../common'));
Yii::setAlias('@api', realpath(__DIR__ . '/../../api'));
Yii::setAlias('@frontend', realpath(__DIR__ . '/../../frontend'));
Yii::setAlias('@backend', realpath(__DIR__ . '/../../backend'));
Yii::setAlias('@console', realpath(__DIR__ . '/../../console'));
Yii::setAlias('@storage', realpath(dirname(dirname(dirname(__DIR__))) . '/storage'));
Yii::setAlias('@tests', realpath(__DIR__ . '/../../tests'));
Yii::setAlias('@pdfcss', realpath(__DIR__ . '/../../vendor'));
Yii::setAlias('@staticPath', realpath(__DIR__ . '/../../static'));

/**
 * Setting url aliases
 */
Yii::setAlias('@apiUrl', env('API_HOST_INFO') . env('API_BASE_URL'));
Yii::setAlias('@frontendUrl', env('FRONTEND_HOST_INFO') . env('FRONTEND_BASE_URL'));
Yii::setAlias('@FullfrontendUrl', env('FULL_FRONT_END_URL'));
Yii::setAlias('@backendUrl', env('BACKEND_HOST_INFO') . env('BACKEND_BASE_URL'));
Yii::setAlias('@storageUrl', env('STORAGE_HOST_INFO') . env('STORAGE_BASE_URL'));
Yii::setAlias('@staticUrl', env('STORAGE_HOST_INFO') . env('STATIC_URL'));



