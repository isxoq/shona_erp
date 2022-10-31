<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "hospital_speciality".
 *
 * @property int $id
 * @property int $hospital_id
 * @property string|null $name
 * @property string|null $logo
 * @property int|null $status
 */
class Speciality extends \soft\db\ActiveRecord
{
    public function fields()
    {
        return [
            'id',
            'name',
            'mobile_icon' => function ($model) {
                return Url::to($model->mobile_icon, true);
            },
            'logo_url' => function ($model) {
                return Url::to($model->logo, true);
            },
            'status',
            'description',
            'color',
            'background_color' => function ($model) {
                return "backgroud: $model->color";
            },
            'doctorsCount'
        ];
    }

    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hospital_speciality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [


            [['status'], 'integer'],
            [['name', 'description', 'mobile_icon', 'color', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'hospital_id' => Yii::t('app', 'Hospital ID'),
            'name' => Yii::t('app', 'Name'),
            'logo' => Yii::t('app', 'Logo'),
            'status' => Yii::t('app', 'Status'),
            'mobile_icon' => Yii::t('app', 'Mobile Icon SVG'),
        ];
    }

    //</editor-fold>
    public function getLogoUrl()
    {
        return $this->getThumbUploadUrl('logo', 'preview');
    }


    public function getSpecialityToHospital()
    {
        return $this->hasMany(DoctorToSpeciality::class, ['speciality_id' => 'id']);
    }

    public function getDoctors()
    {
        return $this->hasMany(Doctor::class, ['id' => 'doctor_id'])
            ->via('specialityToHospital');
    }

    public function getDoctorsCount()
    {
        return DoctorToSpeciality::find()
            ->andWhere(['speciality_id' => $this->id])
            ->andWhere(['hospital_id' => user('hospital_id')])
            ->count();
    }
}
