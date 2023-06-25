<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\UserSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Salaries');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();

$filtered = map(\common\models\User::find()->all(), "id", 'fullName');


?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{calculate-salary}{create}{refresh}',
    'toolbarButtons' => [
        'calculate-salary' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            "url" => ["calculate-salary"],
            "cssClass" => "mr-1 btn btn-success",
            "type" => \soft\widget\button\Button::TYPE_LINK,
            "content" => t("Oylikni hisoblash"),
        ],
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
        [
            "attribute" => "user_id",
            "value" => function ($model) {
                return $model?->user?->fullName;
            },
            'filter' => $filtered,
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    "allowClear" => true,
                    'width' => '100px'
                ],
            ],
        ],
        [
            "attribute" => "month",
            "value" => function ($model) {
                return date("M", strtotime("01.{$model->month}.{$model->year}"));
            },
            'filter' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    "allowClear" => true,
                    'width' => '100px'
                ],
            ],
        ],
        [
            "attribute" => "year",
            "value" => function ($model) {
                return $model->year;
            },
            'filter' => [2023, 2024],
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    "allowClear" => true,
                    'width' => '100px'
                ],
            ],
        ],
//        'month',
        'amount:integer',
        'payedAmount:integer',
        [
            "label" => "Oylik to'lash",
            "value" => function ($model) {

                $btn = Html::a("<i class='fa fa-money-bill'></i>", ["/user-salary/pay", "id" => $model->id], [
                    "role" => "modal-remote",
                    "class" => "btn btn-primary"
                ]);
                return $btn;

            },
            "format" => "raw",
        ],
        //'comment:ntext',
        //'created_at',
        //'updated_at',
//        'actionColumn' => [
//            'viewOptions' => [
//                'role' => 'modal-remote',
//            ],
//            'updateOptions' => [
//                'role' => 'modal-remote',
//            ],
//        ],
    ],
]); ?>
    