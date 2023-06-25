<?php


/* @var $this soft\web\View */
/* @var $model common\models\UserSalary */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'user_id', 
              'month', 
              'year', 
              'amount', 
              'comment', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>