<?php


/* @var $this soft\web\View */
/* @var $model common\models\UserRevenue */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Revenues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'order_id', 
              'user_id', 
              'amount', 
              'comment', 
              'type', 
              'status', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>