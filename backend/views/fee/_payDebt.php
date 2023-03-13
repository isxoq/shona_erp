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
        'payed_amount_fee' => [
            "name" => "payed_amount_fee",
            "title" => t("To'lov"),
            "type" => InputType::WIDGET,
            "widgetClass" => \kartik\money\MaskMoney::class,
            "options" => [
                'pluginOptions' => [
                    'prefix' => 'UZS ',
                    'affixesStay' => true,
                    'thousands' => ' ',
                    'decimal' => '.',
                    'precision' => 2,
                    'allowZero' => false,
                    'allowNegative' => false,
                ]
            ]
        ],
    ]
]); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('site', "Ta'minotchiga o'tkazish"), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

