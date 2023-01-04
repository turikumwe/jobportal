<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_access_token".
 *
 * @property int $id
 * @property string $token
 * @property string $created_on
 * @property string $expire_on
 */
class ApiAccessToken extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_access_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['token', 'expire_on'], 'required'],
            [['token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'created_on' => 'Created On',
            'expire_on' => 'Expire On',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ApiAccessTokenQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApiAccessTokenQuery(get_called_class());
    }

    public function getActiveAccessToken() {
        $active_token = ApiAccessToken::find()->where(['>', 'expire_on', new \yii\db\Expression('NOW()')])->one();
        if (!isset($active_token->token)) {
            $token_details = ApiAccessToken::requestToken();
            if (isset($token_details['token'])) {
                $access_token = ApiAccessToken::find()->where(['id' => 1])->one();
                $access_token->token = $token_details['token'];
                $access_token->expire_on = date("Y-m-d H:i:s", strtotime('+3 hours'));
                if ($access_token->save()) {
                    return $token_details['token'];
                }
            } else {
                
            }
        } else {
            
            //Before confirming the validity, attempt token validation request
            $url = 'https://app.testgorilla.com/api/assessments/542a41874'; //This sample test url to test the token validity. The specified token does not exists

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token ' . $active_token->token));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $response = curl_exec($ch);
            $response_data = json_decode($response, true);
            curl_close($ch);
            
            if (isset($response_data['detail']) && $response_data['detail'] == 'Invalid token.') { //The details comes when there an error. This error will related to 
                $token_details = ApiAccessToken::requestToken();
                $access_token = ApiAccessToken::find()->where(['id' => 1])->one();
                $access_token->token = $token_details['token'];
                $access_token->expire_on = date("Y-m-d H:i:s", strtotime('+3 hours'));
                if ($access_token->save()) {
                    return $token_details['token'];
                }
            } else {
                return $active_token->token;
            }
        }
    }

    public function requestToken() {
        //Request new token
        $url = 'https://app.testgorilla.com/api/profiles/login/';

        $data = array(
            'username' => 'jeanpaul.turikumwe01+API@gmail.com',
            'password' => 'KoraRwa@123!'
        );

        $body = json_encode($data);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'origin:https://app.testgorilla.com'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);
        $conn = \Yii::$app->db;

        $query = "insert into api_requests(request_url,request_data,response_data) value('" . $url . "','Get assessment candidate details','" . str_replace("'", " ", $result) . "')";
        $conn->CreateCommand($query)->execute();

        $result_array = json_decode($result, true);
        return $result_array;
    }

}
