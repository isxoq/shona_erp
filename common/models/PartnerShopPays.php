<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "partner_shop_pays".
 *
 * @property int $id
 * @property int|null $partner_shop_id
 * @property int|null $amount
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class PartnerShopPays extends \soft\db\ActiveRecord
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
        return 'partner_shop_pays';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner_shop_id', 'created_at', 'updated_at'], 'integer'],
            ['amount', "safe"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => 'ID',
            'partner_shop_id' => 'Partner Shop ID',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    //</editor-fold>

}
