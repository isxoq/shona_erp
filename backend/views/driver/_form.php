<?php

use soft\helpers\Html;
use soft\widget\input\VisiblePasswordInput;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\Driver */

?>


<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'phoneField:phone',
        'password:widget' => [
            'widgetClass' => VisiblePasswordInput::class,
        ],
        'first_name',
        'last_name',
        'image:fileInput' => [
            'prepend' => $model->getImageHtmlView() . "<br>",
        ],
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

