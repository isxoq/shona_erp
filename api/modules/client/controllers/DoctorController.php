<?php

namespace api\modules\client\controllers;
# User: isxoq
# Date: 24.09.2021
# Time: 6:38
# Year: 2021
# Project: tashxis.loc
# Full Name: Isxoqjon Axmedov
# Phone: +998936448111

use common\models\Doctor;
use soft\helpers\ArrayHelper;
use yii\helpers\Json;

class DoctorController extends BaseController
{


    public function actionView($id)
    {
        $doctor = \common\models\Doctor::findOne($id);
        return $this->success($doctor);
    }

    public function actionAcceptDays($id)
    {
        $doctor = \common\models\Doctor::findOne($id);

        $work_days = Json::decode($doctor->work_days);

        $days = [];
        $today = new \DateTime();
        $end = new \DateTime("+1 week");

        for ($i = $today; $i <= $end; $i->modify('+1 day')) {
            if (in_array(date('w', strtotime($i->format('d.m.Y'))), $work_days)) {
                $days[] = [
                    'weekday' => weekDay(date('N', $i->getTimestamp())),
                    'date' => $i->format('d.m.Y')
                ];
            }
        }

        return $this->success($days);
    }

    public function actionAcceptTimes($id)
    {
        $doctor = \common\models\Doctor::findOne($id);

        $accept_times = Json::decode($doctor->accept_times);

        return $this->success($accept_times);
    }

    public function actionNearestDoctors()
    {
        $data = Json::decode(\Yii::$app->request->rawBody, false);

        $lat = $data->lat;
        $long = $data->long;
        $distance = $data->distance;

        $sql = "SELECT * FROM ( SELECT*,
        (
            (
                (
                    ACOS(
                        SIN(($lat * PI() / 180)) * SIN((`lat` * PI() / 180)) + COS(($lat * PI() / 180)) * COS((`lat` * PI() / 180)) * COS(
                            (
                                ($long - `long`) * PI() / 180)
                            )
                        )) * 180 / PI()) * 60 * 1.1515 * 1.609344) AS distance
                    FROM
                        hospital)
        hospital WHERE distance <=$distance";

        $query = \Yii::$app->db->createCommand($sql);

        $hospital_ids = ArrayHelper::getColumn($query->queryAll(), 'id');

        $query = Doctor::find();
        $doctors = $query->andWhere(['in', 'hospital_id', $hospital_ids])
            ->all();


        return $this->success($doctors);


    }
}