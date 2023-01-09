<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner_shops".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $email
 * @property int|null $is_deleted
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $pay_amount
 * @property int|null $currency
 * @property int|null $base_imported
 * @property int|null $base_order_sold
 * @property int|null $base_debt
 *
 * @property User $deletedBy
 */
class PartnerShops extends \soft\db\ActiveRecord
{

    public $pay_amount;
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_shops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['base_debt', 'base_order_sold', 'base_imported'], 'safe'],
            [['is_deleted', "pay_amount", "is_main", "currency", 'deleted_at', 'deleted_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'phone', 'address', 'email'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'email' => Yii::t('app', 'Email'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'is_main' => Yii::t('app', 'IS MAIN STORE'),
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'deleted_by']);
    }

    //</editor-fold>

    public function getMonthlySales($start = null, $end = null)
    {
//        if (!$start) {
//            $start = strtotime(date("Y-m-1 00:00:00"));
//        } else {
//            $start = strtotime($start);
//        }
//
//        if (!$end) {
//            $end = strtotime(date("Y-m-t 23:59:59"));
//        } else {
//            $end = strtotime($end);
//        }
        $productSales = ProductSales::find()
            ->joinWith("order")
//            ->andWhere(['>=', "orders.created_at", $start])
//            ->andWhere(['<=', "orders.created_at", $end])

            ->andWhere(['=', "product_sales.product_source", $this->id])
            ->andWhere(['!=', "orders.status", Orders::STATUS_CANCELLED])
            ->sum("product_sales.partner_shop_price*count");


        return $productSales;

    }

    public function getNotPayedSales()
    {
        $productSales = ProductSales::find()
            ->joinWith("order")
            ->andWhere(['=', "product_sales.product_source", $this->id])
            ->andWhere(['!=', "product_sales.partner_shop_payed", 1])
            ->andWhere(['!=', "orders.status", Orders::STATUS_CANCELLED])
            ->sum("product_sales.currency_partner_price*count");


        return $productSales;
    }

    public function getImportedAmount()
    {
        $productImportsUsd = ProductImports::find()
            ->andWhere(['partner_id' => $this->id])
            ->sum("import_price*quantity");
        $productImportsUzs = ProductImports::find()
            ->andWhere(['partner_id' => $this->id])
            ->sum("import_price_uzs*quantity");

        return [
            "usd" => $productImportsUsd,
            "uzs" => $productImportsUzs,
        ];
    }

    public function getPayedAmount()
    {
        $pays = PartnerShopPays::find()
            ->andWhere(['partner_shop_id' => $this->id])
            ->sum("amount");

        return $pays;
    }

    public function getDebtAmount()
    {
        return $this->getImportedAmount()['usd'] + $this->getNotPayedSales() - $this->getPayedAmount();
    }
}
