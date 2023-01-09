<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\PartnerShops */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'name',
        'phone:phone',
        'address',
        'email',
        'is_main:status',
        'currency' => [
            "name" => "currency",
            "title" => t("Hamkordan olingan narx"),
            "type" => \soft\widget\kartik\InputType::WIDGET,
            "widgetClass" => \kartik\money\MaskMoney::class,
            "options" => [
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
        'base_imported' => [
            "name" => "base_imported",
            "title" => t("Jami omborga Import"),
            "type" => \soft\widget\kartik\InputType::WIDGET,
            "widgetClass" => \kartik\money\MaskMoney::class,
            "options" => [
                'pluginOptions' => [
                    'prefix' => '$ ',
                    'affixesStay' => true,
                    'thousands' => ' ',
                    'decimal' => '.',
                    'precision' => 1,
                    'allowZero' => false,
                    'allowNegative' => true,
                ]
            ]
        ],
        'base_order_sold' => [
            "name" => "base_order_sold",
            "title" => t("Jami yo'l-yo'lakay sotuv"),
            "type" => \soft\widget\kartik\InputType::WIDGET,
            "widgetClass" => \kartik\money\MaskMoney::class,
            "options" => [
                'pluginOptions' => [
                    'prefix' => '$ ',
                    'affixesStay' => true,
                    'thousands' => ' ',
                    'decimal' => '.',
                    'precision' => 1,
                    'allowZero' => false,
                    'allowNegative' => true,
                ]
            ]
        ],
        'base_debt' => [
            "name" => "base_debt",
            "title" => t("Qarz"),
            "type" => \soft\widget\kartik\InputType::WIDGET,
            "widgetClass" => \kartik\money\MaskMoney::class,
            "options" => [
                'pluginOptions' => [
                    'prefix' => '$ ',
                    'affixesStay' => true,
                    'thousands' => ' ',
                    'decimal' => '.',
                    'precision' => 1,
                    'allowZero' => false,
                    'allowNegative' => true,
                ]
            ]
        ],
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

