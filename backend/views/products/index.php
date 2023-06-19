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
    'toolbarTemplate' => '{import}{create}{refresh}',
    'toolbarButtons' => [
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
            "content" => t("Import"),
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
    