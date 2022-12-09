<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\ProductsStoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ombor mahsulotlari');
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
            'modal' => true,
        ]
    ],
    'cols' => [
//        'id',
        'name',
        [
            "label" => t("Soni"),
            "value" => function ($model) {
                return $model->getProductToStores()->sum("quantity");
            }
        ],
    ],
]); ?>
    