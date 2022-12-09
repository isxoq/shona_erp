<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\Expenses */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        "type:select2" => [
            "options" => [
                'data' => \soft\helpers\ArrayHelper::map(\common\models\ExpenseTypes::find()->asArray()->all(), 'id', 'name'),
            ]
        ],
        "staff_id:select2" => [
            "options" => [
                'data' => \soft\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'fullname'),
            ]
        ],
        'description:textarea',
        'amount' => [
            "name" => "amount",
            "title" => t("Harajat miqdori"),
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
        'is_affect_salary:status',
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

