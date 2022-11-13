<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\PaymentTypes */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'name',
        'type:dropdownList' => [
            "items" => [
                \common\models\PaymentTypes::TYPE_SIMPLE => t("Oddiy"),
                \common\models\PaymentTypes::TYPE_HAMKOR => t("Hamkor"),
            ]
        ],
//        'percent',
        'month_1',
        'month_3',
        'month_4',
        'month_6',
        'month_9',
        'month_12',
        'month_15',
        'month_18',
        'month_24',
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

