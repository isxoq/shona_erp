<?php


/* @var $this soft\web\View */
/* @var $model common\models\Car */

$this->title = $model->number;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mashinalar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'panel' => $this->isAjax ? false : [],
    'attributes' => [
        [
            'attribute' => 'imageUrl',
            'label' => Yii::t('app', 'Rasm'),
            'format' => ['image', ['width' => '60px']]
        ],
        [
            'attribute' => 'driver.fullName',
            'label' => 'Haydovchi F.I.SH'
        ],
        [
            'attribute' => 'model.name',
            'label' => 'Mashina modeli'
        ],
        'color',
        'position',
        'number',
        'status:status',
        'description',
//              'created_by',
//              'updated_by',
//              'created_at',
//              'updated_at',
    ],
]) ?>