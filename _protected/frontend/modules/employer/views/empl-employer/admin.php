<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

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
<div class="kora-container vd_content-section clearfix">
    <div class='row'>
        <div class="col-sm-3">
            <?= Yii::$app->jobSeeker->menu(); ?>
        </div>

        <div class="col-sm-9">
            <div class="panel widget light-widget">
                <div class="panel-heading"><?= Yii::t("frontend", "List of Employers") ?></div>
                <div class="panel-body">
                    <p>
                        <span>
                            <?= Html::a(Yii::t('app', 'Advanced Search'), '#', ['class' => 'btn btn-success search-button']) ?>
                        </span>
                    </p>

                    <div class="well search-form" style="display:none">
                        <?= $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                    <div class="user-profile-index">
                        <div id="ajaxCrudDatatable">
                            <?=
                            GridView::widget([
                                'id' => 'crud-datatable',
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'pjax' => true,
                                'columns' => require(__DIR__ . '/_columns.php'),
                                'striped' => true,
                                'condensed' => true,
                                'responsive' => true,
                            ])
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>