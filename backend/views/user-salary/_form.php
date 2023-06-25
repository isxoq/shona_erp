<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\UserSalary */

?>


    <?php $form = ActiveForm::begin(); ?>

    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
                  'user_id',
              'month',
              'year',
              'amount',
              'comment',
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

