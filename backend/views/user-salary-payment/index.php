<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\UserSalaryPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Salary Payments');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
$filtered = map(\common\models\User::find()->all(), "id", 'fullName');

?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{refresh}',
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
        'id',
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
                    "allowClear"=>true,
                    'width' => '100px'
                ],
            ],
        ],
//        'date',
        [
            "attribute" => "created_at",
            'format' => 'dateTimeUz',
            'filterType' => \soft\widget\kartik\DateRangePicker::class,
            "filterWidgetOptions" => [
                "initDefaultRangeExpr" => true,
                "pluginOptions" => [

                    "autocomplete" => "off"
                ]
            ],
        ],
        'amount:integer',
        'payment_type',
        //'updated_at',
        //'comment:ntext',
        'actionColumn' => [
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
            'updateOptions' => [
                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
    