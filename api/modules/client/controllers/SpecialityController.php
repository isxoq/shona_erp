<?php

namespace api\modules\client\controllers;
# User: isxoq
# Date: 23.09.2021
# Time: 7:56
# Year: 2021
# Project: tashxis.loc
# Full Name: Isxoqjon Axmedov
# Phone: +998936448111


use common\models\Doctor;
use common\models\User;
use common\repositories\QueueRepository;

class SpecialityController extends BaseController
{

    private $queueRepository;


    public function __construct($id, $module, QueueRepository $queueService, $config = [])
    {
        $this->queueRepository = $queueService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $specialities = $this->queueRepository->getClientSpecialities();
        return $this->success($specialities);
    }

    public function actionDoctors($speciality_id)
    {
        $doctors = Doctor::find()
            ->andWhere(['speciality_id' => $speciality_id])
            ->andWhere(['status' => User::STATUS_ACTIVE])
            ->all();

        return $this->success($doctors);
    }
}