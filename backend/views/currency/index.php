<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\PartnerShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Partner Shops');
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
        'name',
        'currency',
        [
            "label" => "Harakat",
            "value" => function ($model) {
                $btn = Html::a("Kursni yangilash", ["/currency/edit", "id" => $model->id], [
                    "role" => "modal-remote",
                    "class" => "btn btn-info"
                ]);

                    return $btn;

            },
            "format" => "raw",
        ],
    ],
]); ?>
    