<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel backend\models\search\HospitalAdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Hospital Admins');
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
        [
            'attribute' => 'hospital_id',
            'value' => 'hospital.name',
            'filter' => map(\backend\models\Hospital::find()->all(), 'id', 'name'),
            'filterType' => \soft\grid\GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => 'Tanlang..'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '220px'
                ],
            ],
        ],
//        'id',
        'username',
//        'auth_key',
//        'password_hash',
//        'password_reset_token',
        //'email:email',
        //'status',
        //'created_at',
        //'updated_at',
        'first_name',
        'last_name',
        'phone',
        [
            'attribute' => 'imageUrl',
            'label' => 'Rasm',
            'format' => ['image', ['width' => '60px']]
        ],
        //'type_id',
        //'father_name',
        //'birth_date',
        //'gender',
        //'province_id',
        //'region_id',
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
    