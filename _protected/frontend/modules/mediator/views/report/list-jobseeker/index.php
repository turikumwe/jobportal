<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\jobseeker\models\search\JsCaseManagement */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Report');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(10); 
    return false; 
});";

$this->registerJs($search);
CrudAsset::register($this);

?>
<style>
    .tabs .nav-tabs {
        background-color: #3c8dbc;
        border-bottom: none;
    }

    .panel-bd-top {
        border-top: 3px solid #3c8dbc;
    }
</style>
</style>
<div class="well search-form" style="display:none">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
</div>
<div class="kora-container vd_content-section clearfix">
    <div class='row'>
        <div class="col-sm-3">
            <div class="panel widget light-widget panel-bd-top">
                <div class="panel-heading no-title">
                    <h3>
                        <center>JobSeekers By</center>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td><i class="glyphicon glyphicon-chevron-right"></i>
                                <a href='<?= Url::to(["/mediator/report/jobseeker-list"], true) ?>'> List </a>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="glyphicon glyphicon-chevron-right"></i>
                                <a href='<?= Url::to(["/mediator/report/jobseeker-by-location"], true) ?>'> Location </a>
                            </td>
                        </tr>

                        <tr>
                            <td><i class="glyphicon glyphicon-chevron-right"></i>
                                <a href='<?= Url::to(["/mediator/report/jobseeker-by-industries"], true) ?>'>Industries </a>
                            </td>
                        </tr>

                        <tr>
                            <td><i class="glyphicon glyphicon-chevron-right"></i>
                                <a href='<?= Url::to(["/mediator/report/jobseeker-by-occupation"], true) ?>'>Occupation </a>
                            </td>
                        </tr>

                        <tr>
                            <td><i class="glyphicon glyphicon-chevron-right"></i>
                                <a href='<?= Url::to(["/mediator/report/jobseeker-by-physical-disability"], true) ?>'> Physical Disability </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="panel widget light-widget panel-bd-top">
                <div class="panel-heading no-title">
                    <h3>
                        <center>Employer By</center>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td><i class="glyphicon glyphicon-chevron-right"></i>
                                <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'> List </a>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="glyphicon glyphicon-chevron-right"></i>
                                <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'> Location </a>
                            </td>
                        </tr>

                        <tr>
                            <td><i class="glyphicon glyphicon-chevron-right"></i>
                                <a href='<?= Url::to(["/mediator/report/employer-by-location"], true) ?>'>Industries </a>
                            </td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="panel widget light-widget panel-bd-top">
                <div class="panel-heading no-title" style="height: 20px"> </div>
                <div class="panel-body">
                    <div class="js-case-management-index">
                        <div id="ajaxCrudDatatable">
                            <h1>Working on it..</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>