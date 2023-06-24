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
        ]
    ],
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), [
        'visible' => !$this->isAjax,
        "data-loading-text" => "<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order"
    ]) ?>
</div>
<script>

    $('.btn').on('click', function () {
        var $this = $(this);
        $this.button('loading');
    });


</script>
<?php ActiveForm::end(); ?>

