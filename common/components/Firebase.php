<?php

namespace common\components;

use common\models\Queue;

class Firebase extends \yii\base\Component
{
    public $database = "";
    public $auth_key = "";


    public function addQueue(Queue $queue)
    {
        $data = [
            "doctor" => [
                "id" => $queue->doctor->id,
                "imageUrl" => $queue->doctor->imageUrl,
                "first_name" => $queue->doctor->first_name,
                "last_name" => $queue->doctor->last_name,
                "speciality" => $queue->doctor->speciality->name,
                "address" => $queue->doctor->hospital->address
            ],
            "date" => $queue->date,
            "queue_number" => $queue->queue_number,
            "client_id" => $queue->patient_id,
            "imageUrl" => $queue->client->image,
            "confirmed_by_reception" => true,
            "type" => $queue->type,
            "time" => $queue->time,
            "first_name" => $queue->first_name,
            "last_name" => $queue->last_name,
            "father_name" => $queue->father_name,
            "phone" => $queue->phone,
            "status" => $queue->status,
            "disease" => "bu yerda kasallik nomi boladi"
        ];

        $path = "queues/$queue->id";

        return $this->sendRequest("PUT", $path, $data);
    }

    public function changeQueue(Queue $queue)
    {
        $data = [
            "doctor" => [
                "id" => $queue->doctor->id,
                "imageUrl" => $queue->doctor->imageUrl,
                "first_name" => $queue->doctor->first_name,
                "last_name" => $queue->doctor->last_name,
                "speciality" => $queue->doctor->speciality->name,
                "address" => $queue->doctor->hospital->address
            ],
            "date" => $queue->date,
            "queue_number" => $queue->queue_number,
            "client_id" => $queue->patient_id,
            "imageUrl" => $queue->client->image,
            "confirmed_by_reception" => true,
            "type" => $queue->type,
            "time" => $queue->time,
            "first_name" => $queue->first_name,
            "last_name" => $queue->last_name,
            "father_name" => $queue->father_name,
            "phone" => $queue->phone,
            "status" => $queue->status,
            "disease" => "bu yerda kasallik nomi boladi"
        ];

        $path = "queues/$queue->id";

        return $this->sendRequest("PATCH", $path, $data);
    }

    public function deleteQueue(Queue $queue)
    {
        $path = "queues/$queue->id";
        return $this->sendRequest("DELETE", $path);
    }


    public function getData($path = null)
    {
        return $this->sendRequest("GET", $path);
    }


    private function sendRequest($method, $path, $data = null)
    {

        if ($path == "/") {
            $url = "$this->database/?auth=$this->auth_key";
        } else {
            $url = "$this->database/$path.json?auth=$this->auth_key";
        }
//        dd($url);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);

    }

}

