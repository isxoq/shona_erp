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
            "attribute" => "client_id",
            "value" => "clientFullname",
            'filter' => map(\common\models\Clients::find()->all(), "id", 'full_name'),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100px'
                ],
            ],
        ],
        "client.phone",
        "client.address",
        'amount:integer',
        [
            "label" => "Yetkazish",
            "value" => function ($model) {
                return $model->delivery->name . PHP_EOL . Yii::$app->formatter->asSum($model->delivery_price);
            }
        ],
        [
            "attribute" => "payment_type",
            "value" => "paymentType.name",
            'filter' => map(\common\models\PaymentTypes::find()->all(), "id", 'name'),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100px'
                ],
            ],
        ],
//        'name',
        [
            "attribute" => "status",
            "value" => function ($model) {
                $btn = Html::a($model->statusBtn, ["/orders/change-status", "id" => $model->id], [
                    "role" => "modal-remote",
                    "class" => "btn btn-primary"
                ]);
                return $btn;
            },
            "format" => "raw",
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
        'actionColumn' => [
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
    