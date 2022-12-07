<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleAttachment;
use common\models\ArticleCategory;
use common\models\ServiceJob;
use frontend\models\search\ArticleSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    /**
     * @return string
     */

    public function init()
    {
		if(isset(Yii::$app->request->cookies['language']->value))//If there is language defined in cookie, use it
			Yii::$app->language = Yii::$app->request->cookies['language']->value;
		// else 
		// 	Yii::$app->language = 'en';
	
    }
    
    public function actionIndex()
    {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "howtoapply.png";

        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        // $this->view->params['bgimage'] = "nep.png";
        $currentdate = date('Y-m-d');
        
        $model = Article::find()->published()->andWhere(['slug' => $slug])->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }
        else{
            $category = ArticleCategory::find()->andWhere(['parent_id' => $model->category_id])->all();
            if(empty($category))
                $category = ArticleCategory::find()->andWhere(['id' => $model->category_id])->all();

        }

        $viewFile = $model->view ?: 'view';
        return $this->render($viewFile, [
            'model' => $model,
            'category' => $category,
            'jobs'  => ServiceJob::find()->select('occupation_grouping_id,count(*) AS id')->where(['>=', 'closure_date', $currentdate])->andWhere(['competency_level_id' => 2])->andWhere(['action_id' => 1])->groupBy('occupation_grouping_id')->orderBy('occupation_grouping_id')->all(),
        ]);
    }

    /**
     * @param $id
     * @return $this
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAttachmentDownload($id)
    {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }

        return Yii::$app->response->sendStreamAsFile(
            Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name
        );
    }
}
