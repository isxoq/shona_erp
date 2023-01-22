<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\ProductImportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Product Imports');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'export' => [
        'fontAwesome' => true
    ], 'exportConfig' => [
        'xlsx' => [],
    ],

    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
        ]
    ],
    'bulkButtonsTemplate' => '{delete}',
    'bulkButtons' => [
        'delete' => [
            /** @see soft\widget\button\BulkButton for other configurations */
        ],
    ],
    'cols' => [
        'id',
        [
            "attribute" => "product_id",
            "value" => "product.name",
            'filter' => map(\common\models\Products::find()->all(), 'id', 'name'),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '220px'
                ],
            ],
        ],

        [
            "attribute" => "partner_id",
            "value" => "partner.name",
            'filter' => map(\common\models\PartnerShops::find()->all(), 'id', 'name'),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '220px'
                ],
            ],
        ],
        'import_price',
        'currency_price',
        //'import_price_uzs',
        //'quantity',
        //'is_deleted',
        //'deleted_at',
        //'deleted_by',
        //'created_at',
        //'updated_at',
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
    