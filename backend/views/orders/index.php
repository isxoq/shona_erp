<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>


<?php if (Yii::$app->session->hasFlash("alreadyAccepted")): ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Diqqat!</h5>
        <?= Yii::$app->session->getFlash("alreadyAccepted") ?>
    </div>
<?php endif ?>


<?php if (Yii::$app->session->hasFlash("successfullyAccepted")): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Alert!</h5>
        <?= Yii::$app->session->getFlash("successfullyAccepted") ?>
    </div>
<?php endif ?>


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
        'created_at',
        "delivery_code",
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
            "label" => "Foyda",
            "value" => function ($model) {
                return Yii::$app->formatter->asSum($model->benefit);
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
        [
            "attribute" => "status",
            "value" => function ($model) {
                $btn = Html::a($model->statusBtn, ["/orders/change-status", "id" => $model->id], [
                    "role" => "modal-remote",
                    "class" => "badge badge-info btn-small class-color-{$model->status}"
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
        [
            "attribute" => "taminotchi_id",
            "visible" => Yii::$app->user->identity->checkRoles(["Ta'minotchi"]),
            "value" => function ($model) {
                $btn = Html::a("Qabul", ["/orders/accept-order", "id" => $model->id], [
//                    "role" => "modal-remote",
                    "class" => "btn btn-success"
                ]);

                if ($model->taminotchi_id) {
                    if ($model->taminotchi_id == user("id")) {
                        return "Zakaz qabul qilingan";
                    } else {
                        return "Bu boshqaning buyurtmasi";
                    }
                }

                return $btn;
            },
            "format" => "raw",
        ],
        'actionColumn' => [
            "template" => "{update} {delete}",
            'viewOptions' => [
                'role' => 'modal-remote',
                "class" => "btn btn-info"
            ],
            'updateOptions' => [
                "class" => "btn btn-warning"
            ],
            'deleteOptions' => [
                'role' => 'modal-remote',
                "class" => "btn btn-danger",
            ],
            'visibleButtons' => [
                'delete' => function ($model) {
                    return Yii::$app->user->identity->checkRoles(["Rahbar", "admin"]);
                },
            ]
        ],

    ],
]); ?>
    