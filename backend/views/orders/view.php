<?php


/* @var $this soft\web\View */
/* @var $model common\models\Orders */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'name', 
              'payment_type', 
              'client_id', 
              'client_fullname', 
              'client_phone', 
              'client_address', 
              'amount', 
              'delivery_type', 
              'delivery_price', 
              'network_id', 
              'status', 
              'order_type', 
              'credit_file', 
              'partner_order_id', 
              'is_deleted', 
              'deleted_at', 
              'deleted_by', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>