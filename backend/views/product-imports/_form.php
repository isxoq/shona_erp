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
                'data' => map(\common\models\Products::find()->all(), 'id', 'name')
            ]
        ],
        'partner_id:select2' => [
            'options' => [
                'data' => map(\common\models\PartnerShops::find()->all(), 'id', 'name')
            ]
        ],
        'import_price:number',
        'currency_price:number',
        'import_price_uzs:number',
        'quantity',
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

