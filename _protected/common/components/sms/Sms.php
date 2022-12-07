<?php 
namespace common\components\sms;

class Sms 
{

    public function send($phoneTo,$message){

    $url = 'http://172.17.83.20:3339?' . http_build_query([
                        'username' => '888_rdb',
                        'password' => 'com@1234',
                        'type'=>'',
                        'dlr'=>1,
                        'source'=>'JobPortal',
                        'destination' => $phoneTo,
                        'message' => $message
                    ]);

    // $url = 'https://rest.nexmo.com/sms/json?' . http_build_query([
    //                     'api_key' => '2295f8db',
    //                     'api_secret' => 'L1A5oPHO4YatKVjV',
    //                     'from' => '447401170470',
    //                     'to' => $phoneTo,
    //                     'text' => $message
    //                 ]);

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);  

                // echo curl_error($ch);
               // var_dump($response);die; 
                return true; //TODO check first if sms is e=sent then return true or false
    }

}
?>