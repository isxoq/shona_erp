<?php

namespace common\repositories;

use common\interfaces\QueueInterface;
use common\models\Doctor;
use common\models\DoctorToSpeciality;
use common\models\Queue;
use common\models\Speciality;
use common\models\User;
use common\models\WorkTimes;
use common\resources\HomeDoctor;
use common\resources\HomeQueue;
use DateInterval;
use DatePeriod;
use DateTime;
use yii;

class QueueRepository implements QueueInterface
{

    public function getUserHospitalSpecialities()
    {
        $hospital_id = user('hospital_id');
        $specialityIds = \Yii::$app->db->createCommand("SELECT DISTINCT(speciality_to_doctor.speciality_id) FROM `speciality_to_doctor`
CROSS JOIN hospital_speciality
WHERE speciality_to_doctor.hospital_id={$hospital_id}")->queryColumn('speciality_id');
        $specialities = Speciality::find()
            ->andWhere(['in', 'id', $specialityIds])
            ->all();

        return $specialities;

    }

    public function getUserHospitalSpecialityDoctors($speciality_id)
    {

        $speciality = Speciality::findOne($speciality_id);
        $hospital_id = user('hospital_id');
        $user_type = User::TYPE_DOCTOR;
        $doctorIds = \Yii::$app->db->createCommand("SELECT DISTINCT(speciality_to_doctor.doctor_id) FROM `speciality_to_doctor`
CROSS JOIN user
WHERE user.type_id = {$user_type} AND speciality_to_doctor.hospital_id={$hospital_id} AND speciality_to_doctor.speciality_id={$speciality_id}")->queryColumn('doctor_id');

        $doctors = Doctor::find()
            ->andWhere(['in', 'id', $doctorIds])
            ->all();

        return [
            'doctors' => $doctors,
            'speciality' => $speciality,
        ];
    }

    public function getHospitalDoctorQueues(int $id)
    {
        $doctor = Doctor::findOne($id);
        $queuesPayWaiting = Queue::find()
            ->andWhere(['is_payed' => Queue::PAYMENT_STATUS_WAITING])
            ->andWhere(['status' => Queue::STATUS_WAITING])
            ->andWhere(['doctor_id' => $id])
            ->andWhere(['hospital_id' => \user('hospital_id')])
            ->orderBy([
                'queue_number' => SORT_ASC,
            ])
            ->andWhere(['=', 'date', date('Y-m-d')])
            ->all();

        $queuesPayed = Queue::find()
            ->andWhere(['is_payed' => Queue::PAYMENT_STATUS_PAYED])
            ->andWhere(['not in', 'status', [Queue::STATUS_CANCELLED, Queue::STATUS_END]])
            ->andWhere(['doctor_id' => $id])
            ->andWhere(['hospital_id' => \user('hospital_id')])
            ->orderBy([
                'queue_number' => SORT_ASC,
            ])
            ->andWhere(['=', 'date', date('Y-m-d')])
            ->all();

        return [
            'payWaitingQueues' => $queuesPayWaiting,
            'payedQueues' => $queuesPayed,
            'doctor' => $doctor
        ];
    }

    public function getHospitalDoctorTimes(int $id)
    {

        try {
            $doctor = Doctor::findOne($id);
            $specialityToDoctor = DoctorToSpeciality::find()
                ->andWhere(['hospital_id' => \user('hospital_id')])
                ->andWhere(['doctor_id' => $id])
                ->one();
            $workTime = WorkTimes::find()
                ->andWhere(['date' => date("Y-m-d")])
                ->andWhere(['active' => 1])
                ->one();
            if (!$workTime) {
                return false;
            }
            $queuesArray = [];
            $begin = new DateTime(date("Y-m-d {$workTime->begin}"));
            $end = new DateTime(date("Y-m-d {$workTime->end}"));
            $interval = DateInterval::createFromDateString("{$specialityToDoctor->average_accept_time} minute");
            $period = new DatePeriod($begin, $interval, $end);
            $j = 1;
            foreach ($period as $time) {
                $timeOfDay = $time->format('H:i');
                $timeOfDay1 = $time->add(new DateInterval("PT{$specialityToDoctor->average_accept_time}M"))->format('H:i');
                if ($workTime->lunch_begin <= $timeOfDay && $timeOfDay < $workTime->lunch_end) {
                    continue;
                }

                $queue = Queue::find()
                    ->andWhere(['queue_number' => $j])
                    ->andWhere(['hospital_id' => \user('hospital_id')])
                    ->andWhere(['date' => date("Y-m-d")])
                    ->one();

                $queuesArray[] = [
                    'id' => $j++,
                    'empty' => !$queue,
                    'state' => $queue->status,
                    'is_payed' => $queue->is_payed,
                    'apx_begin_time' => $timeOfDay,
                    'apx_end_time' => $timeOfDay1,
                ];
            }
            return [
                'times' => $queuesArray,
                'work_time' => $workTime->begin . " - " . $workTime->end
            ];
        } catch (\Exception $e) {
            return false;
        }
    }

    public function addHospitalQueue($data)
    {
        $doctor = \hospital\models\Doctor::findOne($data->doctor_id);
        $phone = clearPhone($data->phone);

        if (!$data->phone || !$data->province || !$data->region || !$data->birth_date || !$data->doctor_id || !$data->queue_number || !$data->gender || !$data->first_name || !$data->last_name) {
            return [
                'error' => true,
                'message' => t("Maydonlarning hammasini to'ldiring!")
            ];
        }

        $queue = Queue::findOne([
            'queue_number' => $data->queue_number,
            'hospital_id' => \user('hospital_id'),
            'date' => date('Y-m-d')
        ]);

        if ($queue) {
            return [
                'error' => true,
                'message' => t("Ushbu navbat band qilingan!")
            ];
        }

        $availableDoctorTimes = $this->getHospitalDoctorTimes($data->doctor_id);

        if (!in_array($data->queue_number, yii\helpers\ArrayHelper::getColumn($availableDoctorTimes['times'], 'id'))) {

            return [
                'error' => true,
                'message' => t("Navbat mavjud emas!")
            ];
        } else {

            $apxBeginTime = yii\helpers\ArrayHelper::map($availableDoctorTimes['times'], 'id', 'apx_begin_time')[$data->queue_number];
            $isEmpty = yii\helpers\ArrayHelper::map($availableDoctorTimes['times'], 'id', 'empty')[$data->queue_number];


            if (!$isEmpty) {
                return [
                    'error' => true,
                    'message' => t("Navbatga yozilib bo'lmaydi!")
                ];
            }
        }


        $patient = \hospital\modules\usermanager\models\User::findClientByPhone($phone);
        if (!$patient) {
            $patient = new User();
            $patient->first_name = $data->first_name;
            $patient->last_name = $data->last_name;
            $patient->father_name = $data->father_name;
            $patient->phone = $phone;
            $patient->province_id = $data->province;
            $patient->region_id = $data->region;
            $patient->birth_date = date("Y-m-d", strtotime($data->birth_date));
            $patient->generateAuthKey();
            $patient->setPassword("12345678");
            $patient->type_id = User::TYPE_CLIENT;
            $patient->gender = $data->gender;
            $patient->username = $phone;
            if (!$patient->save()) {
                return $patient->errors;
            }
        }

        $queue = new Queue();
        $queue->queue_number = $data->queue_number;
        $queue->patient_id = $patient->id;
        $queue->type = Queue::TYPE_RECEPTION;
        $queue->price = $doctor->acceptance_amount;
        $queue->doctor_id = $data->doctor_id;
        $queue->is_payed = Queue::PAYMENT_STATUS_WAITING;
//        $queue->payment_type = Queue::PA;
        $queue->hospital_id = \user('hospital_id');
        $queue->status = Queue::STATUS_WAITING;
        $queue->date = date('Y-m-d');
        $queue->time = $apxBeginTime;
        $queue->created_at = time();

        $queue->first_name = $data->first_name;
        $queue->last_name = $data->last_name;
        $queue->father_name = $data->father_name;
        $queue->phone = $data->phone;

        $queue->save();

        return $queue;
    }

    public function getClientSpecialities()
    {

        $specialities = Speciality::find()
            ->all();

        return $specialities;
    }

    public function getQueueById($id)
    {
        $queue = Queue::findOne($id);
        return $queue;
    }

    public function getClientQueues($client_id)
    {
        $queuesWaiting = HomeQueue::find()
            ->andWhere(['status' => Queue::STATUS_WAITING])
            ->andWhere(['patient_id' => $client_id])
            ->andWhere(['=', 'date', date('Y-m-d')])
            ->all();

        return $queuesWaiting;
    }

    public function getClientDoctors()
    {
        $doctors = HomeDoctor::find()
            ->andWhere(['status' => User::STATUS_ACTIVE])
            ->andWhere(['type_id' => User::TYPE_DOCTOR])
            ->limit(10)
            ->all();

        return $doctors;
    }
}