<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\PartnerShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Hamkorlardan qarzdorlik');
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
            'modal' => true,
        ],
        'exportData' => [
            /** @see soft\widget\button\Button for other configurations */
            "content" => Html::button('<i class="fas fa-download"></i>', [
                'class' => 'btn btn-success',
                'title' => Yii::t('app', 'Export'),

            ]),
            "url" => 'export-data',
            "pjax" => false
//            'modal' => true,
        ]
    ],
    'bulkButtonsTemplate' => '{delete}',
    'bulkButtons' => [
        'delete' => [
            /** @see soft\widget\button\BulkButton for other configurations */
        ],
    ],
    'cols' => [
        'name',
//        'imported' => [
//            "label" => "Jami omborga Import",
//            "value" => function ($model) {
//                return Yii::$app->formatter->asDollar($model->importedAmount['usd'] + $model->base_imported);
//            }
//        ],
        'allSales' => [
            "label" => "Haqdorlik",
            "value" => function ($model) {
                return Yii::$app->formatter->asSum($model->allSale);
            }
        ],
        'payedAmount' => [
            "label" => "To'langan",
            "value" => function ($model) {
                return Yii::$app->formatter->asSum($model->allPayed);
            }
        ],
        'debtAmount' => [
            "label" => "Hamkor qarzi",
            "value" => function ($model) {
                return Yii::$app->formatter->asSum($model->allSale - $model->allPayed);
            }
        ],
        [
            "label" => "Homiydan to'lov",
            "value" => function ($model) {
                $btn = Html::a("To'lov qabul qilish", ["/fee/pay-debt", "id" => $model->id], [
                    "role" => "modal-remote",
                    "class" => "btn btn-success"
                ]);
                return $btn;
            },
            "format" => "raw",
        ],
    ],
]); ?>
    