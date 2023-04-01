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
    'panel' => [
        'before' => $this->render("_panel", compact("filterSales", "filterBenefit")),
//        'footer' => true
    ],
    'toolbarTemplate' => '{exportData}{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
        ],
        'exportData' => [
            /** @see soft\widget\button\Button for other configurations */
            "content" => Html::button('<i class="fas fa-download"></i>', [
                'class' => 'btn btn-success',
                'title' => Yii::t('app', 'Export'),

            ]),
            "url" => ['orders/export-data',Yii::$app->request->queryParams],
            "pjax" => false
//            'modal' => true,
        ]
    ],
    'cols' => [
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return \soft\grid\GridView::ROW_COLLAPSED;
            },
            // uncomment below and comment detail if you need to render via ajax
            // 'detailUrl' => Url::to(['/site/book-details']),
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_order_products', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        'id',
        [
            "attribute" => "created_at",
            'format' => 'dateTimeUz',
            'filterType' => \soft\widget\kartik\DateRangePicker::class,
            "filterWidgetOptions" => [
                "initDefaultRangeExpr" => true,
                "pluginOptions" => [
                    "autocomplete" => "off"
                ]
            ],
        ],
        "delivery_code",
        [
            "attribute" => "operator_diller_id",
            "value" => function ($model) {
                return $model->operatorFullName;
            },
            'filter' => map(\common\models\User::find()->all(), "id", 'fullName'),
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
            "value" => function ($model) {
                return $model->taminotchiFullName;
            },
            'filter' => map(\common\models\User::find()->all(), "id", 'fullName'),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100px'
                ],
            ],
        ],
//        "",
        "client_phone",
        "client_address",
        'amount:integer',
        [
            "label" => "Yetkazish",
            "value" => function ($model) {
                if ($model->delivery) {
                    return $model->delivery->name . PHP_EOL . Yii::$app->formatter->asSum($model->delivery_price);
                } else {
                    return "";
                }
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
    