<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model backend\models\HospitalAdmin */

?>


<?php $form = ActiveForm::begin(); ?>

<?php echo $model->error ?>
<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'hospital_id:select2' => [
            'options' => [
                'data' => map(\backend\models\Hospital::find()->all(), 'id', 'name')
            ]
        ],

        'first_name',
        'last_name',
        'phone',
        'username',
        'password',
        'image:dosamigosFileImage' => [
            'options' => [
                'imgUrl' => $model->getImageUrl()
            ]
        ],
        'status:status',
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

