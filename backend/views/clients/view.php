<?php


/* @var $this soft\web\View */
/* @var $model common\models\Clients */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'full_name', 
              'phone', 
              'address', 
              'is_deleted', 
              'deleted_at', 
              'deleted_by', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>