<?php

namespace console\controllers;

use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use yii\helpers\Json;
use common\models\ServiceJob;
use common\models\SNotifications;
use yii\helpers\ArrayHelper;
use mongosoft\soapclient\Client;

/**
 * Test controller
 */
class JobportalController extends Controller {

    public function actionIndex() {
        echo "Yes, cron service is running.";
    }

    public function actionGenerate() {
        $count = 1;
        $c = 1;
        $wn = array();

        $connection = Yii::$app->get("db");

        //Empty winning_number table
        $command = $connection->createCommand("
                TRUNCATE winning_number;
        ");
        $command->execute();

        // Get current value if the primary key
        $result = $connection->createCommand("
            SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = 'jobportal'
            AND   TABLE_NAME   = 'user';
        ")->queryOne();
        $lastId = $result['AUTO_INCREMENT'];

        //Generate random values
        while ($count <= 28) {
            $wn [] = mt_rand($lastId, $lastId + 150);
            $count = $count + 1;
        }

        //Get unique random values
        $wn = array_unique($wn);
        $wn = array_values(array_filter($wn));

        //Insert values in winning_number table
        for ($i = 0; $i < COUNT($wn) && $c <= 9; $i++) {
            $ticket = base64_encode($wn[$i]);
            $command = $connection->createCommand("
                INSERT INTO winning_number(number) VALUES ('$ticket');
            ");
            $result = $command->execute();
            $c = $c + 1;
        }
    }

    public function actionErecruitment() {
        $client = new Client([
            'url' => 'http://172.27.8.23:8081/IPPISRDBKoraService.svc?wsdl',
            'options' => [
                'trace' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
            ]
        ]);
        $result = $client->GetAdvertisements();
        $result = ArrayHelper::toArray($result); //Convert to array
        $vacancies = $result['GetAdvertisementsResult']['Vacancy'];
        $rows = [];

        foreach ($vacancies as $vacancy) {
            $jobArr = explode('/', $vacancy['Url']);
            $last = count($jobArr) - 1;
            $jobId = $jobArr[$last];

            $jobCount = ServiceJob::find()->andWhere(['other_source' => 0, 'reference_number' => $jobId])->count();

            if ($jobCount == 0) {
                $rows[] = [
                    'employer' => $vacancy['Institution'],
                    'other_source' => 0,
                    'jobtitle' => $vacancy['Job'],
                    's_opportunity_id' => 1,
                    'years_of_experience' => 0,
                    'link' => 'http://' . $vacancy['Url'],
                    'employerlogo_path' => '1/o8ziAZL5PgEW_HmlWmR_g18XF7Hdy1SW.jpg',
                    'employerlogo_base_url' => '//kora.rw/jobportal/storage/source',
                    'posting_date' => date('Y-m-d'),
                    'closure_date' => str_replace('T', ' ', $vacancy['Deadline']),
                    'competency_level_id' => 1,
                    'apply_through_kora_flag' => 0,
                    'reference_number' => $jobId,
                    'action_id' => 2,
                    'created_by' => 13252,
                    'created_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => 0,
                ];
            }
        }

        if (count($rows) != 0) {
            Yii::$app->db->createCommand()->batchInsert(
                    ServiceJob::tableName(),
                    [
                        'employer',
                        'other_source',
                        'jobtitle',
                        's_opportunity_id',
                        'years_of_experience',
                        'link',
                        'employerlogo_path',
                        'employerlogo_base_url',
                        'posting_date',
                        'closure_date',
                        'competency_level_id',
                        'apply_through_kora_flag',
                        'reference_number',
                        'action_id',
                        'created_by',
                        'created_at',
                        'deleted_by'
                    ],
                    $rows
            )->execute();
            echo "Vacancies pulled\n";
        } else
            echo "No new vacancy to pull\n";
        die;
    }

    public function actionNft() {
        $curl = curl_init();
        $rows = [];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://career.nftconsult.com/api/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('action' => '5f78b74af5bd4fb0a776deb8a9f6fb8c', 'auth_token' => 'bea4b69d3de54c0f9b3c32c9252c414c'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        //Convert json to array
        $data = Json::decode($response);
        $vacancies = $data['data'];

        foreach ($vacancies as $vacancy) {
            $link = ltrim($vacancy['job_link'], 'https://');
            $jobCount = ServiceJob::find()->andWhere(['other_source' => 0, 'reference_number' => $vacancy['id']])->count();

            if ($jobCount == 0) {
                $rows[] = [
                    'employer' => $vacancy['employer_name'],
                    'other_source' => 0,
                    'jobtitle' => $vacancy['job_title'],
                    's_opportunity_id' => 1,
                    'link' => 'http://' . $link,
                    'employerlogo_path' => '1/nft.jpg',
                    'employerlogo_base_url' => '//kora.rw/jobportal/storage/source',
                    'posting_date' => $vacancy['published_date'],
                    'closure_date' => str_replace('T', ' ', $vacancy['deadline_date']),
                    'competency_level_id' => 1,
                    'apply_through_kora_flag' => 0,
                    'reference_number' => $vacancy['id'],
                    'action_id' => 1,
                    'created_by' => 13251,
                    'created_at' => date('Y-m-d H:i:s'),
                    'publication_date' => $vacancy['published_date'],
                    'deleted_by' => 0
                ];
            }
        }
        if (count($rows) != 0) {
            Yii::$app->db->createCommand()->batchInsert(
                    ServiceJob::tableName(),
                    [
                        'employer',
                        'other_source',
                        'jobtitle',
                        's_opportunity_id',
                        'link',
                        'employerlogo_path',
                        'employerlogo_base_url',
                        'posting_date',
                        'closure_date',
                        'competency_level_id',
                        'apply_through_kora_flag',
                        'reference_number',
                        'action_id',
                        'created_by',
                        'created_at',
                        'publication_date',
                        'deleted_by'
                    ],
                    $rows
            )->execute();

            echo "Vacancies pulled\n";
        } else
            echo "No new vacancy to pull\n";
    }

    public function actionInviteCandidates($assessment_id) {
        $ch = curl_init(Yii::getAlias('@FullfrontendUrl') . '/hr/api/send-bulk-invitation?id=' . $assessment_id);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo $result;
    }
    public function actionSendBulkInvitationForAllAssessments() {
        $ch = curl_init(Yii::getAlias('@FullfrontendUrl') . '/hr/api/send-bulk-invitation-for-all-assessments');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo $result;
    }

    public function actionDeleteCandidate($candidate_id) {
        $ch = curl_init(Yii::getAlias('@FullfrontendUrl') . '/hr/api/delete-candidate?id=' . $candidate_id);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo $result;
    }

    public function actionSyncAssessmentCandidateResults($assessment_id, $testtaker_id) {
        $ch = curl_init(Yii::getAlias('@FullfrontendUrl') . '/hr/api/sync-assessment-candidate-results?assessment_id=' . $assessment_id . '&testtaker_id=' . $testtaker_id);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo $result;
    }
    public function actionSyncAsssessments() {
        $ch = curl_init(Yii::getAlias('@FullfrontendUrl') . '/hr/api/sync-assessments');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo $result;
    }
    public function actionSyncAsssessmentDetails($id) {
        $ch = curl_init(Yii::getAlias('@FullfrontendUrl') . '/hr/api/sync-assessment-details?id='.$id);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        echo $result;
    }
    public function actionSyncAsssessmentCandidateDetails($testtaker_id) {
        $ch = curl_init(Yii::getAlias('@FullfrontendUrl') . '/hr/api/sync-assessment-candidate-details?tt_id='.$testtaker_id);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        echo $result;
    }

    public function actionNotifyMatchingSkills() {

        //Get users with Matching skills
        $connection = Yii::$app->get("db");
        // Get current value if the primary key
        $result = $connection->createCommand("
        SELECT
	jobskills.job_id,
	service_job.employer,
	service_job.jobtitle,
	service_job.publication_date,
	js_skill.user_id,
	js_skill.skill_id 
        FROM
	service_job
	INNER JOIN jobskills ON service_job.id = jobskills.job_id
	INNER JOIN s_skill ON jobskills.skill_id = s_skill.id
	INNER JOIN js_skill ON s_skill.id = js_skill.skill_id
	WHERE
	service_job.action_id = 1
	AND CONCAT(service_job.id,'-',js_skill.user_id) NOT IN (
	SELECT
		CONCAT(opportunity_id,'-',user_id)
	FROM
		s_notifications 
	WHERE
		notification_type = '2' 
	AND ( deleted_at IS NULL OR deleted_at = 0 )) 
	AND CURDATE() <= service_job.closure_date
	GROUP BY
	CONCAT(service_job.id,'-',js_skill.user_id)")->queryAll();

        if (count($result) > 0) {

            foreach ($result as $candidate) {

                $current_user = \common\models\UserProfile::find()->where(['user_id' => $candidate['user_id']])->asArray()->one();

                $message = "Dear " . $current_user['firstname'] . ' ' . $current_user['lastname'] . ",<br /><br />"
                        . "This is notification serves to inform you that, There is a new Job which requires your skills posted."
                        . "<br /> <a href='" . Yii::getAlias('@frontendUrl') . '/service/service-job?id=' . $candidate['job_id'] . "' target='_blank'>Click here</a> to check the posted Job"
                        . "<br /><br />Please don't reply to this email as it is a System Generated<br /><br />Kora Job Portal";
                $message_title = 'New Job matching your skills posted - Kora Job Portal';

                $notifications[] = array(
                    'opportunity_id' => $candidate['job_id'],
                    'user_id' => $current_user['user_id'],
                    'message_body' => $message,
                    'message_title' => $message_title,
                    'notification_type' => 2, //New matching skills job posted
                    'created_by' => 13251,
                    'created_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => 0
                );
            }
            Yii::$app->db->createCommand()->batchInsert(
                    SNotifications::tableName(),
                    [
                        'opportunity_id',
                        'user_id',
                        'message_body',
                        'message_title',
                        'notification_type',
                        'created_by',
                        'created_at',
                        'deleted_by'
                    ],
                    $notifications
            )->execute();
        } else {
            // Now send emails
            if (Yii::$app->mailer->getTransport()->isStarted()) {
                Yii::$app->mailer->getTransport()->stop();
            }
            Yii::$app->mailer->getTransport()->start();
            $result = $connection->createCommand("SELECT * FROM s_notifications where notification_type = 2 and mail_sent = 0 and DATEDIFF(CURRENT_TIMESTAMP, created_at) <= 7;")->queryAll(); //Only 7 time try
            if (count($result) > 0) {
                foreach ($result as $notification) {
                    //Send email
                    $current_user_login = \common\models\User::findOne($notification['user_id']);
                    $send_email = Yii::$app->commandBus->handle(new \common\commands\SendEmailCommand([
                                'subject' => $notification['message_title'],
                                'to' => $current_user_login->email,
                                'body' => $notification['message_body']
                    ]));

                    if ($send_email) {
                        //Update the notification in db
                        $connection->createCommand("update s_notifications set mail_sent = 1 where id =" . $notification['id'] . ";")->execute();
                        error_log('Notifications sent');
                    } else {
                        error_log('Failed to send notifications');
                    }
                }
            } else {
                echo error_log('No matching users');
            }
        }
    }

    public function actionSendMailNotifications($notification_id = null) {

        //Get users with Matching skills
        $connection = Yii::$app->get("db");
        Yii::$app->mailer->getTransport()->start();
        if (isset($notification_id)) {
            $result = $connection->createCommand("SELECT * FROM s_notifications where notification_type <> 2 and mail_sent = 0 and DATEDIFF(CURRENT_TIMESTAMP, created_at) <= 7 and id =$notification_id;")->queryAll(); //Only 7 time try
        } else {
            $result = $connection->createCommand("SELECT * FROM s_notifications where notification_type <> 2 and mail_sent = 0 and DATEDIFF(CURRENT_TIMESTAMP, created_at) <= 7;")->queryAll(); //Only 7 time try
        }

        if (count($result) > 0) {
            foreach ($result as $notification) {
                //Send email
                $current_user_login = \common\models\User::findOne($notification['user_id']);
                $send_email = Yii::$app->commandBus->handle(new \common\commands\SendEmailCommand([
                            'subject' => $notification['message_title'],
                            'to' => $current_user_login->email,
                            'body' => $notification['message_body']
                ]));

                if ($send_email) {
                    //Update the notification in db
                    $connection->createCommand("update s_notifications set mail_sent = 1 where id =" . $notification['id'] . ";")->execute();
                    error_log('Notifications sent');
                } else {
                    error_log('Failed to send notifications');
                }
            }
        } else {
            echo error_log('No matching users');
        }
    }

}
