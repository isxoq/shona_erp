<?php

namespace common\models;

use common\models\behaviour\QueueBehavior;
use hospital\models\Hospital;
use Yii;

/**
 * This is the model class for table "queue".
 *
 * @property int $id
 * @property int|null $doctor_id
 * @property int|null $patient_id
 * @property string|null $date
 * @property string|null $time
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $father_name
 * @property string|null $birth_date
 * @property int|null $gender
 * @property int|null $province_id
 * @property int|null $region_id
 * @property string|null $address
 * @property string|null $phone
 * @property int|null $type
 * @property int|null $sale
 * @property int|null $old_price
 * @property int|null $price
 * @property int|null $is_payed
 * @property int|null $created_at
 * @property string|null $description
 * @property int|null $status
 * @property int|null $is_payed_user // Bu oylik tolovda ishlatiladi
 * @property int|null $queue_number
 */
class Queue extends \soft\db\ActiveRecord
{


    //<editor-fold desc="Parent" defaultstate="collapsed">

    const STATUS_WAITING = 1;
    const STATUS_IN_DOCTOR = 2;
    const STATUS_END = 3;
    const STATUS_CANCELLED = 4;


    const PAYMENT_TYPE_CASH = 1;
    const PAYMENT_TYPE_CLICK = 2;
    const PAYMENT_TYPE_PAYME = 3;

    const PAYMENT_STATUS_WAITING = 9;
    const PAYMENT_STATUS_PAYED = 10;

    const TYPE_TASHXIS = 1;
    const TYPE_RECEPTION = 2;


    public function fields()
    {
        return [

            'id',
            "patient_id",
            "is_payed_user",
            "queue_number",
            "price",
            "total_payed_price" => function ($model) {
                $total = $model->getPayments()->sum('cash');
                $total += $model->getPayments()->sum('card');
                return $total;
            },
            "f_total_payed_price" => function ($model) {
                $total = $model->getPayments()->sum('cash');
                $total += $model->getPayments()->sum('card');
                return Yii::$app->formatter->asSum($total);
            },
            "is_payed",
            "payments",
            "has_long_term" => function ($model) {
                return true;
            },
            "has_long_term_price" => function ($model) {
                return Yii::$app->formatter->asSum(240000);
            },
            "f_price" => function ($model) {
                return Yii::$app->formatter->asSum($model->price);
            },
            'doctor_image' => function ($model) {
                return Yii::$app->request->hostInfo . $model->doctor->imageUrl;
            },
            'patient_image' => function ($model) {
                return Yii::$app->request->hostInfo . $model->doctor->imageUrl;
            },

            'client_province' => function ($model) {
                return $model->client->province->name;
            },

            'client_region' => function ($model) {
                return $model->client->region->name;
            },
            'client_birth_date' => function ($model) {
                return date("d.m.Y", strtotime($model->client->birth_date));
            },


            'doctor_first_name' => function ($model) {
                return $model->doctor->first_name;
            },
            'doctor_last_name' => function ($model) {
                return $model->doctor->last_name;
            },
            'doctor_speciality' => function ($model) {
                return $model->doctor->speciality->name;
            },
            'doctor_address' => function ($model) {
                return $model->doctor->hospital->address;
            },
            'date',
            'time',
            "type",
            "created_at",
            "first_name",
            "last_name",
            "father_name",
            "phone",
            'age' => function ($model) {
                return $model->client->age;
            },
            'gender' => function ($model) {
                return $model->client->gender;
            },
            "states",
            'hospital',
            'diagnostic_results' => function ($model) {
                return [
                    [
                        'question' => "Siz kimsiz?",
                        'answer' => "Isxoqjon Axmedov",
                    ],

                    [
                        'question' => "Ho'p qayeringiz og'riyapti?",
                        'answer' => "Boshim",
                    ],

                    [
                        'question' => "Isitma bormi?",
                        'answer' => "Xa",
                    ],

                    [
                        'question' => "Tam bilyapsizmi?",
                        'answer' => "Yo'q",
                    ],

                    [
                        'question' => "Hid sezyapsizmi?",
                        'answer' => "Yo'q",
                    ],
                ];
            },
            "suspected_disease" => function ($model) {
                return "Koronavirus";
            },
            "rate_disease" => function ($model) {
                return 3;
            },
            "status"

        ]; // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            "class" => QueueBehavior::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["ai_diagnosis_state", "doctor_comment", "queue_number"], 'safe'],
            [['doctor_id', 'is_payed_user', 'created_at', 'patient_id', 'hospital_id', 'gender', 'province_id', 'region_id', 'type', 'sale', 'old_price', 'price', 'is_payed', 'status', 'payment_type'], 'integer'],
            [['date', 'time', 'birth_date'], 'safe'],
            [['address', 'description'], 'string'],
            [['first_name', 'last_name', 'father_name', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'doctor_id' => Yii::t('app', 'Doctor ID'),
            'patient_id' => Yii::t('app', 'Patient ID'),
            'date' => Yii::t('app', 'Date'),
            'time' => Yii::t('app', 'Time'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'father_name' => Yii::t('app', 'Father Name'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'gender' => Yii::t('app', 'Gender'),
            'province_id' => Yii::t('app', 'Province ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'address' => Yii::t('app', 'Address'),
            'phone' => Yii::t('app', 'Phone'),
            'type' => Yii::t('app', 'Type'),
            'sale' => Yii::t('app', 'Sale'),
            'old_price' => Yii::t('app', 'Old Price'),
            'price' => Yii::t('app', 'Price'),
            'is_payed' => Yii::t('app', 'Is Payed'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'doctor_comment' => Yii::t('app', 'Doctor Comment'),
            'ai_diagnosis_state' => Yii::t('app', 'AI Diagnosis true'),
            'is_payed_user' => Yii::t('app', 'is_payed_user'),
        ];
    }

    //</editor-fold>

    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['id' => 'doctor_id']);
    }

    public function getHospital()
    {
        return $this->hasOne(Hospital::class, ['id' => 'hospital_id']);
    }

    public function getStates()
    {
        return $this->hasMany(QueueState::class, ['queue_id' => "id"]);
    }

    public function changeStatus($id, $description = "")
    {
        $this->status = $id;
        $this->save();

        $queueState = new QueueState([
            "queue_id" => $this->id,
            "doctor_id" => $this->doctor_id,
            "state" => $id,
            "description" => $description,
        ]);
        $queueState->save();
    }

    public static function findDoctorQueue($id)
    {
        return self::find()
            ->andWhere(['id' => $id])
            ->andWhere(['doctor_id' => Yii::$app->user->id]);
    }

    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'patient_id']);
    }

    public function getPayments()
    {
        return $this->hasMany(Transactions::class, ['queue_id' => 'id']);
    }

}
