<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model common\models\Driver */

$this->title = Yii::t('site', 'Tahrirlash');
$this->params['breadcrumbs'][] = ['label' => 'Haydovchilar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->first_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

