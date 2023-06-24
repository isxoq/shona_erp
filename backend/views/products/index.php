<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{product_export} {product_import} {import} {create} {refresh}',
    'toolbarButtons' => [
        'product_export' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            "url" => ["product-export"],
            "pjax" => false,
            "cssClass" => "mr-1 btn btn-info",
            "type" => \soft\widget\button\Button::TYPE_LINK,
            "content" => t("Mahsulotlar export"),
        ],
        'product_import' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
            "url" => ["product-import"],
            "cssClass" => "mr-1 btn btn-primary",
            "type" => \soft\widget\button\Button::TYPE_LINK,
            "content" => t("Mahsulotlar import"),
        ],
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
        ],
        'import' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
            "url" => ["import"],
            "cssClass" => "btn btn-success",
            "type" => \soft\widget\button\Button::TYPE_LINK,
            "content" => t("Ombor import"),
        ],
    ],
    'bulkButtonsTemplate' => '{delete}',
    'bulkButtons' => [
        'delete' => [
            /** @see soft\widget\button\BulkButton for other configurations */
        ],
    ],
    'cols' => [
        'id',
        'name',
        'ikpu',
        'package',
        'price_usd',
//            'is_deleted',
//            'deleted_at',
        //'deleted_by',
        'created_at',
        'updated_at',
        'actionColumn' => [
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
            'updateOptions' => [
                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
    