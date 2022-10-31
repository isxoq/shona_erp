<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_states".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $user_id
 * @property int|null $state_id
 * @property int|null $is_deleted
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $deletedBy
 */
class OrderStates extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'order_states';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'state_id', 'is_deleted', 'deleted_at', 'deleted_by', 'created_at', 'updated_at'], 'integer'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'state_id' => Yii::t('app', 'State ID'),
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
