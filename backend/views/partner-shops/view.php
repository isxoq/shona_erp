<?php


/* @var $this soft\web\View */
/* @var $model common\models\PartnerShops */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partner Shops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'name', 
              'phone', 
              'address', 
              'email', 
              'is_deleted', 
              'deleted_at', 
              'deleted_by', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>