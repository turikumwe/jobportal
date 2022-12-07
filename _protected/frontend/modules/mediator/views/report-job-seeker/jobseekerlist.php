<!doctype html>
<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use \yii\widgets\CustomLinkPager;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'User Profiles');
$this->params['breadcrumbs'][] = $this->title;

$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});";
$this->registerJs($search);

CrudAsset::register($this);
?>

<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    if (Yii::$app->user->can('mediator')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else {
        include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php");
    }
    ?>
</div>
<div class="pxp-dashboard-content">
    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_top_header.php") ?>

    <div class="pxp-dashboard-content-details">
        <div class="mt-4">



            <div class="table-responsive table-hover">
                <?php \yii\widgets\Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
                <?=
                GridView::widget([
                    'id' => 'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax' => false,
                    'showPageSummary' => false,
                    'striped' => false,
                    'hover' => true,
                    'panel' => ['type' => 'primary', 'heading' => 'Jobseeker list'],
                    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                    'columns' => require(__DIR__ . '/_jobseekerlist.php'),
                    'toolbar' => [
                        [
                            'content' =>
                            '{toggleData}' .
                            '{export}'
                        ],
                    ],
                    'pager' => [
                        'class' => 'yii\widgets\CustomLinkPager',
                    //other pager config if nesessary
                    ],
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'panel' => [
                        'type' => '',
                        'heading' => '<font color="#000000">Jobseekers Report <a href="' . Yii::getAlias('@frontendUrl') . '/mediator/report-job-seeker/export-data' . '"><i class="fa fa-file-excel-o"> Export</i>',
                        'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                        '<div class="clearfix"></div>',
                    ]
                ])
                ?>







            </div>
        </div>
    </div>
</div>