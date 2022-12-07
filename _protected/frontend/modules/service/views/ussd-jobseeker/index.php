<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\service\models\search\UssdJobseekerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Abanyabiraka');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div clss="container" style="width: 90%; margin: auto;"><br><br>
    <div class="tabs widget">
        <ul class="nav nav-tabs widget" style="color: #fff;">
            <li>&nbsp;</li>
            <li style="border-right: 0px"><?= Yii::t("frontend", "Abanyabiraka") ?></li>
        </ul>
    </div><br>
    <div class="row">
        <div class="col col-md-4">
            <div class="well jobtype text-center" style="color: #053EFF;">
                <div class="row">
                    <div class="col col-md-12">
                        <i class='fas fa-hard-hat i-size i-padding'></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-12">
                        <?= Yii::t("frontend", "Ubwubatsi") . " (10)"; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-md-4">
            <div class="well jobtype text-center" style="color: #053EFF;">
                <i class='fa fa-car i-size i-padding'></i><br>
                <?= Yii::t("frontend", "Ubukanishi") . " (10)"; ?>
            </div>
        </div>
        <div class="col col-md-4">
            <div class="well jobtype text-center" style="color: #053EFF;">
                <i class='fa fa-wrench i-size i-padding'></i><br>
                <?= Yii::t("frontend", "Amazi") . " (10)"; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-4">
            <div class="well jobtype text-center" style="color: #053EFF;">
                <i class='fa fa-bolt i-size i-padding'></i><br>
                <?= Yii::t("frontend", "Amashanyarazi") . " (10)"; ?>
            </div>
        </div>
        <div class="col col-md-4">
            <div class="well jobtype text-center" style="color: #053EFF;">
                <i class='fa fa-cocktail i-size i-padding'></i><br>
                <?= Yii::t("frontend", "Ubutetsi") . " (10)"; ?>
            </div>
        </div>
        <div class="col col-md-4">
            <div class="well jobtype text-center" style="color: #053EFF;">
                <i class='fa fa-home i-size i-padding'></i><br>
                <?= Yii::t("frontend", "Gukora murugo") . " (10)"; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-4">
            <div class="well jobtype text-center" style="color: #053EFF;">
                <i class='fa fa-dollar i-size i-padding'></i><br>
                <?= Yii::t("frontend", "Indi myuga") . " (10)"; ?>
            </div>
        </div>
    </div>