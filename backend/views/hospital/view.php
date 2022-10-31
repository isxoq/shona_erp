<?php


/* @var $this soft\web\View */
/* @var $model backend\models\Hospital */

$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hospitals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= \soft\widget\bs4\TabMenu::widget([
    'items' => [
        [
            'label' => "Foydalanuvchilar",
            'url' => ['hospital-user/index', 'id' => $model->id],
        ],

        [
            'label' => "Yo'nalishlar",
            'url' => ['hospital-user/index', 'id' => $model->id],
        ],
    ]
]) ?>
<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'panel' => $this->isAjax ? false : [],
    'attributes' => [
        'id',
        'name',
        'logo',
        'image',
        'phone',
        'fax',
        'email',
        'address',
        'lat',
        'long',
        'status',
        'deleted',
    ],
]) ?>