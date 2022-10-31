<?php

namespace api\modules\client\controllers;
# User: isxoq
# Date: 06.11.2021
# Time: 11:51
# Year: 2021
# Project: tashxis.loc
# Full Name: Isxoqjon Axmedov
# Phone: +998936448111

use common\models\Queue;
use common\models\QueueState;
use hospital\models\Doctor;
use yii;
use yii\base\BaseObject;
use yii\filters\auth\HttpHeaderAuth;

class QueueController extends BaseController
{
	
	public $enableCsrfValidation = false;
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpHeaderAuth::class,
        ];
        
        return $behaviors;
    }

    public function actionAdd()
    {


        $data = yii\helpers\Json::decode(Yii::$app->request->rawBody, false);

        $doctor = Doctor::findOne($data->doctor_id);

        $queue = new Queue();
        $queue->patient_id = Yii::$app->user->id;
        $queue->type = Queue::TYPE_TASHXIS;
        $queue->price = $doctor->acceptance_amount;
        $queue->doctor_id = $data->doctor_id;
        $queue->is_payed = $data->is_payed;
        $queue->status = Queue::STATUS_WAITING;
        $queue->date = date('Y-m-d', strtotime($data->date));
        $queue->time = $data->time;
        $queue->created_at = time();

        $queue->first_name = Yii::$app->user->identity->first_name;
        $queue->last_name = Yii::$app->user->identity->last_name;
        $queue->father_name = Yii::$app->user->identity->father_name;
        $queue->phone = Yii::$app->user->identity->phone;

        $queue->save();

        Yii::$app->firebase->addQueue($queue);

        return $this->success($queue);
    }

    public function actionCancel()
    {


        $data = yii\helpers\Json::decode(Yii::$app->request->rawBody, false);
        $description = $data->description;

        $queue = Queue::findOne(['id' => $data->queue_id, 'patient_id' => user("id")]);

        if ($queue) {
            $queue->changeStatus(QueueState::STATUS_CANCELLED, $description);
            Yii::$app->firebase->deleteQueue($queue);
            return $this->success([
                "message" => t("Queue Cancelled")
            ]);
        } else {
            return $this->notFound();
        }


    }

    public function actionChange()
    {


        $data = yii\helpers\Json::decode(Yii::$app->request->rawBody, false);
        $date = $data->date;
        $time = $data->time;

        $queue = Queue::findOne(['id' => $data->queue_id, 'patient_id' => user("id")]);

        if ($queue) {
            $queue->date = date('Y-m-d', strtotime($data->date));
            $queue->time = $time;
            $queue->save();
            Yii::$app->firebase->changeQueue($queue);
            return $this->success([
                "message" => t("Queue Changed")
            ]);
        } else {
            return $this->notFound();
        }


    }

    public function actionGetWaiting($limit = false)
    {

        $data = yii\helpers\Json::decode(Yii::$app->request->rawBody, false);
        $queues = Queue::find()
            ->andWhere(['patient_id' => Yii::$app->user->id])
            ->andWhere(['status' => Queue::STATUS_WAITING])
            ->orderBy([
                'date' => SORT_ASC,
                'time' => SORT_ASC
            ])
            ->andWhere(['>=', 'date', date('Y-m-d')]);

        if ($limit) {
            $queues->limit($limit);
        }
        return $this->success($queues->all());
    }
}