<?php


/* @var $this soft\web\View */
/* @var $model common\models\Speciality */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Specialities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'hospital_id', 
              'name', 
              'logo', 
              'status', 
        ],
    ]) ?>