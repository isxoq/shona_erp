<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "queue_state".
 *
 * @property int $id
 * @property int|null $queue_id
 * @property int|null $doctor_id
 * @property int|null $state
 * @property int|null $datetime
 * @property string|null $description
 */
class QueueState extends \soft\db\ActiveRecord

{

    const STATE_WAITING = Queue::STATUS_WAITING;
    const STATE_IN_DOCTOR = Queue::STATUS_IN_DOCTOR;
    const STATE_END = Queue::STATUS_END;
    const STATUS_CANCELLED = Queue::STATUS_CANCELLED;

    public function fields()
    {
        return [
            "id",
            "doctor_id",
            "state",
            "stateName",
            "datetime" => function (self $model) {
                return date("d.m.Y h:i:s", $model->datetime);
            },
            "description"
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                "class" => TimestampBehavior::class,
                "createdAtAttribute" => "datetime",
                "updatedAtAttribute" => false,
            ]
        ]);
    }
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue_state';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['queue_id', 'doctor_id', 'state', 'datetime'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'queue_id' => Yii::t('app', 'Queue ID'),
            'doctor_id' => Yii::t('app', 'Doctor ID'),
            'state' => Yii::t('app', 'State'),
            'datetime' => Yii::t('app', 'Datetime'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public static function states()
    {
        return [
            self::STATE_WAITING => t("Kutishda"),
            self::STATE_IN_DOCTOR => t("Doctor qabulida"),
            self::STATE_END => t("Tugatildi"),
        ];
    }

    public function getstateName()
    {
        return self::states()[$this->state];
    }

    //</editor-fold>

}
