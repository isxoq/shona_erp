<?php

namespace common\models;

use soft\helpers\Html;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_fine".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $user_id
 * @property float|null $amount
 * @property string|null $comment
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class UserFine extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::class
        ]); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_fine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'amount' => Yii::t('app', 'Amount'),
            'comment' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    //</editor-fold>


    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => "user_id"]);
    }

    public function getOrderUrl()
    {
        return Html::a($this->order_id, ["/orders/update", "id" => $this->order_id], [
            "target" => "_blank",
            "data-pjax" => 0
        ]);
    }

}