<?php


/* @var $this soft\web\View */
/* @var $model common\models\Tariff */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tariffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'minimum_km', 
              'minimum_sum', 
              'km_sum', 
              'status', 
              'outra_city_km_sum', 
              'created_by', 
              'updated_by', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>