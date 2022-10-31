<?php

namespace common\services;

use common\interfaces\QueueInterface;

class QueueService
{
    private $queueService;

    public function __construct(QueueInterface $queueInterface)
    {
        $this->queueService = $queueInterface;
    }


    public function getUserHospitalSpecialities()
    {
        return $this->queueService->getUserHospitalSpecialities();
    }

    public function getClientSpecialities()
    {
        return $this->queueService->getClientSpecialities();
    }

    public function getUserHospitalSpecialityDoctors($speciality_id)
    {
        return $this->queueService->getUserHospitalSpecialityDoctors($speciality_id);
    }

    public function getHospitalDoctorQueues($id)
    {
        return $this->queueService->getHospitalDoctorQueues($id);
    }

    public function getHospitalDoctorTimes($id)
    {
        return $this->queueService->getHospitalDoctorTimes($id);
    }

    public function getQueueById($id)
    {
        return $this->queueService->getQueueById($id);
    }

    public function getClientQueues($client_id)
    {
        return $this->queueService->getClientQueues($client_id);
    }

    public function getClientDoctors()
    {
        return $this->queueService->getClientDoctors();
    }

}