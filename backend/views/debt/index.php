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
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
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
                return Yii::$app->formatter->asDollar($model->importedAmount['usd']);
            }
        ],
        'monthlySales' => [
            "label" => "Jami yo'l-yo'lakay sotuv",
            "value" => function ($model) {
                return Yii::$app->formatter->asDollar($model->notPayedSales);
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
                return Yii::$app->formatter->asDollar($model->debtAmount);
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
    