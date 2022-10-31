<?php


/* @var $this soft\web\View */
/* @var $model common\models\ProductImports */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Imports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'product_id', 
              'partner_id', 
              'import_price', 
              'currency_price', 
              'import_price_uzs', 
              'quantity', 
              'is_deleted', 
              'deleted_at', 
              'deleted_by', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>