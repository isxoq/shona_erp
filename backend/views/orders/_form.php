<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;
use soft\widget\kartik\InputType;

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
                    'options' => [
                        'data' => map(\common\models\Clients::find()->all(), 'id', 'full_name'),
                        "pluginEvents" => [
                            "change" => "function() { {$client_change_event} }",
                        ]
                    ],
                ],
                'client_fullname',
                'client_phone:phone',
                'client_address',
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
                        'data' => map(\common\models\PaymentTypes::find()->all(), 'id', 'name')
                    ]
                ],

                'amount' => [
                    "name" => "amount",
                    "title" => t("Hamkordan olingan narx"),
                    "type" => InputType::WIDGET,
                    "widgetClass" => \kartik\money\MaskMoney::class,
                    "options" => [
                        'pluginOptions' => [
                            'prefix' => 'UZS ',
                            'affixesStay' => true,
                            'thousands' => ',',
                            'decimal' => '.',
                            'precision' => 2,
                            'allowZero' => false,
                            'allowNegative' => false,
                        ]
                    ]
                ],
                'delivery_type:select2' => [
                    'options' => [
                        'data' => map(\common\models\DeliveryTypes::find()->all(), 'id', 'name')
                    ]
                ],
                'delivery_price' => [
                    "name" => "delivery_price",
                    "title" => t("Yetkazish narxi"),
                    "type" => InputType::WIDGET,
                    "widgetClass" => \kartik\money\MaskMoney::class,
                    "options" => [
                        'pluginOptions' => [
                            'prefix' => 'UZS ',
                            'affixesStay' => true,
                            'thousands' => ',',
                            'decimal' => '.',
                            'precision' => 2,
                            'allowZero' => false,
                            'allowNegative' => false,
                        ]
                    ]
                ],
                'network_id:select2' => [
                    'options' => [
                        'data' => map(\common\models\NetworkTypes::find()->all(), 'id', 'name')
                    ]
                ],

                'status:dropdownList' => [
                    'items' => \common\models\Orders::getStatusList()
                ],

//                'order_type',
//                'credit_file',
                'partner_order_id',
                'name',
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
                        'max' => 4,
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
                                    'data' => \soft\helpers\ArrayHelper::map(\common\models\Products::find()->asArray()->all(), 'id', 'name'),
                                    "options" => [
                                        "placeholder" => t("Tanlang...")
                                    ]
                                ]
                            ],
                            [
                                'name' => 'product_source',
                                'type' => 'dropDownList',
                                'title' => t("Ombor"),
                                "options" => [
                                    'prompt' => '- Tanlang -',
                                    'onchange' => <<< JS
if ($(this).val() == 0){
$(this).parent().parent().parent().find(".list-cell__partner_shop_price  input").attr("disabled",true)    
$(this).parent().parent().parent().find(".list-cell__sold_price  input").attr("disabled",true)    
$(this).parent().parent().parent().find(".list-cell__partner_shop_payed").find(".bootstrap-switch").addClass("bootstrap-switch-disabled")    

}else{
    $(this).parent().parent().parent().find(".list-cell__partner_shop_price  input").attr("disabled",false)    
$(this).parent().parent().parent().find(".list-cell__sold_price  input").attr("disabled",false)    
$(this).parent().parent().parent().find(".list-cell__partner_shop_payed").find(".bootstrap-switch").removeClass("bootstrap-switch-disabled")    
}


JS,
                                ],
                                'items' => array_merge([
                                    0 => t("Asosiy ombor")
                                ], \soft\helpers\ArrayHelper::map(\common\models\PartnerShops::find()->asArray()->all(), 'id', 'name')),
                            ],
                            [
                                "name" => "partner_shop_price",
                                "title" => t("Hamkordan olingan narx"),
                                "type" => \kartik\money\MaskMoney::class,
                                "options" => [
                                    'pluginOptions' => [
                                        'prefix' => 'UZS ',
                                        'affixesStay' => true,
                                        'thousands' => ',',
                                        'decimal' => '.',
                                        'precision' => 2,
                                        'allowZero' => false,
                                        'allowNegative' => false,
                                    ]
                                ]
                            ],
                            [
                                "name" => "sold_price",
                                "title" => t("Mijozga sotilgan narx"),
                                "type" => \kartik\money\MaskMoney::class,
                                "options" => [
                                    'pluginOptions' => [
                                        'prefix' => 'UZS ',
                                        'affixesStay' => true,
                                        'thousands' => ',',
                                        'decimal' => '.',
                                        'precision' => 2,
                                        'allowZero' => false,
                                        'allowNegative' => false,
                                    ]
                                ]
                            ],
                            [
                                "name" => "partner_shop_payed",
                                "title" => "Hamkorga to'lov qilinganligi",
                                "type" => \kartik\widgets\SwitchInput::class,
                                "options" => [
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
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

