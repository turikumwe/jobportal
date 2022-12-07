<?php

namespace frontend\controllers;

use yii\web\BadRequestHttpException;
use Sitemaped\Element\Urlset\Urlset;
use yii\web\NotFoundHttpException;
use common\sitemap\UrlsIterator;
use frontend\models\ContactForm;
use yii\filters\PageCache;
use common\models\Page;
use yii\web\Controller;
use yii\web\Response;
use common\models\ServiceJob;
use Sitemaped\Sitemap;
use cheatsheet\Time;
use Yii;
use \yii\helpers\ArrayHelper;
use common\models\Article;

/**
 * Site controller
 */
class SiteController extends Controller {

    public function init() {
        if (isset(Yii::$app->request->cookies['language']->value))//If there is language defined in cookie, use it
            Yii::$app->language = Yii::$app->request->cookies['language']->value;
        // else
        // 	Yii::$app->language = 'en';
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [
            [
                'class' => PageCache::class,
                'only' => ['sitemap', 'nep', 'careerguidance', 'employmentservicecentre', 'howtoapply'],
                'duration' => Time::SECONDS_IN_AN_HOUR,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale' => [
                'class' => 'common\actions\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    /**
     * @return string
     */
    //public profile
    public function actionSeekerProfile($idOtherProfile = null) {
        //$this->layout = 'dashboard';
        $accountForm = new \frontend\modules\user\models\AccountForm;

        if (is_null($idOtherProfile)) {

            $accountForm->setUser(Yii::$app->user->identity);
        } else {

            $accountForm->setUser(\common\models\User::findOne($idOtherProfile));
            Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                        'category' => 'profile',
                        'event' => 'profile-view',
                        'data' => [
                            'user_id' => $idOtherProfile,
                            'created_at' => time(),
                        ]
            ]));
        }

        $user_id = is_null($idOtherProfile) ? Yii::$app->user->id : $idOtherProfile;

        if ($accountForm->load(Yii::$app->request->post()) && $accountForm->save()) {

            return $this->refresh();
        }
        //jobseekersummary
        $conn = \Yii::$app->db;
        $summary = 'select * from js_summary where user_id="' . $user_id . '"';
        $summ = $conn->createCommand($summary)->queryAll();
        //jobseeker skills
        $skill = 'select j.id,s.skill,l.level  from s_skill as s ,js_skill as j,s_skill_level as l where j.skill_id=s.id and j.skill_level_id=l.id and j.user_id="' . $user_id . '"';
        $skillresult = $conn->createCommand($skill)->queryAll();
        //jobseeker experience
        $exp = 'select j.id,c.occupation,j.start_date,j.end_date,j.company,i.experience_interval   from s_isco08_level4 as c,js_experience as j,s_experience_interval as i where j.occupation_id=c.id and j.experience_in_this_occupation=i.id and j.user_id="' . $user_id . '" ';
        $experience = $conn->createCommand($exp)->queryAll();
        //education
        $education = 'select j.start_date,j.end_date,j.id,j.school,j.country_id,l.level,e.field,j.certificate_id from js_education as j,s_education_field as e,s_education_level as l where j.education_level_id=l.id and j.education_field_id=e.id and j.user_id="' . $user_id . '"';
        $edu = $conn->createCommand($education)->queryAll();
        //training
        $trainingz = 'select * from js_training where user_id="' . $user_id . '"';
        $trainresult = $conn->createCommand($trainingz)->queryAll();

        return $this->render('profile', [
                    'jobseeker' => \common\models\User::findOne($user_id),
                    'account' => $accountForm,
                    'idOtherProfile' => $idOtherProfile,
                    'summary' => $summ,
                    'skills' => $skillresult,
                    'userid' => $idOtherProfile,
                    'language' => \common\models\JsLanguage::find()->where(['user_id' => $idOtherProfile])->all(),
                    'experience' => $experience,
                    'Endorse' => \common\models\JsEndorse::find()->where(['user_id' => $idOtherProfile])->all(),
                    'education' => $edu,
                    'address' => \common\models\JsAddress::find()->where(['user_id' => $idOtherProfile])->all(),
                    'recommendation' => \common\models\JsRecommendation::find()->where(['user_id' => $idOtherProfile])->all(),
                    'trainings' => $trainresult
        ]);
    }

