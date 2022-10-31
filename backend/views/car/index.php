<?php

use common\models\CarModel;
use common\models\Driver;
use kartik\grid\GridView;
use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\search\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mashinalar');
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
            'modal' => false,
        ]
    ],
    'bulkButtonsTemplate' => '{delete}',
    'bulkButtons' => [
        'delete' => [
            /** @see soft\widget\button\BulkButton for other configurations */
        ],
    ],
    'cols' => [
        [
            'attribute' => 'driver_id',
            'value' => 'driver.fullName',
            'filter' => map(Driver::find()->all(), 'id', 'fullName'),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '220px'
                ],
            ],
        ],
        [
            'attribute' => 'model_id',
            'value' => 'model.name',
            'filter' => map(CarModel::find()->where(['status' => 1])->all(), 'id', 'name')
        ],
        'color',
        'number',
        //'position',
        [
            'attribute' => 'status',
            'format' => 'status',
            'filter' => [
                1 => 'Faol',
                0 => 'Faol emas',
            ],

        ],
        //'description:ntext',
        //'created_by',
        //'updated_by',
        //'created_at',
        //'updated_at',
        'actionColumn' => [
        ],
    ],
]); ?>
    