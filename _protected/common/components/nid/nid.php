<?php 
namespace common\components\nid;

class Nid
{

    public function send($id){

    $url = 'http://10.10.74.217:81/nida_ws/Service1.svc?wsdl' . http_build_query([
                        'text' => $id
                    ]);

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);  

                // echo curl_error($ch);
               var_dump($response);die; 
                return true; //TODO check first if sms is e=sent then return true or false
    }

}
?>