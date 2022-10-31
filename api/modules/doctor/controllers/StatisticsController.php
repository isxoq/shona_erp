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
use common\models\Transactions;
use hospital\models\Doctor;
use yii;
use yii\filters\auth\HttpHeaderAuth;

class StatisticsController extends BaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpHeaderAuth::class,
        ];
        return $behaviors;
    }

    public function actionGetStatistics($from, $to)
    {

        $queues = Queue::find()
            ->andWhere(['doctor_id' => Yii::$app->user->id]);


        $request = Yii::$app->request;

        $days = [];
        $begin = new \DateTime($from);
        $end = new \DateTime($to);


        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {

            $tempQueryEndedTashxis = clone $queues;
            $tempQueryEndedReception = clone $queues;
            $tempQueryCancelledTashxis = clone $queues;
            $tempQueryCancelledReception = clone $queues;

            $days[] = [
                'date' => $i->format('d.m.Y'),
                'ended_tashxis' => $tempQueryEndedTashxis->dayF($i->format("Y-m-d"), 'date')->andWhere(['type' => Queue::TYPE_TASHXIS])->andWhere(['status' => Queue::STATUS_END])->count(),
                'cancelled_tashxis' => $tempQueryCancelledTashxis->dayF($i->format("Y-m-d"), 'date')->andWhere(['type' => Queue::TYPE_TASHXIS])->andWhere(['status' => Queue::STATUS_CANCELLED])->count(),
                'ended_reception' => $tempQueryEndedReception->dayF($i->format("Y-m-d"), 'date')->andWhere(['type' => Queue::TYPE_RECEPTION])->andWhere(['status' => Queue::STATUS_END])->count(),
                'cancelled_reception' => $tempQueryCancelledReception->dayF($i->format("Y-m-d"), 'date')->andWhere(['type' => Queue::TYPE_RECEPTION])->andWhere(['status' => Queue::STATUS_CANCELLED])->count(),
            ];
        }

//        return $days;

        if ($request->get("type")) {
            $queues->andWhere(['type' => $request->get("type")]);
        }

        $queues->range($from, $to, "date");

        $endedQuery = clone $queues;
        $endedQuery->andWhere(['status' => Queue::STATUS_END]);

        $cancelledQuery = clone $queues;
        $cancelledQuery->andWhere(['status' => Queue::STATUS_CANCELLED]);


        return $this->success([
            "ended" => $endedQuery->count(),
            "cancelled" => $cancelledQuery->count(),
            "days" => $days
        ]);

    }

}