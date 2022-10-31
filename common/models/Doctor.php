<?php

namespace common\models;

use backend\models\Hospital;
use mohorev\file\UploadImageBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string|null $image
 * @property int|null $type_id
 * @property string|null $father_name
 * @property string|null $birth_date
 * @property int|null $gender
 * @property int|null $province_id
 * @property int|null $region_id
 * @property int|null $hospital_id
 * @property string|null $jshshir
 * @property int|null $quarter_id
 * @property int|null $work_year
 * @property string|null $study
 * @property string|null $achievements
 * @property int|null $acceptance_amount
 * @property int|null $speciality_id
 *
 * @property Car[] $cars
 * @property Car[] $cars0
 * @property Car[] $cars1
 * @property Client[] $clients
 * @property Client[] $clients0
 * @property Order[] $orders
 * @property Order[] $orders0
 * @property Order[] $orders1
 * @property Tariff[] $tariffs
 * @property Tariff[] $tariffs0
 */
class Doctor extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    public function behaviors()
    {
        return [
            [
                'class' => UploadImageBehavior::class,
                'attribute' => 'image',
                'deleteOriginalFile' => true,
                'scenarios' => ['default'],
                'path' => '@frontend/web/uploads/images/doctor/{id}',
                'url' => '/uploads/images/doctor/{id}',
                'thumbs' => [
                    'preview' => ['width' => 250],
                ],
            ],
            [
                'class' => TimestampBehavior::class
            ]
        ];
    }

    public function fields()
    {
        return [
            'id',
            'is_active' => function ($model) {
                return rand(0, 1);
            },
            'first_name',
            'last_name',
            'father_name',
            'phone',
            'imageUrl' => function ($model) {
                return Yii::$app->request->hostInfo . $model->imageUrl;
            },
            'age' => function ($model) {
                return 25;
            },
            'rate',
            'languages' => function ($model) {
                return "O'zbek tili, Rus tili";
            },
            'patients',
            'speciality',
            'acceptance_amount',
            'distance',
            'study',
            'work_history' => 'study',
            'achievements',
            'work_year',
            'province',
            'region',
            'quarter',
            'hospital',
            "queues_count" => "activeQueuesCount",
            'accept_days' => function ($model) {
                return "Dushanba - Shanba";
            },
            'accept_times' => function ($model) {
                return "09:00 - 18:00";
            },
            'doctor_comment' => function ($model) {
                $i = rand(0, 1);
                if ($i) {
                    return "Soat 15:00 larga borib qabulni boshlayman zarur ishlarim chiqib qoldi.";
                } else {
                    return "";
                }
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash', 'created_at', 'updated_at'], 'safe'],
            [['status', 'created_at', 'updated_at', 'type_id', 'gender', 'province_id', 'region_id', 'hospital_id', 'quarter_id', 'work_year', 'acceptance_amount', 'speciality_id'], 'integer'],
            [['birth_date'], 'safe'],
            [['study', 'achievements'], 'string'],
            [['username', 'first_name', 'last_name', 'phone'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'image', 'father_name', 'jshshir'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'phone' => Yii::t('app', 'Phone'),
            'image' => Yii::t('app', 'Image'),
            'type_id' => Yii::t('app', 'Type ID'),
            'father_name' => Yii::t('app', 'Father Name'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'gender' => Yii::t('app', 'Gender'),
            'province_id' => Yii::t('app', 'Province ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'hospital_id' => Yii::t('app', 'Hospital ID'),
            'jshshir' => Yii::t('app', 'Jshshir'),
            'quarter_id' => Yii::t('app', 'Quarter ID'),
            'work_year' => Yii::t('app', 'Work Year'),
            'study' => Yii::t('app', 'Study'),
            'achievements' => Yii::t('app', 'Achievements'),
            'acceptance_amount' => Yii::t('app', 'Acceptance Amount'),
            'speciality_id' => Yii::t('app', 'Speciality ID'),
        ];
    }

    //</editor-fold>
    public function getImageUrl()
    {
        return $this->getThumbUploadUrl('image', 'preview');
    }

    public function getRate()
    {
        return 4;
    }

    public function getPatients()
    {
        return 10;
    }

    public function getSpeciality()
    {
        return $this->hasOne(Speciality::class, ['id' => 'speciality_id']);
    }

    public function getDistance()
    {
        return 2.3;
    }

    public function getProvince()
    {
        return $this->hasOne(Regions::class, ['id' => 'province_id']);
    }

    public function getRegion()
    {
        return $this->hasOne(Districts::class, ['id' => 'region_id']);
    }

    public function getQuarter()
    {
        return $this->hasOne(Regions::class, ['id' => 'quarter_id']);
    }

    public function getHospital()
    {
        return $this->hasOne(Hospital::class, ['id' => 'hospital_id']);
    }

    public function getDoctorToSpeciality()
    {
        return $this->hasMany(DoctorToSpeciality::class, ['doctor_id' => 'id']);
    }

    public function getActiveQueues()
    {
        return Queue::find()
            ->andWhere(['doctor_id' => $this->id])
            ->andWhere(['status' => Queue::STATUS_WAITING])
            ->all();
    }

    public function getActiveQueuesCount()
    {
        return Queue::find()
            ->andWhere(['doctor_id' => $this->id])
            ->andWhere(['status' => Queue::STATUS_WAITING])
            ->count();
    }

    public function getNameForSearch()
    {
        return $this->first_name . " " . $this->last_name . " " . $this->phone;
    }
}
