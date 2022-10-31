<?php


/* @var $this soft\web\View */
/* @var $model common\models\DeliveryTypes */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Delivery Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'name', 
              'is_deleted', 
              'deleted_at', 
              'deleted_by', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>