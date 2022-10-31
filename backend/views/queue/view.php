<?php


/* @var $this soft\web\View */
/* @var $model common\models\Queue */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Queues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'doctor_id', 
              'patient_id', 
              'date', 
              'time', 
              'first_name', 
              'last_name', 
              'father_name', 
              'birth_date', 
              'gender', 
              'province_id', 
              'region_id', 
              'address', 
              'phone', 
              'type', 
              'sale', 
              'old_price', 
              'price', 
              'is_payed', 
              'description', 
              'status', 
        ],
    ]) ?>