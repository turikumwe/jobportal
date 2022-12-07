<?php

namespace frontend\modules\service\controllers;

use yii\web\Controller;
use Yii;
use \yii\web\Response;
use common\models\JsSummary;
use common\models\JsExperience;
use common\models\JsLanguage;
use common\models\JsSkill;
use common\models\JsTraining;
use common\models\ServiceJob;
use common\models\JsEducation;
use common\models\JsAddress;

/**
 * Default controller for the `service` module
 */
class ApiController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionCheckService() {

        $request = Yii::$app->request;
        $service_id = $request->post('id');
        $service = \common\models\SServices::findOne($service_id);
        $is_placement = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($service->is_placement == 1) {
            $is_placement = true;
        }
        return [
            'success' => $is_placement
        ];
    }

    public function actionProfileCompletenessModal() {
        $request = Yii::$app->request;
        $user_id = $request->post('id');
        // $summary = New JsSummary();
        $summary = JsSummary::find()->where(['user_id' => $user_id])->count();
        $experience = JsExperience::find()->where(['user_id' => $user_id])->count();
        $education = JsEducation::find()->where(['user_id' => $user_id])->count();
        $training = JsTraining::find()->where(['user_id' => $user_id])->count();
        $language = JsLanguage::find()->where(['user_id' => $user_id])->count();
        $skill = JsSkill::find()->where(['user_id' => $user_id])->count();
        $address = JsAddress::find()->where(['user_id' => $user_id])->count();

        $user_profile = \common\models\UserProfile::findOne($user_id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        $oppforabroad = ServiceJob::find()
                ->where(['competency_level_id' => 2])
                ->andWhere(['action_id' => 1])
                ->andWhere(['>=', 'closure_date', date('Y-m-d')])
                ->count();

        $response = '<tr>
                                <th>Names</th>
                                <th>' . $user_profile->lastname . ' ' . $user_profile->firstname . '</th>
                            </tr>
                            <tr>
                                <th colspan="2">Completed sections</th>
                            </tr>';
        $completed = array();
        if ($summary >= 1) {
            $response .= '<tr>
                                <td>Summary</td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button" style="background-color: green; color: #fff;"><span class="fa fa-check"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $completed[] = "CV <span class='glyphicon glyphicon-ok'></span>";
        }

        if ($experience >= 1) {
            $response .= '<tr>
                                <td>Professional experience (' . $experience . ')</td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button" style="background-color: green; color: #fff;"><span class="fa fa-check"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $completed[] = "Professional experience ($experience) <span class='glyphicon glyphicon-ok'></span>";
        }

        if ($education >= 1) {
            $response .= '<tr>
                                <td>Education (' . $education . ')</td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button" style="background-color: green; color: #fff;"><span class="fa fa-check"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $completed[] = "Education ($education) <span class='glyphicon glyphicon-ok'></span>";
        }

        if ($training >= 1) {
            $response .= '<tr>
                                <td>Training (' . $training . ')</td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button" style="background-color: green; color: #fff;"><span class="fa fa-check"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $completed[] = "Training ($training) <span class='glyphicon glyphicon-ok'></span>";
        }

        if ($language >= 1) {
            $response .= '<tr>
                                <td>Language (' . $language . ')</td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button" style="background-color: green; color: #fff;"><span class="fa fa-check"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $completed[] = "Language ($language) <span class='glyphicon glyphicon-ok'></span>";
        }

        if ($skill >= 1) {
            $response .= '<tr>
                                <td>Skill (' . $skill . ')</td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button" style="background-color: green; color: #fff;"><span class="fa fa-check"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $completed[] = "Skill ($skill) <span class='glyphicon glyphicon-ok'></span>";
        }


        if ($address >= 1) {
            $response .= '<tr>
                                <td>Address </td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button" style="background-color: green; color: #fff;"><span class="fa fa-check"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $completed[] = "Skill ($skill) <span class='glyphicon glyphicon-ok'></span>";
            $completed[] = "Address <span class='glyphicon glyphicon-ok'></span>";
        }

        $profile = count($completed);

        $response .= '<tr><th colspan="2">Uncompleted sections</th></tr>';

        $missing = array();
        if ($summary == 0) {
            $response .= '<tr>
                                <td>Summary </td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button btn-danger" style="background-color: red; color: #fff;"><span class="fa fa-close"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $missing[] = 'CV';
        }

        if ($experience == 0) {
            $response .= '<tr>
                                <td>Professional experience </td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button btn-danger" style="background-color: red; color: #fff;"><span class="fa fa-close"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $missing[] = 'Professional experience';
        }

        if ($education == 0) {
            $response .= '<tr>
                                <td>Education </td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button btn-danger" style="background-color: red; color: #fff;"><span class="fa fa-close"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $missing[] = 'Education';
        }

        if ($training == 0) {
            $response .= '<tr>
                                <td>Training </td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button btn-danger" style="background-color: red; color: #fff;"><span class="fa fa-close"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $missing[] = 'Training';
        }

        if ($language == 0) {
            $response .= '<tr>
                                <td>Language </td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button btn-danger" style="background-color: red; color: #fff;"><span class="fa fa-close"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $missing[] = 'Language';
        }

        if ($skill == 0) {
            $response .= '<tr>
                                <td>Skill </td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button btn-danger" style="background-color: red; color: #fff;"><span class="fa fa-close"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $missing[] = 'Skill';
        }

        if ($address == 0) {
            $response .= '<tr>
                                <td>Address </td>
                                <td class="pxp-dashboard-table-options"><ul class="list-unstyled">
                                        <li>
                                            <button class="action-button btn-danger" style="background-color: red; color: #fff;"><span class="fa fa-close"></span></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
            $missing[] = 'Address';
        }

        return [
            'table_data' => $response
        ];
    }

    public function actionCoverLetterModal() {
        $request = Yii::$app->request;
        $application_id = $request->post('id');
        // $summary = New JsSummary();
        $application = \common\models\JsJobApplication::find()->where(['id' => $application_id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = '<tr><td>' . $application->motivation . '</td></tr>';

        return [
            'table_data' => $response
        ];
    }

    public function actionNotificationModal() {
        $request = Yii::$app->request;
        $notification_id = $request->post('id');
        // $summary = New JsSummary();
        $notification = \common\models\SNotifications::find()->where(['id' => $notification_id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = '<tr><th>Title</th><td>' . $notification->message_title . '</td></tr>';
        $response .= '<tr><th>Message</th><td>' . $notification->message_body . '</td></tr>';
        $notification->is_opened = 1;
        $notification->save(false);
        return [
            'table_data' => $response
        ];
    }

}
