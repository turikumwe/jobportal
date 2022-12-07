
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
        <div class="panel-body">



            <div class="user-profile-index">
                <div id="ajaxCrudDatatable">
                    <?php \yii\widgets\Pjax::begin(['id' => 'crud-datatable', 'timeout' => false, 'enablePushState' => false,]); ?>
                    <?=
                    kartik\grid\GridView::widget([
                        'id' => 'crud-datatable',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'columns' => require(__DIR__ . '/_columns.php'),
                        'striped' => true,
                        'condensed' => true,
                        'pager' => [
                            'class' => 'yii\widgets\CustomLinkPager',
                        //other pager config if nesessary
                        ],
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => true,
                        'panel' => [
                            'type' => '',
                            'heading' => '<font color="#000000">List of Mediators</font> <a href="' . Yii::getAlias('@frontendUrl') . '/mediator/md-mediator/export-data' . '"><i class="fa fa-file-excel-o"> Export</i>',
                            // 'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                            '<div class="clearfix"></div>',
                        ]
                    ])
                    ?>
                    <?php \yii\widgets\Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>