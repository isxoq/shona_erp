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
//        'id',
        'name',
//        'phone',
//        'phone',
        'imported' => [
            "label" => "Jami omborga Import",
            "value" => function ($model) {
                return Yii::$app->formatter->asDollar($model->importedAmount['usd'] + $model->base_imported);
            }
        ],
        'monthlySales' => [
            "label" => "Jami yo'l-yo'lakay sotuv",
            "value" => function ($model) {
                return Yii::$app->formatter->asDollar($model->notPayedSales + $model->base_order_sold);
            }
        ],
        'payedAmount' => [
            "label" => "To'langan",
            "value" => function ($model) {
                return Yii::$app->formatter->asDollar($model->payedAmount);
            }
        ],
        'debtAmount' => [
            "label" => "Qarz",
            "value" => function ($model) {
                return Yii::$app->formatter->asDollar($model->debtAmount + $model->base_debt);
            }
        ],
//        'address',
//        'email:email',
        //'is_deleted',
        //'deleted_at',
        //'deleted_by',
        //'created_at',
        //'updated_at',
        //'currency',
        [
            "label" => "Hamkorga to'lov",
            "value" => function ($model) {
                $btn = Html::a("To'lov qilish", ["/debt/pay-debt", "id" => $model->id], [
                    "role" => "modal-remote",
                    "class" => "btn btn-warning"
                ]);

                if (!$model->is_main) {
                    return $btn;
                } else {
                    return "";
                }


            },
            "format" => "raw",
        ],
    ],
]); ?>
    