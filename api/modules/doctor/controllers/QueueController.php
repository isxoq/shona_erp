<?php

namespace api\modules\doctor\controllers;
# User: isxoq
# Date: 06.11.2021
# Time: 11:51
# Year: 2021
# Project: tashxis.loc
# Full Name: Isxoqjon Axmedov
# Phone: +998936448111
use api\controllers\BaseController;
use common\models\Queue;
use common\models\QueueState;
use hospital\models\Doctor;
use yii;
use yii\filters\auth\HttpHeaderAuth;

class QueueController extends BaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpHeaderAuth::class,
        ];
        return $behaviors;
    }

    public function actionQueueInfo($id)
    {

        $queue = Queue::find()
            ->andWhere(['id' => $id])
            ->andWhere(['doctor_id' => Yii::$app->user->id])
            ->one();


        if (!$queue) {
            return $this->notFound();
        }

        return $this->success($queue);
    }

    public function actionGetQueues()
    {
        $request = Yii::$app->request;
        $queues = Queue::find()
            ->andWhere(['doctor_id' => Yii::$app->user->id]);

        if ($request->get("today")) {
            $queues->todayDate();
        }

        if ($request->get("waiting")) {
            $queues->andWhere(['status' => Queue::STATUS_WAITING]);
        }

        if ($request->get("in_doctor")) {
            $queues->andWhere(['status' => Queue::STATUS_IN_DOCTOR]);
        }

        if ($request->get("cancelled")) {
            $queues->andWhere(['status' => Queue::STATUS_CANCELLED]);
        }

        if ($request->get("ended")) {
            $queues->andWhere(['status' => Queue::STATUS_END]);
        }
        if ($request->get("date")) {
            $queues->andWhere(['date' => $request->get("date")]);
        }

        $queues->orderBy('queue_number');
        
        return $this->success($queues->all());
    }

    public function actionQueueAccept()
    {
        $data = yii\helpers\Json::decode(Yii::$app->request->rawBody, false);

        try {
            $queue = Queue::findDoctorQueue($data->queue_id)
                ->andWhere(['status' => Queue::STATUS_WAITING])
                ->one();

            if ($queue) {
                $queue->changeStatus(Queue::STATUS_IN_DOCTOR, $data->description);
                Yii::$app->firebase->changeQueue($queue);
            } else {
                return $this->notFound();
            }


        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 101);
        }
        return $this->success($queue);
    }

    public function actionQueueEnd()
    {
        $data = yii\helpers\Json::decode(Yii::$app->request->rawBody, false);

        try {
            $queue = Queue::findDoctorQueue($data->queue_id)
                ->andWhere(['status' => Queue::STATUS_IN_DOCTOR])
                ->one();

            if ($queue) {
                $queue->changeStatus(Queue::STATUS_END, $data->description);
                Yii::$app->firebase->deleteQueue($queue);
            } else {
                return $this->notFound();
            }
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 101);
        }
        return $this->success($queue);
    }
}