<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner_fees".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $payment_type
 * @property float|null $amount
 */
class PartnerFees extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'partner_fees';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['order_id', 'payment_type'], 'integer'],
            [['amount'], 'number'],
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
            'payment_type' => Yii::t('app', 'Payment Type'),
            'amount' => Yii::t('app', 'Amount'),
        ];
    }
    //</editor-fold>

}
