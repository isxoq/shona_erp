<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_times".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $date
 * @property string|null $begin
 * @property string|null $end
 * @property string|null $lunch_begin
 * @property string|null $lunch_end
 * @property string|null $extra_non_times
 * @property int|null $active
 */
class WorkTimes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_times';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'active'], 'integer'],
            [['date'], 'safe'],
            [['extra_non_times'], 'string'],
            [['begin', 'end', 'lunch_begin', 'lunch_end'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'date' => Yii::t('app', 'Date'),
            'begin' => Yii::t('app', 'Begin'),
            'end' => Yii::t('app', 'End'),
            'lunch_begin' => Yii::t('app', 'Lunch Begin'),
            'lunch_end' => Yii::t('app', 'Lunch End'),
            'extra_non_times' => Yii::t('app', 'Extra Non Times'),
            'active' => Yii::t('app', 'Active'),
        ];
    }
}
