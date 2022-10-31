<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Haydovchilar';
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
        ]
    ],
    'bulkButtonsTemplate' => false,
    'cols' => [
        [
            'attribute' => 'imageUrl',
            'label' => 'Rasm',
            'format' => ['image', ['width' => '60px']]
        ],
        'first_name',
        'last_name',
        'phone',

        //'created_by',
        //'updated_by',
        'created_at',
        //'updated_at',
        'actionColumn' => [
        ],
    ],
]); ?>
    