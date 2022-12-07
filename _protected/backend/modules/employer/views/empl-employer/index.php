<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\employer\models\search\EmplEmployerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Empl Employers');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>
<style>
    .modal-dialog {
        position:absolute;
        top:50% !important;
        transform: translate(0, -50%) !important;
        -ms-transform: translate(0, -50%) !important;
        -webkit-transform: translate(0, -50%) !important;
        margin:auto 20%;
        width:60%;
        height:80%;
    }
    .modal-content {
        min-height:100%;
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0; 
    }
    .modal-body {
        position:absolute;
        top:45px; /** height of header **/
        bottom:45px;  /** height of footer **/
        left:0;
        right:0;
        overflow-y:auto;
    }
    .modal-footer {
        position:absolute;
        bottom:0;
        left:0;
        right:0;
    }

</style>
<div class="empl-employer-index">
    <div id="ajaxCrudDatatable">
        <?php Pjax::begin(['id' => 'crud-datatable', 'timeout' => false, 'enablePushState' => false,]); ?>
        <?=
        GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                            ['role' => 'modal-remote', 'title' => 'Create new Empl Employers', 'class' => 'btn btn-default']) .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', ['deleted'],
                            ['role' => '#', 'title' => 'Deleted employers', 'class' => 'btn btn-default']) .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                            ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'success',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Empl Employers listing',
                'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                '<div class="clearfix"></div>',
            ]
        ])
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
])
?>
<?php Modal::end(); ?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Employer verification comment</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="user-profile-form"> 
                        <?php
                        //$password_model = \common\models\ChangePasswordForm::find()->where(['id' => \Yii::$app->user->identity->id])->One();
                        $verification = new \backend\models\EmployerVerification();
                        ?>
                        <?php $form = ActiveForm::begin(['action' => Url::to(['/employer/empl-employer/status']), 'id' => 'change_employer_status', 'method' => 'POST']); ?>

                        <?= $form->errorSummary($verification); ?>
                        <div class="col-md-12">
                            <div class="mb-12">
                                <div class="form-group field-employerverification-verification_comment">
                                    <label class="control-label" for="employerverification-verification_comment">Verification comment</label>
                                    <textarea id="verification_comment" class="form-control" name="verification_comment"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="employer_id" id="selected_employer_id" value="">
                            <input type="hidden" name="action" id="action" value="">
                            <hr />
                            <div class="form-group"> 
                                <?= Html::submitButton(Yii::t('app', 'Change status'), ['class' => 'btn btn-success','onclick' => 'return confirm_submission()', 'role'=>'button']) ?> 
                            </div> 

                            <?php ActiveForm::end(); ?> 
                        </div>


                    </div> 
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    function confirm_action(id, action) {
        $('#selected_employer_id').val(id);
        $('#action').val(action);
    }
    function confirm_submission() {
        if($("#verification_comment").val().length<2){
            alert("Please provide valid comment");
            return false;
        }
        if (confirm("Are you sure you want to perfom this action?")) {
            $('#change_employer_status').submit();
        }
        return false;
    }
</script>