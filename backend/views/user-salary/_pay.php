<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;
use soft\widget\kartik\InputType;

/* @var $this soft\web\View */
/* @var $model common\models\Orders */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'pay_amount' => [
            "name" => "pay_amount",
            "title" => t("To'lov"),
            "type" => InputType::WIDGET,
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
        "pay_comment:textarea",
        'pay_type:dropdownList' => [
            'items' => [
                "Kartaga" => "Kartaga",
                "Naqd pul" => "Naqd pul",
            ]
        ],
    ]
]); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('site', "Ta'minotchiga o'tkazish"), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

