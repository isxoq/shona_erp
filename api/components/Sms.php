<?php

namespace api\components;
class Sms
{
    public static function sendSms($phone, $text)
    {
        $phone = \api\components\Phone::clear($phone);

        $data = [
            "token" => "1KFG8OGz0lHF4OAaEKYQ9Cx0",
            "phone" => $phone,
            "text" => $text,
            "provider" => "uzinfocom"
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://notify.gov.uz/api/web/rest/send-sms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }
}