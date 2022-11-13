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
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

