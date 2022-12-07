<?php

namespace frontend\modules\abroad\controllers;

use frontend\modules\user\models\SignupForm;
use common\models\UserProfile;
use common\models\JsEducation;
use common\models\JsExperience;
use yii\filters\AccessControl;
use common\models\JsAddress;
use yii\filters\VerbFilter;
use common\models\User;
use yii\web\Response;
use Yii;
use \yii\helpers\ArrayHelper;
use common\models\JsSummary;
use frontend\modules\abroad\models\AbroadInterest;
use frontend\modules\abroad\models\AbroadEmploymentStatus;
use frontend\modules\abroad\models\AbroadShareProfile;
use common\models\Linkedinurl;

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class RegisterController extends \yii\web\Controller
{
    const USER = 'ABROAD';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'index'
                        ],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/employer/default/index']);
                        }
                    ],
                    [
                        'actions' => ['nid'],
                        'allow' => true
                    ]
                ]
            ],

        ];
    }


    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        $model          = new SignupForm();
        $identification = new UserProfile();
        $education      = new JsEducation();
        $address        = new JsAddress();
        $summary        = new JsSummary();
        $interest        = new AbroadInterest();
        $employmentstatus = new AbroadEmploymentStatus();
        $shareprofile = new AbroadShareProfile();
        $linkedinurl = new Linkedinurl();

        // $experience     = new JsExperience();

        $trans = Yii::$app->db->beginTransaction();
        try {

            if ($model->load(Yii::$app->request->post())) {

                $address->load(Yii::$app->request->post());
                $education->load(Yii::$app->request->post());
                $identification->load(Yii::$app->request->post());
                $summary->load(Yii::$app->request->post());
                $interest->load(Yii::$app->request->post());
                $employmentstatus->load(Yii::$app->request->post());
                $shareprofile->load(Yii::$app->request->post());
                $linkedinurl->load(Yii::$app->request->post());

                if ($identification->id_number != '')
                    $identification->dob = $_POST['dob-userprofile-dob-disp'];

                if ($identification->passport_number != '') {
                    $identification->firstname = $identification->pfirstname;
                    $identification->middlename = $identification->pmiddlename;
                    $identification->lastname = $identification->plastname;
                    $identification->gender = $identification->pgender;
                    $identification->dob = $identification->pdob;
                }

                if (!$identification->ageRestriction()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t('frontend', 'Your age should be above 15 or under 60 years old.'),
                        'options' => ['class' => 'alert-danger']
                    ]);

                    return $this->render('register', [
                        'model' => $model,
                        'identification' => $identification,
                        'education' => $education,
                        'address'  => $address,
                        'summary' => $summary,
                        'interest' => $interest,
                        'employmentstatus' => $employmentstatus,
                        'shareprofile' => $shareprofile,
                        'linkedinurl' => $linkedinurl,
                    ]);
                }

                $model->username = $model->email;

                $user = $model->signup(User::ROLE_USER);
                if (is_null($user)) {
                    return $this->render('register', [
                        'model' => $model,
                        'identification' => $identification,
                        'education' => $education,
                        'address'  => $address,
                        'summary' => $summary,
                        'interest' => $interest,
                        'employmentstatus' => $employmentstatus,
                        'shareprofile' => $shareprofile,
                        'linkedinurl' => $linkedinurl,
                    ]);
                }
                $identification->nationality     = 183;
                $identification->locale     = Yii::$app->language;
                $identification->user_id    = $user->id;
                $identification->created_by = $user->id;
                $identification->updated_by = $user->id;
                $identification->disability_id = 0;
                $identification->marital_status = 1;

                if (!$identification->save()) {
                    var_dump($identification->errors);
                    die;
                } else {
                    $education->user_id    = $user->id;
                    $education->created_by = $user->id;
                    $education->updated_by = $user->id;

                    if (!$education->save()) {
                        var_dump($education->errors);
                        die;
                    };

                    $address->user_id       = $user->id;
                    $address->province_id       = 6;
                    $address->district_id       = 61;
                    $address->sector_id       = 6101;
                    $address->created_by    = $user->id;
                    $address->updated_by    = $user->id;
                    $address->emailAddress  = $model->email;
                    $address->phoneNumber   = $model->phone;

                    if (!$address->save()) {
                        var_dump($address->errors);
                        die;
                    };

                    $interest->user_id       = $user->id;
                    $interest->created_by    = $user->id;
                    $interest->modified_by    = $user->id;

                    if (!$interest->save()) {
                        var_dump($interest->errors);
                    };

                    $employmentstatus->user_id       = $user->id;
                    $employmentstatus->created_by    = $user->id;
                    $employmentstatus->modified_by    = $user->id;

                    if (!$employmentstatus->save()) {
                        var_dump($employmentstatus->errors);
                        die;
                    };

                    $shareprofile->user_id       = $user->id;
                    $shareprofile->created_by    = $user->id;
                    $shareprofile->modified_by    = $user->id;

                    if (!$shareprofile->save()) {
                        var_dump($shareprofile->errors);
                        die;
                    };

                    $linkedinurl->url = 'http://' . trim($linkedinurl->url);
                    $linkedinurl->user_id       = $user->id;
                    $linkedinurl->created_by    = $user->id;
                    $linkedinurl->modified_by    = $user->id;

                    if (!$linkedinurl->save()) {
                        var_dump($linkedinurl->errors);
                        die;
                    };

                    $summary->cv_path = Yii::$app->myfield->myupload($summary, 'cvFile');
                    $summary->cvFile = Null;
                    $summary->user_id = $user->id;
                    $summary->professional_profile = "Not yet filled";
                    $summary->created_by = $user->id;
                    $summary->updated_by = $user->id;

                    if (!$summary->save()) {
                        var_dump($summary->errors);
                        die;
                    };
                }

                // $experience->user_id       = $user->id;
                // $experience->created_by    = $user->id;
                // $experience->updated_by    = $user->id;
                // $experience->exact_position= 'not set';
                // $experience->experience_in_this_occupation =0;
                // $experience->save(false);

                $trans->commit();

                if ($user) {
                    if ($model->shouldBeActivated()) {
                        Yii::$app->getSession()->setFlash('alert', [
                            'body' => Yii::t(
                                'frontend',
                                'Your account has been successfully created. Check your email for further instructions.'
                            ),
                            'options' => ['class' => 'alert-success']
                        ]);
                    } else {
                        Yii::$app->getUser()->login($user);
                    }

                    $model          = new SignupForm();
                    $identification = new UserProfile();
                    $education      = new JsEducation();
                    $address        = new JsAddress();
                    $summary        = new JsSummary();
                    $interest        = new AbroadInterest();
                    $employmentstatus = new AbroadEmploymentStatus();
                    $shareprofile = new AbroadShareProfile();
                    $linkedinurl = new Linkedinurl();

                    return $this->render('register', [
                        'identification' => $identification,
                        'education' => $education,
                        'address' => $address,
                        'model' => $model,
                        'summary' => $summary,
                        'interest' => $interest,
                        'employmentstatus' => $employmentstatus,
                        'shareprofile' => $shareprofile,
                        'linkedinurl' => $linkedinurl,
                    ]);
                }
            }
        } catch (Exception $exc) {
            $trans->rollBack();
        }

        return $this->render('register', [
            'identification' => $identification,
            'education' => $education,
            'address' => $address,
            'model' => $model,
            'summary' => $summary,
            'interest' => $interest,
            'employmentstatus' => $employmentstatus,
            'shareprofile' => $shareprofile,
            'linkedinurl' => $linkedinurl,
        ]);
    }

    public function actionNid($id)
    {
        $identification = new UserProfile();

        $client = Yii::$app->siteApi;
        $result = $client->GetCitizen(array('id' => $id));
        $result = ArrayHelper::toArray($result);

        $id = array();

        $id[] = $result['GetCitizenResult']['foreNameField'];
        $id[] = $result['GetCitizenResult']['surnamesField'];
        $id[] = $result['GetCitizenResult']['dateOfBirthField'];
        $id[] = $result['GetCitizenResult']['sexField'];

        $data = implode("-", $id);

        echo $data;
        die;
    }
}
