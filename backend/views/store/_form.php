<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\ProductImports */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'product_id:select2' => [
            'options' => [
                'data' => map(\common\models\Products::find()->orderBy('created_at DESC')->all(), 'id', 'name')
            ]
        ],
        'partner_id:select2' => [
            'options' => [
                'data' => map(\common\models\PartnerShops::find()->all(), 'id', 'name'),
            ]
        ],
        'import_price' => [
            "name" => "import_price",
            "title" => t("Hamkordan olingan narx"),
            "type" => \soft\widget\kartik\InputType::WIDGET,
            "widgetClass" => \kartik\money\MaskMoney::class,
            "options" => [
                'pluginOptions' => [
                    'prefix' => '$ ',
                    'affixesStay' => true,
                    'thousands' => ' ',
                    'decimal' => '.',
                    'precision' => 0,
                    'allowZero' => false,
                    'allowNegative' => false,
                ]
            ]
        ],
        'quantity:number',
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

