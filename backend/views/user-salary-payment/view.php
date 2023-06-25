<?php


/* @var $this soft\web\View */
/* @var $model common\models\UserSalaryPayment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Salary Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'user_id', 
              'date', 
              'amount', 
              'payment_type', 
              'comment', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>