<?php

namespace api\modules\hospital\controllers;
# User: isxoq
# Date: 06.11.2021
# Time: 11:51
# Year: 2021
# Project: tashxis.loc
# Full Name: Isxoqjon Axmedov
# Phone: +998936448111
use api\components\Cors;
use api\components\Error;
use api\controllers\BaseController;
use common\models\Queue;
use common\models\Transactions;
use yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;

class PaymentController extends BaseController
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = Cors::settings();

        // re-add authentication filter
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpHeaderAuth::class,
                QueryParamAuth::class,
            ],
        ];
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options', 'get-pro-algos'];

        return $behaviors;
    }

    public function actionAdd()
    {


        $data = yii\helpers\Json::decode(Yii::$app->request->rawBody, false);

        $queue = Queue::findOne($data->queue_id);

        if (!$queue) {
            return $this->notFound();
        }

        if ($data->payment_duration == "once") {
            if ($queue->price != ((int)$data->cash_amount + (int)$data->card_amount)) {
                return $this->error([], "Summalar yetarli emas!");
            }
            $transaction = new Transactions([
                'user_id' => Yii::$app->user->id,
                'queue_id' => $queue->id,
                'client_id' => $queue->client->id,
                'amount' => $data->amount,
                'comment' => $data->comment,
                'cash' => $data->cash_amount,
                'card' => $data->card_amount,
                'datetime' => time()
            ]);
            if ($transaction->save()) {
                $queue->is_payed = Queue::PAYMENT_STATUS_PAYED;
                $queue->save();
                return $this->success($transaction);
            } else {
                return $this->error($transaction->errors, 'Malumotlarda xatolik', Error::VALIDATION_ERROR);
            }
        } elseif ($data->payment_duration == "long_time_payed") {
            $queue->is_payed_user = 1;
            $queue->is_payed = Queue::PAYMENT_STATUS_PAYED;
            $queue->save();
            return $this->success([], 'Successfully payed!');
        } else {
            return $this->error([], "Unknown error", Error::UNKNOWN_ERROR);
        }

    }
}