<?php


/* @var $this soft\web\View */
/* @var $model common\models\UserFine */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Fines'), 'url' => ['index']];
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
              'created_at', 
              'updated_at', 
        ],
    ]) ?>