<?php

namespace common\interfaces;
interface QueueInterface
{
    public function getUserHospitalSpecialities();

    public function getUserHospitalSpecialityDoctors(int $speciality_id);

    public function getHospitalDoctorQueues(int $id);

    public function getHospitalDoctorTimes(int $id);

    public function addHospitalQueue($data);

    public function getQueueById($id);

    public function getClientSpecialities();

    public function getClientQueues($client_id);

    public function getClientDoctors();


}