<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\ProductsStoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ombor mahsulotlari');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}{exportData}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            "content" => "Omborga qo'shish",
            'modal' => true,
        ],
        'exportData' => [
            /** @see soft\widget\button\Button for other configurations */
            "content" => Html::button('<i class="fas fa-download"></i>', [
                'class' => 'btn btn-success',
                'title' => Yii::t('app', 'Add Book'),

            ]),
            "url" => 'store/export-data',
            "pjax" => false
//            'modal' => true,
        ]
    ],
    'cols' => [
//        'id',
        'name',
        [
            "label" => t("Jami import qilingan"),
            "value" => function ($model) {
                return $model->getProductToStores()->sum("quantity");
            }
        ],
        [
            "label" => t("Jami sotilgan"),
            "value" => function ($model) {
                return $model->salesCount;
            }
        ],
        [
            "label" => t("Omborda qolgan"),
            "value" => function ($model) {
                return $model->getProductToStores()->sum("quantity") - $model->salesCount;
            }
        ],
    ],
]); ?>
    