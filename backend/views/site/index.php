<?php

/* @var $this soft\web\View */

use frontend\assets\VueAsset;
use \common\components\Statistics;

$this->title = 'Bosh sahifa';

//$this->registerJsFile('@web/js/home_page.js', ['depends' => VueAsset::class]);

?>
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-4 col-6">

            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= Statistics::newOrdersCount() ?></h3>
                    <p>Yangi zakazlar</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= Statistics::ordersCount() ?></h3>
                    <p>Jami zakazlar</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= Statistics::clientsCount() ?></h3>
                    <p>Jami mijozlar soni</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">

            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= \Yii::$app->formatter->asSum(Statistics::dateRevenue()) ?></h3>
                    <p>Oylik tushum (<?= date("m-Y") ?>)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>

</div>
