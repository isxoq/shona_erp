<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_imports".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $partner_id
 * @property float|null $import_price
 * @property float|null $currency_price
 * @property float|null $import_price_uzs
 * @property int|null $quantity
 * @property int|null $is_deleted
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $deletedBy
 */
class ProductImports extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_imports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'partner_id', 'quantity', 'is_deleted', 'deleted_at', 'deleted_by', 'created_at', 'updated_at'], 'integer'],
            [['import_price', 'currency_price', 'import_price_uzs'], 'number'],
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
            'product_id' => Yii::t('app', 'Product ID'),
            'partner_id' => Yii::t('app', 'Partner ID'),
            'import_price' => Yii::t('app', 'Import Price'),
            'currency_price' => Yii::t('app', 'Currency Price'),
            'import_price_uzs' => Yii::t('app', 'Import Price Uzs'),
            'quantity' => Yii::t('app', 'Quantity'),
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


    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => "product_id"]);
    }

    public function getPartner()
    {
        return $this->hasOne(PartnerShops::class, ['id' => "partner_id"]);
    }
    //</editor-fold>
}