<?php

namespace frontend\modules\jobseeker\controllers;

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

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class RegisterController extends \yii\web\Controller
{
    const USER = 'USER';
   
    /**
     * @return array
     */

    public $name;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index', 'erecruitment',
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'index',
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
        // $experience     = new JsExperience();

        $trans = Yii::$app->db->beginTransaction();
        try {

            if ($model->load(Yii::$app->request->post())) {

                $address->load(Yii::$app->request->post());
                $education->load(Yii::$app->request->post());
                $identification->load(Yii::$app->request->post());

                //Validate models
                $model->validate();
                $identification->validate();
                $address->validate();
                $education->validate();

                if($identification->id_number!='')
                    $identification->dob = $_POST['dob-userprofile-dob-disp'];

                if($identification->passport_number!='')
                {
                    $identification->firstname = $identification->pfirstname;
                    $identification->middlename = $identification->pmiddlename;
                    $identification->lastname = $identification->plastname;
                    $identification->gender = $identification->pgender;
                    $identification->dob = $identification->pdob;
                }

                $session = Yii::$app->session;
                $session->set('name', $identification->firstname.' '.$identification->middlename.' '.$identification->lastname);

                if(!$identification->ageRestriction()){
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t('frontend', 'Your age should be above 15 or under 60 years old.'
                        ),
                        'options' => ['class' => 'alert-danger']
                    ]);

                    return $this->render('register', [
                        'model' => $model,
                        'identification' => $identification,
                        'education'=> $education,
                        'address'  => $address
                    ]);
                }

                $model->username = $model->email;
                
                $user = $model->signup(User::ROLE_USER);            
                if(is_null($user)){
                    return $this->render('register', [
                        'model' => $model,
                        'identification' => $identification,
                        'education'=> $education,
                        'address'  => $address
                    ]);
                }
                $identification->locale     = Yii::$app->language;
                $identification->user_id    = $user->id;
                $identification->created_by = $user->id;
                $identification->updated_by = $user->id;
                $identification->save();

                $education->certificate_path = Yii::$app->myfield->myupload($education, 'certificateFile');
                $education->certificateFile = NULL;
                $education->user_id    = $user->id;
                $education->created_by = $user->id;
                $education->updated_by = $user->id;
                $education->save();

                $address->user_id       = $user->id;
                $address->country_id       = 183;
                $address->created_by    = $user->id;
                $address->updated_by    = $user->id;
                $address->emailAddress  = $model->email;
                $address->phoneNumber   = $model->phone;
                $address->save();

                // $experience->user_id       = $user->id;
                // $experience->created_by    = $user->id;
                // $experience->updated_by    = $user->id;
                // $experience->exact_position= 'not set';
                // $experience->experience_in_this_occupation ='';
                // $experience->save(false);

                $trans->commit();
                
                if ($user) {
                    // echo $path; die;

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

                    return $this->render('register', [
                        'identification' => $identification,
                        'education'=> $education,
                        'address'=> $address,
                        'model' => $model
                    ]);
                }
            }
        } catch (Exception $exc) {
            $trans->rollBack();
        }

        return $this->render('register', [
            'identification' => $identification,
            'education'=> $education,
            'address'=> $address,
            'model' => $model,
        ]);
    }

    public function actionNid($id)
    {
        $identification = new UserProfile();
        
        $client = Yii::$app->siteApi;
        $result = $client->GetCitizen(array('id' => $id));
        $result = ArrayHelper::toArray($result);

        $id = array();

        $id[]= $result['GetCitizenResult']['foreNameField'];
        $id[] = $result['GetCitizenResult']['surnamesField'];
        $id[] = $result['GetCitizenResult']['dateOfBirthField'];
        $id[] = $result['GetCitizenResult']['sexField'];

        $data=implode("*",$id);

        echo $data; die;
    }

    public function actionNidall($id)
    {
        $client = Yii::$app->siteApi;
        $result = $client->GetCitizen(array('id' => $id));
        $result = ArrayHelper::toArray($result);

        print"<pre>";
        print_r($result);
        print"<pre>";
        die;
    }
}