    public function actionIndex() {
        $currentdate = date("Y-m-d");
        // echo $currentdate; die;
        //Track views
        // $provider = \Probe\ProviderFactory::create();
        // if ($provider) {
        //     $ip = $provider->getExternalIP();
        //     $geoip = Yii::$app->geoip->ip($ip);
        //     Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
        //         'category' => 'visitor',
        //         'event' => 'index-view',
        //         'data' => [
        //             'visitor_ip' => $ip,
        //             'country' => $geoip->country,
        //             'created_at' => time(),
        //         ]
        //     ]));
        // }

        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'index-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        $high = ServiceJob::find()
                ->select('occupation_grouping_id,count(*) AS id')
                ->andWhere(['>=', 'closure_date', $currentdate])
                ->andWhere(['action_id' => 1])
                ->andWhere(['!=', 'occupation_grouping_id', 99])
                ->groupBy('occupation_grouping_id')
                ->orderBy(['count(*)' => SORT_DESC])
                ->one();

        return $this->render('index', [
                    'model' => Page::find()->where(['status' => Page::STATUS_PUBLISHED])->andWhere(['>=', 'closure_date', '2019-04-09']),
                    // 'job'   => ServiceJob::find()->where(['>=','closure_date',$currentdate])->all(),
                    'high' => $high,
                    'jobs' => ServiceJob::find()
                            ->select('occupation_grouping_id,count(*) AS id')
                            ->where(['>=', 'closure_date', $currentdate])
                            ->andWhere(['action_id' => 1])
                            ->andWhere(['!=', 'occupation_grouping_id', (!empty($high)) ? $high->occupation_grouping_id : ""])
                            ->groupBy('occupation_grouping_id')
                            ->orderBy('occupation_grouping_id')
                            ->all(),
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options' => ['class' => 'alert-success']
                ]);
                return $this->refresh();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => \Yii::t('frontend', 'There was an error sending email.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('contact', [
                    'model' => $model
        ]);
    }

    public function actionAboutus() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "howtoapply.png";

        return $this->render('aboutus');
    }

    /**
     * @param string $format
     * @param bool $gzip
     * @return string
     */
    public function actionSitemap($format = Sitemap::FORMAT_XML, $gzip = false) {
        $links = new UrlsIterator();
        $sitemap = new Sitemap(new Urlset($links));

        Yii::$app->response->format = Response::FORMAT_RAW;

        if ($gzip === true) {
            Yii::$app->response->headers->add('Content-Encoding', 'gzip');
        }

        if ($format === Sitemap::FORMAT_XML) {
            Yii::$app->response->headers->add('Content-Type', 'application/xml');
            $content = $sitemap->toXmlString($gzip);
        } else if ($format === Sitemap::FORMAT_TXT) {
            Yii::$app->response->headers->add('Content-Type', 'text/plain');
            $content = $sitemap->toTxtString($gzip);
        } else {
            throw new BadRequestHttpException('Unknown format');
        }

        $linksCount = $sitemap->getCount();
        if ($linksCount > 50000) {
            Yii::warning(\sprintf('Sitemap links count is %d'), $linksCount);
        }

        return $content;
    }

    public function actionCareerguidance() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "careerguidance.png";

        $model = Article::find()->published()->andWhere(['slug' => 'careerplanning'])->one();
        $model1 = Article::find()->published()->andWhere(['slug' => 'applyforjobs'])->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }

        //Track views
        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'career-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        $viewFile = $model->view ?: 'careerguidance';
        return $this->render($viewFile, ['model' => $model, 'model1' => $model1]);
    }

    public function actionHowtoapply() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "howtoapply.png";

        $model = Article::find()->published()->andWhere(['slug' => 'jobsearch'])->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }

        //Track views
        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'howtoapply-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        $viewFile = $model->view ?: 'howtoapply';
        return $this->render($viewFile, ['model' => $model]);
    }

    public function actionVideos() {
        return $this->render("videos");
    }

    public function actionNep() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "nep.png";

        $model = Article::find()->published()->andWhere(['slug' => 'nepinterventions'])->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }

        //Track views
        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'nep-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        $viewFile = $model->view ?: 'nep';
        return $this->render($viewFile, ['model' => $model]);
    }

    public function actionLmi() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "bg-image";

        $model = Article::find()->published()->andWhere(['slug' => 'lmi'])->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }

        $viewFile = $model->view ?: 'lmi';
        return $this->render($viewFile, ['model' => $model]);
    }

    public function actionEmploymentservicecentre() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "employmentservicecentre.png";

        $model = Article::find()->published()->andWhere(['slug' => 'employmentservicecentre'])->one();
        // $model1 = Article::find()->published()->andWhere(['slug' => 'applyforjobs'])->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }

        //Track views
        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'center-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        $viewFile = $model->view ?: 'employmentservicecentre';
        return $this->render($viewFile, ['model' => $model]);
    }

    public function actionKesc() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "employmentservicecentre.png";

        return $this->render('kesc');
    }

    public function actionMesc() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "employmentservicecentre.png";

        return $this->render('mesc');
    }

    public function actionHesc() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "employmentservicecentre.png";

        return $this->render('hesc');
    }

    public function actionLoanFacility() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "nep.png";

        return $this->render('loanfacility');
    }

    public function actionEmployabilitySkills() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "nep.png";

        return $this->render('employabilityskills');
    }

    public function actionJobseeker() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "homepage.png";

        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'jobseeker-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        return $this->render('jobseeker');
    }

    public function actionEmployer() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "employers.png";

        //Track views
        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'employer-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        return $this->render('employer');
    }

    public function actionJobagent() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "employmentservicecentre.png";

        //Track views
        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'jobagent-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        return $this->render('jobagent');
    }

    public function actionAbroad() {
        $this->layout = 'subpage';
        $this->view->params['bgimage'] = "opportunities.png";

        $currentdate = date("Y-m-d");

        //Track views
        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'abroad-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        return $this->render('abroad',
                        [
                            'jobs' => ServiceJob::find()->select('occupation_grouping_id,count(*) AS id')->where(['>=', 'closure_date', $currentdate])->andWhere(['competency_level_id' => 2])->andWhere(['action_id' => 1])->groupBy('occupation_grouping_id')->orderBy('occupation_grouping_id')->all(),
                        ]
        );
    }

    public function actionLanguage($id) {
        Yii::$app->language = $id;

        $cookie = new yii\web\Cookie([
            'name' => 'language',
            'value' => $id
        ]);

        Yii::$app->getResponse()->getCookies()->add($cookie);

        return $this->goHome();
    }

    public function actionCreateaccount()
    {
        //$this->layout = 'subpage';
        $this->view->params['bgimage'] = "howtoapply.png";

        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'createaccount-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        return $this->render(
                        'createaccount'
        );
    }

    /* ======================career start=========================== */

    public function actionCareersectors() {
        $currentdate = date("Y-m-d");
        // echo $currentdate; die;
        //Track views
        // $provider = \Probe\ProviderFactory::create();
        // if ($provider) {
        //     $ip = $provider->getExternalIP();
        //     $geoip = Yii::$app->geoip->ip($ip);
        //     Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
        //         'category' => 'visitor',
        //         'event' => 'index-view',
        //         'data' => [
        //             'visitor_ip' => $ip,
        //             'country' => $geoip->country,
        //             'created_at' => time(),
        //         ]
        //     ]));
        // }

        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'index-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        $high = ServiceJob::find()
                ->select('occupation_grouping_id,count(*) AS id')
                ->andWhere(['>=', 'closure_date', $currentdate])
                ->andWhere(['action_id' => 1])
                ->andWhere(['!=', 'occupation_grouping_id', 99])
                ->groupBy('occupation_grouping_id')
                ->orderBy(['count(*)' => SORT_DESC])
                ->one();

        return $this->render('careersectors', [
                    'model' => Page::find()->where(['status' => Page::STATUS_PUBLISHED])->andWhere(['>=', 'closure_date', '2019-04-09']),
                    // 'job'   => ServiceJob::find()->where(['>=','closure_date',$currentdate])->all(),
                    'high' => $high,
                    'jobs' => ServiceJob::find()
                            ->select('occupation_grouping_id,count(*) AS id')
                            ->where(['>=', 'closure_date', $currentdate])
                            ->andWhere(['action_id' => 1])
                            ->andWhere(['!=', 'occupation_grouping_id', (!empty($high)) ? $high->occupation_grouping_id : ""])
                            ->groupBy('occupation_grouping_id')
                            ->orderBy('occupation_grouping_id')
                            ->all(),
        ]);
    }

    public function actionCareerchoice() {
        //$this->layout = 'subpage';
        //$this->view->params['bgimage'] = "howtoapply.png";

        return $this->render('careerchoice');
    }

    public function actionCareeredu() {
        //$this->layout = 'subpage';
        //$this->view->params['bgimage'] = "howtoapply.png";

        return $this->render('careeredu');
    }

    public function actionSectors() {
        $currentdate = date("Y-m-d");
        // echo $currentdate; die;
        //Track views
        // $provider = \Probe\ProviderFactory::create();
        // if ($provider) {
        //     $ip = $provider->getExternalIP();
        //     $geoip = Yii::$app->geoip->ip($ip);
        //     Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
        //         'category' => 'visitor',
        //         'event' => 'index-view',
        //         'data' => [
        //             'visitor_ip' => $ip,
        //             'country' => $geoip->country,
        //             'created_at' => time(),
        //         ]
        //     ]));
        // }

        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'index-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        $high = ServiceJob::find()
                ->select('occupation_grouping_id,count(*) AS id')
                ->andWhere(['>=', 'closure_date', $currentdate])
                ->andWhere(['action_id' => 1])
                ->andWhere(['!=', 'occupation_grouping_id', 99])
                ->groupBy('occupation_grouping_id')
                ->orderBy(['count(*)' => SORT_DESC])
                ->one();

        return $this->render('sectors', [
                    'model' => Page::find()->where(['status' => Page::STATUS_PUBLISHED])->andWhere(['>=', 'closure_date', '2019-04-09']),
                    // 'job'   => ServiceJob::find()->where(['>=','closure_date',$currentdate])->all(),
                    'high' => $high,
                    'jobs' => ServiceJob::find()
                            ->select('occupation_grouping_id,count(*) AS id')
                            ->where(['>=', 'closure_date', $currentdate])
                            ->andWhere(['action_id' => 1])
                            ->andWhere(['!=', 'occupation_grouping_id', (!empty($high)) ? $high->occupation_grouping_id : ""])
                            ->groupBy('occupation_grouping_id')
                            ->orderBy('occupation_grouping_id')
                            ->all(),
        ]);
    }

    /* ======================career start=========================== */
}
