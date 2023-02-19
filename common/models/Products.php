<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $price_usd
 * @property int|null $is_deleted
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $deletedBy
 */
class Products extends \soft\db\ActiveRecord
{


    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::class
        ]); // TODO: Change the autogenerated stub
    }

    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price_usd'], 'number'],
            [['is_deleted', 'deleted_at', 'deleted_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'price_usd' => Yii::t('app', 'Price Usd'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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

    public function getProductToStores()
    {
        return $this->hasMany(ProductImports::class, ["product_id" => "id"]);
    }

    public function getProductToSales()
    {
        return $this->hasMany(ProductSales::class, ["product_id" => "id"]);
    }


    public function getSalesCount()
    {
        $salesCount = ProductSales::find()
            ->joinWith("partnerShop")
            ->joinWith("order")
            ->andWhere(['product_sales.product_id' => $this->id])
            ->andWhere(['partner_shops.is_main' => 1])
            ->andWhere(["!=", 'orders.status', Orders::STATUS_CANCELLED])
            ->sum("count");

        return $salesCount;
    }

    public function salesCountWithoutOrder($id)
    {
        $salesCount = ProductSales::find()
            ->joinWith("partnerShop")
            ->joinWith("order")
            ->andWhere(['product_sales.product_id' => $this->id])
            ->andWhere(['partner_shops.is_main' => 1])
            ->andWhere(["!=", 'orders.status', Orders::STATUS_CANCELLED])
            ->andWhere(["!=", 'orders.id', $id])
            ->sum("count");

        return $salesCount;
    }

    //</editor-fold>

    public function getFullName()
    {
        $count = $this->getProductToStores()->sum("quantity") - $this->salesCount;
        return $this->name . " (Omborda {$count} ta qolgan)";
    }

    public function getPriceUsd()
    {
        return "{$this->price_usd} $";
    }

}
