<?php


/* @var $this soft\web\View */
/* @var $model common\models\Driver */

$this->title = $model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Haydovchilar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'panel' => $this->isAjax ? false : [],
    'attributes' => [
        'first_name',
        'last_name',
        'phone',
        [
            'attribute' => 'imageUrl',
            'label' => Yii::t('app', 'Image'),
            'format' => ['image', ['width' => '60px']]
        ],
//        'created_by',
//        'updated_by',
//        'created_at',
//        'updated_at',
    ],
]) ?>