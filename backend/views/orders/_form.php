<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;
use soft\widget\kartik\InputType;
use \yii\web\JsExpression;

/* @var $this soft\web\View */
/* @var $model common\models\Orders */


$client_change_event = <<<JS



let client_id = $(this).val()

$.ajax("get-client-info",{
    type:"GET",
    data:{
        id:client_id
    },
    success:function(data) {
      console.log(data)
        $("#orders-client_fullname").val(data.full_name)
        $("#orders-client_phone").val(data.phone)
        $("#orders-client_address").val(data.address)
    }
})


JS;

$client_unselect_event = <<<JS
          $("#orders-client_fullname").val("")
        $("#orders-client_phone").val("")
        $("#orders-client_address").val("")
JS;

$client_select_event = <<<JS
JS;


$clientformatJs = <<< 'JS'
var clientformatRepo = function (repo) {
    if (repo.loading) {
        return repo.text;
    }
    var markup =
        '<div style="margin-left:5px">' + repo.full_name + '</div>' + 
        '<div style="margin-left:5px">' + repo.phone + '</div>'
;
    if (repo.description) {
      markup += '<p>' + repo.description + '</p>';
    }
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var clientformatRepoSelection = function (repo) {
    return repo.full_name;
}
JS;


$productformatJs = <<< 'JS'
var productformatRepo = function (repo) {
    if (repo.loading) {
        return repo.text;
    }
    var markup =        '<div style="margin-left:5px">' + repo.name + '</div>';
    if (repo.description) {
      markup += '<p>' + repo.description + '</p>';
    }
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var productformatRepoSelection = function (repo) {
    return repo.name;
}
JS;


// script to parse the results into the format expected by Select2
$resultsJs = <<< JS
function (data, params) {
    params.page = params.page || 1;
    return {
        results: data.items,
        pagination: {
            more: (params.page * 30) < data.total_count
        }
    };
}
JS;
// render your widget


// Register the formatting script

$clientFrontJS = <<<JS

        $(document).ready(function() {
            // Loop through each div with the class 'myDiv'
            setTimeout(function() {
              $("#select2-orders-client_id-container").text($("#orders-client_fullname").val())
              
              
              $(".multiple-input-list__item").each(function() {
                  
                  $(this).find(".select2-selection__rendered").text($(this).find(".productName").val())
                  
              })
              
              
              
            },1000)
        });
JS;


$this->registerJs($clientFrontJS, \soft\web\View::POS_END);
$this->registerJs($clientformatJs, \soft\web\View::POS_HEAD);
$this->registerJs($productformatJs, \soft\web\View::POS_HEAD);


?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        "client_detail" => [
            'label' => "Mijoz ma'lumotlari",
            'labelSpan' => 2,
            "labelOptions" => [
                "class" => "text-primary"
            ],
            'columns' => 4,
            'attributes' => [
                'client_id:select2' => [
                    "options" => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Operator", "Diller"]),
                        "pluginEvents" => [
                            "change" => "function() { {$client_change_event} }",
                            "select2:unselect" => "function() { {$client_unselect_event} }",
                            "select2:select" => "function() { {$client_select_event} }"
                        ],
                        'initValueText' => "test",
                        'options' => [
                            'placeholder' => 'Qidiruv ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'ajax' => [
                                'url' => "/admin/search/clients",
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                'processResults' => new JsExpression($resultsJs),
                                'cache' => true
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('clientformatRepo'),
                            'templateSelection' => new JsExpression('clientformatRepoSelection'),
                        ],
                    ]
                ],
//                'client_id:select2' => [
//                    'options' => [
//                        "disabled" => !Yii::$app->user->identity->checkRoles(["Operator", "Diller"]),
//                        'data' => map(\common\models\Clients::find()->all(), 'id', 'full_name'),
//                        "pluginEvents" => [
//                            "change" => "function() { {$client_change_event} }",
//                            "select2:unselect" => "function() { {$client_unselect_event} }",
//                            "select2:select" => "function() { {$client_select_event} }"
//                        ]
//                    ],
//                ],
                'client_fullname' => [
                    "options" => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Operator", "Diller"])
                    ]
                ],
                'client_phone:phone',
                'client_address' => [
                    "options" => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Operator", "Diller"])
                    ]
                ],
            ]
        ],
        "order_details" => [
            'label' => "Buyurtma ma'lumotlari",
            'labelSpan' => 2,
            "labelOptions" => [
                "class" => "text-primary"
            ],
            'columns' => 4,
            'attributes' => [
                'payment_type:select2' => [
                    'options' => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Operator", "Diller"]),
                        'data' => map(\common\models\PaymentTypes::find()->all(), 'id', 'name')
                    ]
                ],

                'amount' => [
                    "name" => "amount",
                    "title" => t("Hamkordan olingan narx"),
                    "type" => InputType::WIDGET,
                    "widgetClass" => \kartik\money\MaskMoney::class,
                    "options" => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Operator", "Diller"]),
                        'pluginOptions' => [
                            'prefix' => 'UZS ',
                            'affixesStay' => true,
                            'thousands' => ' ',
                            'decimal' => '.',
                            'precision' => 0,
                            'allowZero' => false,
                            'allowNegative' => false,
                        ]
                    ]
                ],
                'delivery_type:select2' => [
                    'options' => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Ta'minotchi"]),
                        'data' => map(\common\models\DeliveryTypes::find()->all(), 'id', 'name')
                    ]
                ],
                'delivery_price' => [
                    "name" => "delivery_price",
                    "title" => t("Yetkazish narxi"),
                    "type" => InputType::WIDGET,
                    "widgetClass" => \kartik\money\MaskMoney::class,
                    "options" => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Ta'minotchi"]),
                        'pluginOptions' => [
                            'prefix' => 'UZS ',
                            'affixesStay' => true,
                            'thousands' => ' ',
                            'decimal' => '.',
                            'precision' => 0,
                            'allowZero' => false,
                            'allowNegative' => false,
                        ]
                    ]
                ],
                "delivery_code",
                'network_id:select2' => [
                    'options' => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Operator", "Diller"]),
                        'data' => map(\common\models\NetworkTypes::find()->all(), 'id', 'name')
                    ]
                ],

                'status:dropdownList' => [
                    'items' => \common\models\Orders::getStatusForRole() ?? []
                ],

