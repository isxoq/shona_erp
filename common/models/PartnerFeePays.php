<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner_fee_pays".
 *
 * @property int $id
 * @property int|null $partner_id
 * @property float|null $amount
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class PartnerFeePays extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'partner_fee_pays';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['partner_id', 'created_at', 'updated_at'], 'integer'],
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
            'partner_id' => Yii::t('app', 'Partner ID'),
            'amount' => Yii::t('app', 'Amount'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    //</editor-fold>

}
