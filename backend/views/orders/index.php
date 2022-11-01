<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
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
    'bulkButtonsTemplate' => '{delete}',
    'bulkButtons' => [
        'delete' => [
            /** @see soft\widget\button\BulkButton for other configurations */
        ],
    ],
    'cols' => [
        'id',
        [
            "attribute" => "order_type",
            "value" => "orderTypeLabel",
            'filter' => \common\models\Orders::getTypeList(),
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
            "attribute" => "client_id",
            "value" => "clientFullname",
            'filter' => map(\common\models\Clients::find()->all(), "id", 'full_name'),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '220px'
                ],
            ],
        ],

//        'client_fullname',
        'amount:integer',
        [
            "attribute" => "payment_type",
            "value" => "paymentType.name",
            'filter' => map(\common\models\PaymentTypes::find()->all(), "id", 'name'),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '220px'
                ],
            ],
        ],
        'name',
        [
            "attribute" => "status",
            "value" => "statusLabel",
            'filter' => \common\models\Orders::getStatusList(),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100px'
                ],
            ],
        ],
        //'client_phone',
        //'client_address',
        //'delivery_type',
        //'delivery_price',
        //'network_id',
        //'credit_file',
        //'partner_order_id',
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
    