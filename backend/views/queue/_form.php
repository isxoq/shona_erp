<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\Queue */

?>


    <?php $form = ActiveForm::begin(); ?>

    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
                  'doctor_id',
              'patient_id',
              'date',
              'time',
              'first_name',
              'last_name',
              'father_name',
              'birth_date',
              'gender',
              'province_id',
              'region_id',
              'address',
              'phone',
              'type',
              'sale',
              'old_price',
              'price',
              'is_payed',
              'description',
              'status',
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

