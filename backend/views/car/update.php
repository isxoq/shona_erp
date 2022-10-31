<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model common\models\Car */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mashinalar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->driver->fullName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

