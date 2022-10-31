<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $payment_type
 * @property int|null $client_id
 * @property string|null $client_fullname
 * @property string|null $client_phone
 * @property string|null $client_address
 * @property float|null $amount
 * @property int|null $delivery_type
 * @property float|null $delivery_price
 * @property int|null $network_id
 * @property int|null $status
 * @property int|null $order_type
 * @property string|null $credit_file
 * @property int|null $partner_order_id
 * @property int|null $is_deleted
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property array|null $order_products
 *
 * @property User $deletedBy
 */
class Orders extends \soft\db\ActiveRecord
{

    public $order_products;

    const STATUS_NEW = 1;
    const STATUS_DELIVERY = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_HAS_PROBLEM = 5;

    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['order_products', 'safe'],
            [['payment_type', 'client_id', 'delivery_type', 'network_id', 'status', 'order_type', 'partner_order_id', 'is_deleted', 'deleted_at', 'deleted_by', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'delivery_price'], 'number'],
            [['name', 'client_fullname', 'client_phone', 'client_address', 'credit_file'], 'string', 'max' => 255],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['deleted_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', "Kommentariya"),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'client_id' => Yii::t('app', 'Client ID'),
            'client_fullname' => Yii::t('app', 'Client Fullname'),
            'client_phone' => Yii::t('app', 'Client Phone'),
            'client_address' => Yii::t('app', 'Client Address'),
            'amount' => Yii::t('app', 'Amount'),
            'delivery_type' => Yii::t('app', 'Delivery Type'),
            'delivery_price' => Yii::t('app', 'Delivery Price'),
            'network_id' => Yii::t('app', 'Network ID'),
            'status' => Yii::t('app', 'Status'),
            'order_type' => Yii::t('app', 'Order Type'),
            'credit_file' => Yii::t('app', 'Credit File'),
            'partner_order_id' => Yii::t('app', 'Partner Order ID'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    //</editor-fold>


    public function createProductSales()
    {
        foreach ($this->order_products as $order_product) {

            $order_product['order_id'] = $this->id;

            if ($order_product['partner_shop_payed'] == "on") {
                $order_product['partner_shop_payed'] = 1;
            } else {
                $order_product['partner_shop_payed'] = 0;
            }
            $order_product_model = new ProductSales($order_product);
            $order_product_model->save();
        }
    }

    public static function getStatusList()
    {

        return [
            self::STATUS_NEW => t("Yangi"),
            self::STATUS_DELIVERY => t("Yetkazish jarayonida"),
            self::STATUS_DELIVERED => t("Yetkazib berilldi"),
            self::STATUS_CANCELLED => t("Bekor qilindi"),
            self::STATUS_HAS_PROBLEM => t("Muammoli"),
        ];

    }
    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'deleted_by']);
    }

    //</editor-fold>
}
