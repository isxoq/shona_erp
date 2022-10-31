<?php


/* @var $this soft\web\View */
/* @var $model backend\models\HospitalAdmin */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hospital Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'username', 
              'auth_key', 
              'password_hash', 
              'password_reset_token', 
              'email', 
              'status', 
              'created_at', 
              'updated_at', 
              'first_name', 
              'last_name', 
              'phone', 
              'image', 
              'type_id', 
              'father_name', 
              'birth_date', 
              'gender', 
              'province_id', 
              'region_id', 
        ],
    ]) ?>