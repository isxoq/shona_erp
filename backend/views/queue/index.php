<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\QueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Queues');
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
                    'id',
            'doctor_id',
            'patient_id',
            'date',
            'time',
            //'first_name',
            //'last_name',
            //'father_name',
            //'birth_date',
            //'gender',
            //'province_id',
            //'region_id',
            //'address:ntext',
            //'phone',
            //'type',
            //'sale',
            //'old_price',
            //'price',
            //'is_payed',
            //'description:ntext',
            //'status',
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
    