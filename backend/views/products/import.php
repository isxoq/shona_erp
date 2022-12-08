<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\Products */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'file:elfinder' => [
            'options' => [
                'filter' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        ],
        "store_id:select2" => [
            'options' => [
                'data' => map(\common\models\PartnerShops::find()->all(), 'id', 'name')
            ]
        ]
    ],
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

