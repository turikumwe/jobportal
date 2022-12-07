<?php 
use \yii\widgets\ListView;
use yii\bootstrap\Html;

 ;
?>
<div class="panel widget light-widget panel-bd-top">
<div class="panel-heading no-title">Category </div>
    <div class="panel-body tags">
		<?= ListView::widget([
            'dataProvider' => $categoriesDataProvider,
            'layout' => '{items}',
            'options' => ['class' => 'list'],
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model) use ($searchModel) {
                /** @var Tag $model */
                return Html::a(
                    '<span class="name">' . Html::encode($model->jobtitle) . '</span>' .
                    '<span class="count">'.$model->frequency.'</span>',
                    ['/project/list', 'tags' => $model->jobtitle]
					//class' => $filterForm->hasTag($model->name) ? 'selected' : '']
                );
            }
        ]) ?>
	</div>
</div>