<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_sales".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property float|null $sold_price
 * @property int|null $product_source
 * @property float|null $partner_shop_price
 * @property int|null $partner_shop_payed
 * @property int|null $is_deleted
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $deletedBy
 */
class ProductSales extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_sales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', "count", 'product_id', 'product_source', 'partner_shop_payed', 'is_deleted', 'deleted_at', 'deleted_by', 'created_at', 'updated_at'], 'integer'],
            [['sold_price', 'partner_shop_price'], 'number'],
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
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'sold_price' => Yii::t('app', 'Sold Price'),
            'product_source' => Yii::t('app', 'Product Source'),
            'partner_shop_price' => Yii::t('app', 'Partner Shop Price'),
            'partner_shop_payed' => Yii::t('app', 'Partner Shop Payed'),
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

    //</editor-fold>
}
