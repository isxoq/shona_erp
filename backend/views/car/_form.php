<?php

use common\models\CarModel;
use common\models\Driver;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\Car */

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
        'driver_id:select2' => [
            'options' => [
                'data' => map(Driver::find()->all(), 'id', 'fullName')
            ]
        ],
        'model_id:select2' => [
            'options' => [
                'data' => map(CarModel::find()->where(['status' => 1])->all(), 'id', 'name')
            ]
        ],
        'color',
        'position',
        'number',
        'description:textarea' => [
            'options' => [
                'rows' => 6
            ]
        ],
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

