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
use api\controllers\BaseController;
use common\models\Queue;
use common\repositories\QueueRepository;
use common\repositories\UserRepository;
use yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;

class QueueController extends BaseController
{
    private $queueRepository;
    private $userRepository;

    public function __construct($id, $module, QueueRepository $queueService, UserRepository $userRepository, $config = [])
    {
        $this->queueRepository = $queueService;
        $this->userRepository = $userRepository;

        parent::__construct($id, $module, $config);
    }

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

    public function actionGetSpecialities()
    {
        $specialities = $this->queueRepository->getUserHospitalSpecialities();
        return $this->success($specialities);
    }

    public function actionGetDoctorQueues($id)
    {
        $doctors = $this->queueRepository->getHospitalDoctorQueues($id);
        return $this->success($doctors);
    }

    public function actionGetDoctorTimes($id)
    {
        $times = $this->queueRepository->getHospitalDoctorTimes($id);
        return $this->success($times);
    }

    public function actionGetSpecialityDoctors($speciality_id)
    {
        $specialities = $this->queueRepository->getUserHospitalSpecialityDoctors($speciality_id);
        return $this->success($specialities);
    }

    public function actionAdd()
    {
        $data = yii\helpers\Json::decode(Yii::$app->request->rawBody, false);

        $queue = $this->queueRepository->addHospitalQueue($data);
        if (!$queue['error']) {
            return $this->success($queue);
        } else {
            return $this->error([], $queue['message']);
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

    public function actionGetPatient($id)
    {
        $patient = $this->userRepository->getPatientsById($id);
        if ($patient) {
            return $this->success($patient);
        } else {
            return $this->error([], t("Bunday ID li bemor topilmadi."));
        }
    }

    public function actionGetQueue($id)
    {
        $queue = $this->queueRepository->getQueueById($id);
        if ($queue) {
            return $this->success($queue);
        } else {
            return $this->error([], t("Bunday navbat mavjud emas."));
        }
    }
}