//                'order_type',
//                'credit_file',
                'partner_order_id' => [
                    "options" => [
                        "disabled" => !Yii::$app->user->identity->checkRoles(["Operator", "Diller"]),
                    ]
                ],
                'name',
            ]
        ],
        "partner_fees" => [
            'label' => "Homiy to'lovlari",
            'labelSpan' => 2,
            "labelOptions" => [
                "class" => "text-primary"
            ],
            'attributes' => [
                "partner_fees" => [
                    "attribute" => "partner_fees",
                    "label" => "Homiy to'lovlarini qo'shish",
                    'type' => InputType::WIDGET,
                    'widgetClass' => \unclead\multipleinput\MultipleInput::class,
                    'options' => [
                        "iconSource" => \unclead\multipleinput\MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        'max' => 10,
                        'min' => 0,
                        "iconMap" => [
                            'fa' => [
                                'drag-handle' => 'fa fa-bars',
                                'remove' => 'fa fa-times',
                                'add' => 'fa fa-plus',
                                'clone' => 'fa fa-copy',
                            ],
                        ],
                        'cloneButton' => true,
                        'columns' => [
                            [
                                'name' => 'payment_type',
                                'type' => \kartik\widgets\Select2::class,
                                'title' => t("Homiy"),
                                "options" => [
                                    'data' => \soft\helpers\ArrayHelper::map(\common\models\PaymentTypes::find()->all(), 'id', 'name'),
                                    "options" => [
                                        "width" => "30px",
                                        "placeholder" => t("Tanlang...")
                                    ]
                                ]
                            ],
                            [
                                'name' => 'amount',
                                'type' => InputType::TEXT,
                                "options" => [
                                    "width" => "300px",
                                ],
                                'title' => t("Summa"),
                            ]
                        ]
                    ]
                ]
            ]
        ],
        "order_products" => [
            'label' => "Mahsulotlar",
            'labelSpan' => 2,
            "labelOptions" => [
                "class" => "text-primary"
            ],
            'attributes' => [
                "order_products" => [
                    "attribute" => "order_products",
                    "label" => "Buyurtma mahsulotlarini qo'shish",
                    'type' => InputType::WIDGET,
                    'widgetClass' => \unclead\multipleinput\MultipleInput::class,
                    'options' => [
                        "iconSource" => \unclead\multipleinput\MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        'max' => 10,
                        "iconMap" => [
                            'fa' => [
                                'drag-handle' => 'fa fa-bars',
                                'remove' => 'fa fa-times',
                                'add' => 'fa fa-plus',
                                'clone' => 'fa fa-copy',
                            ],
                        ],
                        'cloneButton' => true,
                        'columns' => [
                            [
                                'name' => 'product_id',
                                'type' => \kartik\widgets\Select2::class,
                                'title' => t("Mahsulot"),
                                "options" => [
                                    'options' => [
                                        'placeholder' => 'Qidiruv ...',
                                    ],
                                    'pluginOptions' => [

                                        'allowClear' => true,
                                        'minimumInputLength' => 3,
                                        'ajax' => [
                                            'url' => "/admin/search/products",
                                            'dataType' => 'json',
                                            'delay' => 250,
                                            'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                            'processResults' => new JsExpression($resultsJs),
                                            'cache' => true
                                        ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('productformatRepo'),
                                        'templateSelection' => new JsExpression('productformatRepoSelection'),
                                    ],
                                ],
                                'headerOptions' => ['style' => 'width:350px; white-space:normal;word-break: break-word;'],
                            ],
                            [
                                "name" => "product_name",
                                "value" => function ($model) {
                                    return $model?->product?->name;
                                },
                                "options" => [
                                    "class" => "productName d-none"
                                ],
                            ],
                            [
                                'name' => 'count',
                                'type' => InputType::TEXT,
                                "options" => [
                                    "width" => "300px",
                                ],
                                'title' => t("Mahsulot soni"),
                            ],
                            [
                                'name' => 'product_source',
                                'headerOptions' => ['style' => 'width:150px; white-space:normal;word-break: break-word;'],

                                'type' => 'dropDownList',
                                'title' => t("Ombor"),
                                "options" => [
                                    "readonly" => !Yii::$app->user->identity->checkRoles(["Ta'minotchi"]),
                                    'prompt' => '- Tanlang -',
                                ],
                                'items' => \soft\helpers\ArrayHelper::map(\common\models\PartnerShops::find()->all(), 'id', 'name'),
                            ],
                            [
                                "name" => "currency_partner_price",
                                "title" => t("Hamkordan olingan narx $"),
//                                "type" => \kartik\money\MaskMoney::class,
                                'headerOptions' => ['style' => 'width:100px; white-space:normal;word-break: break-word;'],

                                "options" => [
                                    "readonly" => !Yii::$app->user->identity->checkRoles(["Ta'minotchi"]),
//                                    'pluginOptions' => [
//                                        'prefix' => 'UZS ',
//                                        'affixesStay' => true,
//                                        'thousands' => ' ',
//                                        'decimal' => '.',
//                                        'precision' => 0,
//                                        'allowZero' => false,
//                                        'allowNegative' => false,
//                                    ]
                                ]
                            ],
                            [
                                "name" => "sold_price",
                                "title" => t("Mijozga sotilgan narx UZS"),
//                                "type" => \kartik\money\MaskMoney::class,
                                'headerOptions' => ['style' => 'width:200px; white-space:normal;word-break: break-word;'],

                                "options" => [
                                    "readonly" => !Yii::$app->user->identity->checkRoles(["Operator"]),
//                                    'pluginOptions' => [
//                                        'prefix' => 'UZS ',
//                                        'affixesStay' => true,
//                                        'thousands' => ' ',
//                                        'decimal' => '.',
//                                        'precision' => 0,
//                                        'allowZero' => false,
//                                        'allowNegative' => false,
//                                    ]
                                ]
                            ],
                            [
                                "name" => "partner_shop_payed",
                                "title" => "Hamkorga to'lov qilinganligi",
                                "type" => \kartik\widgets\SwitchInput::class,

                                "options" => [
                                    "readonly" => !Yii::$app->user->identity->checkRoles(["Ta'minotchi"]),
                                    'pluginOptions' => [
                                        'onText' => t("Ha"),
                                        'offText' => t("Yo'q"),
                                        'onColor' => 'success',
                                        'offColor' => 'danger',
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ]
    ]
]); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', "Save"), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

