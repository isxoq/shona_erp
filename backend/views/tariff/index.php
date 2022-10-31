<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\search\TariffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tariffs';
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
                    //'id',
            'minimum_km',
            'minimum_sum',
            'km_sum',
            [
                'attribute' => 'status',
                'format' => 'status',
                'filter' => [
                    1 => 'Faol',
                    0 => 'Faol emas',
                ],

            ],
            //'outra_city_km_sum',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
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
    